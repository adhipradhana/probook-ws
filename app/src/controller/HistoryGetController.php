<?php
class HistoryGetController implements ControllerInterface {
  public static function control(Request $request) {
    $template = new Template('src/view/history.php');
    $db = new MarufDB();
    $user_id = $db->getUserId($_COOKIE['token']);
    $orders = $db->getHistory($user_id);

    $client = new SoapClient('http://localhost:3000/bookws/book?wsdl', array('cache_wsdl' => WSDL_CACHE_NONE) );

    foreach($orders as &$order) {
      $book = $client->getBookDetail($order['book_id']);
      $order['title'] = $book->title;
      $order['image'] = $book->image;
    }

    $username = $db->getUsername($_COOKIE['token']);
    return $template->render($username, $orders);
  }
}
