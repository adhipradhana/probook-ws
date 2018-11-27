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

  public static function order(Request $request) {
    $db = new MarufDB();
    $bookId = $request->bookId;
    $userId = $db->getUserId($_COOKIE['token']);
    $quantity = $request->quantity;
    return array(
      'orderNumber' => $db->orderBook($bookId, $userId, $quantity, time())
    );
  }

  public static function search(string $query) {
    $searchResult = [];
    $client = new SoapClient('http://localhost:3000/service/book?wsdl', array('cache_wsdl' => WSDL_CACHE_NONE) );
    $books = $client->searchBook($query)->item;
    foreach ($books as $book) {
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
