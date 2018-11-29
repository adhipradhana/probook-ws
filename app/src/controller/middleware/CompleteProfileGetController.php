<?php
class CompleteProfileGetController implements ControllerInterface {
  public static function control(Request $request) {
    $db = new MarufDB;
    $user = $db->getUser($_COOKIE['token']);
    $template = new Template('src/view/completeprofile.php');
    return $template->render($user['email']);
  }
}
