<?php
class RegisterPostController implements ControllerInterface {
  public static function control(Request $request) {
    $db = new MarufDB();
    $result = $db->completeProfile($request->name, $request->username, $request->email, $request->password, $request->cardnumber, $request->address, $request->phoneNumber);
    if ($result == 1) {
      return LoginPostController::control($request);
    } else {
      header("Location: /");
      return False;
    }
  }
}
