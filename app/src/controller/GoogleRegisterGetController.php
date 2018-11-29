<?php
class GoogleRegisterGetController implements ControllerInterface {
  public static function control(Request $request) {
    $email = $request->email;
    $db = new MarufDB();

    if ($db->validateEmail($email) == 0 && $db->checkProfileComplete($email) == 0) {
        // $JKWToken = new JKWToken();
        // $token = $JKWToken->generateJKWToken();
        // if ($db->addToken($user_id, $token, TRUE) == 1) {
        //   setcookie("token", $token, time() + (int)$_ENV['COOKIE_EXPIRED_TIME'], '/');
        //   header("Location: /");
        //   exit();
        // } else {
          return "<h1>{$email}</h1>";
        // }
    } else {
      header("Location: /login?redirected=1");
    }
    // $template = new Template('src/view/googleRegister.php');
    // $invalidUsername = (is_null($request->invalidUsername) ? False : $request->invalidUsername);
    // $invalidEmail = (is_null($request->invalidEmail) ? False : $request->invalidEmail);
    // return $template->render($invalidUsername, $invalidEmail);
  }
}
