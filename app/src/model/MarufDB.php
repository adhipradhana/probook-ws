<?php
class MarufDB {
  private $host;
  private $dbName;
  private $dbUser;
  private $dbPassword;
  private $pdo;

  public function __construct() {
    $this->host = $_ENV['DB_HOST'];
    $this->dbName = $_ENV['DB_NAME'];
    $this->dbUser = $_ENV['DB_USERNAME'];
    $this->dbPassword = $_ENV['DB_PASSWORD'];
    $this->Connect();
  }

  private function Connect() {
    try {
      $this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbName, $this->dbUser, $this->dbPassword);
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
  }

  public function getUserId($token) {
    $query = $this->pdo->prepare("SELECT * FROM ActiveTokens WHERE token = ?");
    $query->execute(array($token));
    if ($query->rowCount() < 1) {
      return -1;
    } else {
      return $query->fetch()['user_id'];
    }
  }

  public function getUserIdByEmail($email) {
    $query = $this->pdo->prepare("SELECT * FROM Users WHERE email = ?");
    $query->execute(array($email));
    if ($query->rowCount() < 1) {
      return -1;
    } else {
      return $query->fetch()['id'];
    }
  }

  public function getUser($token) {
    $user_id = $this->getUserId($token);
    if ($user_id == -1) {
      return "";
    } else {
      $query = $this->pdo->prepare("SELECT * FROM Users WHERE id = ?");
      $query->execute(array($user_id));
      return $query->fetch();
    }
  }

  public function getUsername($token) {
    $user_id = $this->getUserId($token);
    if ($user_id == -1) {
      return "";
    } else {
      $query = $this->pdo->prepare("SELECT username FROM Users WHERE id = ?");
      $query->execute(array($user_id));
      return $query->fetch()['username'];
    }
  }

  public function getCardNumber($token) {
    $user_id = $this->getUserId($token);
    if ($user_id == -1) {
      return "";
    } else {
      $query = $this->pdo->prepare("SELECT cardnumber FROM Users WHERE id = ?");
      $query->execute(array($user_id));
      return $query->fetch()['cardnumber'];
    }
  }

  public function checkLogin($username, $password) {
    try {
      $query = $this->pdo->prepare("SELECT * FROM Users WHERE username = ? AND password = ?");
      $query->execute(array($username, md5($password)));
      if ($query->rowCount() > 0) {
        return $query->fetch()['id'];
      } else {
        return -1;
      }
    } catch (PDOException $e) {
      return -1;
    }
  }

  public function searchBook($title) {
    $query = $this->pdo->prepare("SELECT * FROM Books WHERE LOWER(title) LIKE LOWER(?)");
    $query->execute(array("%{$title}%"));
    return $query->fetchAll();
  }

  public function addToken($user_id, $token, $google_login) {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $expiration_timestamp = time() + (int)$_ENV['COOKIE_EXPIRED_TIME'];
    $query = $this->pdo->prepare("INSERT INTO ActiveTokens (user_id, token, user_agent, ip_address, expiration_timestamp, google_login) VALUES (?, ?, ?, ?, ?, ?)");
    $query->execute(array($user_id, $token, $user_agent, $ip_address, $expiration_timestamp, $google_login));
    return 1;
  }

  public function checkToken($token) {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $query = $this->pdo->prepare("SELECT expiration_timestamp FROM ActiveTokens WHERE token = ? AND user_agent = ? AND ip_address = ?");
    $query->execute(array($token, $user_agent, $ip_address));
    if ($query->rowCount() > 0) {
      $curTimestamp = time();
      if (time() < $query->fetch()['expiration_timestamp']) {
        return 1;
      } else {
        return $this->deleteToken($token);
      }
    } else {
      return 0;
    }
  }

  public function checkTokenUsingGoogle($token) {
    $query = $this->pdo->prepare("SELECT google_login FROM ActiveTokens WHERE token = ?");
    $query->execute(array($token));
    if ($query->rowCount() > 0) {
      return $query->fetch()['google_login'];
    } else {
      return 0;
    }
  }

  public function checkProfileComplete($token) {
    $user = $this->getUser($token);
    if ($user != "") {
      if (is_null($user['username'])) {
        return 0;
      } else {
        return 1;
      }
    } else {
      return 1;
    }
  }

  public function deleteToken($token) {
    $query = $this->pdo->prepare("DELETE FROM ActiveTokens WHERE token = ?");
    $query->execute(array($token));
    return 0;
  }

  public function validateUsername($username) {
    $query = $this->pdo->prepare("SELECT * FROM Users WHERE username = ?");
    $query->execute(array($username));
    if ($query->rowCount() > 0) {
      return 0;
    } else {
      return 1;
    }
  }

  public function validateEmail($email) {
    $query = $this->pdo->prepare("SELECT * FROM Users WHERE email = ?");
    $query->execute(array($email));
    if ($query->rowCount() > 0) {
      return 0;
    } else {
      return 1;
    }
  }

  public function orderBook($book_id, $user_id, $amount, $order_timestamp) {
    $query = $this->pdo->prepare("INSERT INTO Orders (user_id, book_id, amount, order_timestamp, is_review) VALUES (?, ?, ?, ?, 0)");
    $query->execute(array($user_id, $book_id, $amount, $order_timestamp));
    $query = $this->pdo->prepare("SELECT id FROM Orders WHERE book_id = ? AND user_id = ? ORDER BY id DESC LIMIT 1");
    $query->execute(array($book_id, $user_id));
    return $query->fetch()['id'];
  }

  public function addProfile($name, $username, $email, $password, $cardnumber, $address, $phonenumber) {
    if ($this->validateUsername($username) == 1 && $this->validateEmail($email) == 1){
      $query = $this->pdo->prepare("INSERT INTO Users (name, username, email, password, cardnumber, address, phonenumber) VALUES (?, ?, ?, ?, ?, ?, ?)");
      if (is_null($password)) {
        $query->execute(array($name, $username, $email, $password, $cardnumber, $address, $phonenumber));
      } else {
        $query->execute(array($name, $username, $email, md5($password), $cardnumber, $address, $phonenumber));
      }
      return 1;
    } else {
      return 0;
    }
  }

  public function completeProfile($id, $username, $password, $cardnumber, $address, $phonenumber) {
    if ($this->validateUsername($username) == 1) {
      try {
        $query = $this->pdo->prepare("UPDATE Users SET username = ?, password = ?, cardnumber = ?, address = ?, phonenumber = ? WHERE id = ?");
        $query->execute(array($username, md5($password), $cardnumber, $address, $phonenumber, $id));
        return 1;
      } catch (PDOException $e){
        return 0;
      }
    } else {
      return 0;
    }
  }

  public function editProfile($name, $address, $phonenumber, $cardnumber, $user_id) {
    try {
      $query = $this->pdo->prepare("UPDATE Users SET name = ?, address = ?, phonenumber = ?, cardnumber = ? WHERE id = ?");
      $query->execute(array($name, $address, $phonenumber, $cardnumber, $user_id));
      return 1;
    } catch (PDOException $e){
      return 0;
    }
  }

  public function getHistory($user_id) {
    $query = $this->pdo->prepare("SELECT Orders.id as order_id, book_id, order_timestamp, is_review, amount  FROM Orders WHERE user_id = ? ORDER BY Orders.id DESC");
    $query->execute(array($user_id));
    return $query->fetchAll();
  }

  public function getBookIdByOrderId($order_id) {
    $query = $this->pdo->prepare("SELECT book_id FROM Orders WHERE id = ?");
    $query->execute(array($order_id));
    return $query->fetch()['book_id'];
  }

  public function getBookDetail($book_id) {
    $query = $this->pdo->prepare("SELECT * FROM Books WHERE id = ?");
    $query->execute(array($book_id));
    return $query->fetch();
  }

  public function addReview($user_id, $username, $book_id, $rating, $comment, $order_id) {
    try {
      $query = $this->pdo->prepare("INSERT INTO Reviews (username, book_id, rating, comment, user_id) VALUES (?, ?, ?, ?, ?)");
      $query->execute(array($username, $book_id, $rating, $comment, $user_id));
      $query = $this->pdo->prepare("SELECT * FROM Books WHERE id = ?");
      $query->execute(array($book_id));
      $result = $query->fetch();
      $currVote = $result['vote'] + 1;
      $currRating = ($result['rating'] * $result['vote'] + $rating) / $currVote;
      $query = $this->pdo->prepare("UPDATE Books SET rating = ?, vote = ? WHERE id = ?");
      $query->execute(array($currRating, $currVote, $book_id));
      $query = $this->pdo->prepare("UPDATE Orders SET is_review = 1 WHERE id = ?");
      $query->execute(array($order_id));
      return 1;
    } catch (PDOException $e) {
      return 0;
    }
  }

  public function getReviews($book_id) {
    $query = $this->pdo->prepare("SELECT * FROM Reviews WHERE book_id = ? ORDER BY id DESC");
    $query->execute(array($book_id));
    return $query->fetchAll();
  }
}
