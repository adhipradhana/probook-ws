<?php
class ReviewGetController implements ControllerInterface {
  public static function control(Request $request) {
    $db = new MarufDB();
    $token = $_COOKIE['token'];
    $order_id = $request->id;
    $book_id = $db->getBookIdByOrderId($order_id);

    $client = new SoapRequest();
    $book = $client->getBookDetail($book_id);
    $bookArray = array(
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

    $user_id = $db->getUserId($token);
    $username = $db->getUsername($token);
    $template = new Template('src/view/review.php');
    return $template->render($username, $bookArray, $user_id, $order_id);
  }
}
