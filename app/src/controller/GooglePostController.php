<?php
class GooglePostController implements ControllerInterface {
    public static function control(Request $request) {
        // The user's profile info
        $name = $_POST['name'];
        $username = strtolower($name);
        $email = $_POST['email'];

        var_dump($name);
        var_dump($email);
        exit();

        $registerData = array(
            "name" => $name,
            "username" => $username,
            "email" => $email,
            "password" => "",
            "address" => "",
            "phoneNumber" => ""
        );

        $db = new MarufDB();

        // if email not exist
        if ($db->validateEmail($email) == 1) {
            $result = $db->addProfile($registerData->name, $registerData->username, $registerData->email, $registerData->password, $registerData->address, $registerData->phoneNumber);
            if ($result == 1) {
                return LoginPostController::control($registerData);
            } else {
                exit();
                $template = new Template('src/view/login.php');
                return $template->render(False, False);
            }
        } else {
            return LoginPostController::control($registerData);
        }
    }
}
?>