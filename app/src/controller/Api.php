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

  public static function order(Request $request) {
    $db = new MarufDB();
    $bookId = $request->bookId;
    $userId = $db->getUserId($_COOKIE['token']);
    $quantity = $request->quantity;
    return array(
      'orderNumber' => $db->orderBook($bookId, $userId, $quantity, time())
    );
  }
}
