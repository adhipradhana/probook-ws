<?php
class CompleteProfilePostController implements ControllerInterface {
  public static function control(Request $request) {
    $db = new MarufDB();
    $user_id = $db->getUserId($_COOKIE['token']);
    $result = $db->completeProfile($user_id, $request->name, $request->username, $request->password, $request->cardnumber, $request->address, $request->phoneNumber);
    if ($result == 1) {
      header("Location: /");
      exit();
    } else {
      return '<h1>Failed</h1>';
    }
  }
}
