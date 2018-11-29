<?php
class GoogleLoginPostController implements ControllerInterface {
  public static function control(Request $request) {
    $email = $request->email;
    $db = new MarufDB();

    if ($db->validateEmail($email) == 1) {
      $result = $db->addProfile(NULL, NULL, $email, NULL, NULL, NULL, NULL);
      if ($result == 0) {
        return '<h1>Failed</h1>';
      }
    }

    $JKWToken = new JKWToken();
    $token = $JKWToken->generateJKWToken();
    $user_id = $db->getUserIdByEmail($email);
    if ($db->addToken($user_id, $token, 1) == 1) {
      setcookie("token", $token, time() + (int)$_ENV['COOKIE_EXPIRED_TIME'], '/');
      header("Location: /");
      exit();
    } else {
      return '<h1>Failed</h1>';
    }
  }
}