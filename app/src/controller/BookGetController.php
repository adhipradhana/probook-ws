<?php
class BookGetController implements ControllerInterface {
  public static function control(Request $request) {
    $db = new MarufDB;
    $username = $db->getUsername($_COOKIE['token']);
    $client = new SoapClient('http://localhost:3000/bookws/book?wsdl', array('cache_wsdl' => WSDL_CACHE_NONE) );
    $book = $client->getBookDetail($request->id);

    if ($book->price == 0) {
      $book->price = "NOT FOR SALE";
    } else {
      $book->price = "Rp. " . $book->price;
    }

    $detail = array(
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

    $recommends = $client->getRecommendedBook($book->genre)->item;
    $detail_recommends = [];

    if ($recommends != null) {
      foreach ($recommends as $recommend) {
        $recommend->description = (strlen($recommend->description) > 300) ? substr($recommend->description,0,300).'...' : $recommend->description;

        if ($recommend->price == 0) {
          $recommend->price = "NOT FOR SALE";
        } else {
          $recommend->price = "Rp. " . $recommend->price;
        }

        $detail_recommend = array(
          "id" => $recommend->id,
          "title" => $recommend->title,
          "authors" => $recommend->author,
          "genre" => $recommend->genre,
          "image" => $recommend->image,
          "description" => $recommend->description,
          "rating" => $recommend->rating,
          "price" => $recommend->price,
          "rating_count" => $recommend->rating_count
        );

        array_push($detail_recommends, $detail_recommend);
      }
    }

    $reviews = $db->getReviews($book->id);
    $template = new Template('src/view/book.php');
    return $template->render($username, $detail, $detail_recommends, $reviews);
  }
}
