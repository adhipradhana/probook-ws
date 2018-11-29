<?php
class ProfileIncompleteMiddleware implements MiddlewareInterface {
  public function run(Request $request) {
    $token = $_COOKIE['token'];
    $db = new MarufDB();
    if ($db->checkProfileComplete($token) == 1) {
      header("Location: /");
      return False;
    } else {
      return True;
    }
  }
}
