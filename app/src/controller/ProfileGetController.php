<?php
class ProfileGetController implements ControllerInterface {
  public static function control(Request $request) {
    $template = new Template('src/view/profile.php');
    $db = new MarufDB;
    $user = $db->getUser($_COOKIE['token']);
    $totpUrl = "http://{$_ENV['BANK_URL']}/api/v1/totpQRCode?cardNumber={$user['cardnumber']}";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $totpUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec($curl));
    curl_close($curl);
    if ($result->{'status'} == 'success') {
      $qrCode = $result->{'qrCode'};
    } else {
      $qrCode = '';
    }
    return $template->render($user['id'], $user['name'], $user['username'], $user['email'], $user['cardnumber'], $user['address'], $user['phonenumber'], $qrCode);
  }
}
