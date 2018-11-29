<?php
class Api {
  public static function validateUsername(string $username) {
    $db = new MarufDB();
    return array('valid' => (bool) $db->validateUsername($username));
  }

  public static function validateEmail(string $email) {
    $db = new MarufDB();
    return array('valid' => (bool) $db->validateEmail($email));
  }

  public static function validateCardNumber(string $cardnumber) {
    $url = "http://{$_ENV['BANK_URL']}/api/v1/account?cardNumber={$cardnumber}";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec($curl));
    curl_close($curl);
    if ($result->{'status'} == 'success') {
      return array('valid' => True);
    } else {
      return array('valid' => False);
    }
  }

  public static function checkUsingGoogle() {
    $token = $_COOKIE['token'];
    $db = new MarufDB();
    return array('usingGoogle' => (bool) $db->checkTokenUsingGoogle($token));
  }

  public static function order(Request $request) {
    $db = new MarufDB();
    $otp = $request->otp;
    $bookId = $request->bookId;
    $cardNumber = $db->getCardNumber($_COOKIE['token']);
    $userId = $db->getUserId($_COOKIE['token']);
    $quantity = $request->quantity;

    $client = new SoapClient('http://localhost:3000/bookws/book?wsdl', array('cache_wsdl' => WSDL_CACHE_NONE) );
    $order = $client->purchaseBook($cardNumber, $bookId, $quantity, $otp);

    if ($order->status == 'success') {
      $orderNumber = $db->orderBook($bookId, $userId, $quantity, time());
    } else {
      $orderNumber = -1;
    }
    
    return array(
      'orderNumber' => $orderNumber,
      'message' => $order->message
    );
  }

  public static function search(string $query) {
    $searchResult = [];
    $client = new SoapClient('http://localhost:3000/bookws/book?wsdl', array('cache_wsdl' => WSDL_CACHE_NONE) );
    $books = $client->searchBook($query)->item;
    foreach ($books as $book) {
      if ($book->price == 0) {
        $book->price = "NOT FOR SALE";
      } else {
        $book->price = "Rp. " . $book->price;
      }

      $book->description = (strlen($book->description) > 300) ? substr($book->description,0,300).'...' : $book->description;

      $temp = array(
        "id" => $book->id,
        "title" => $book->title,
        "authors" => $book->author,
        "genre" => $book->genre,
        "image" => $book->image,
        "description" => $book->description,
        "rating" => $book->rating,
        "price" => $book->price,
        "rating_count" => $book->rating_count
      );
      array_push($searchResult,$temp);
    }
    return $searchResult;
  }
}
