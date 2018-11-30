<?php
class CompleteProfileGetController implements ControllerInterface {
  public static function control(Request $request) {
    $db = new MarufDB;
    $user = $db->getUser($_COOKIE['token']);
    $template = new Template('src/view/completeProfile.php');
    return $template->render($user['name'], $user['email']);
  }
}
