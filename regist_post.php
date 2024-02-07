<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    // A fetch body-ban érkezett adatok kinyerése:
    $raw_datas = file_get_contents("php://input");
    $datas = json_decode($raw_datas, true);

    if ($datas !== null) {
        $first_name = $datas["firstName"];
        $last_name = $datas["lastName"];
        $user_name = $datas["userName"];
        $user_email = $datas["emailAddress"];
        $user_password = $datas["password"];
    } else {
        $first_name = $_POST["firstName"];
        $last_name = $_POST["lastName"];
        $user_name = $_POST["userName"];
        $user_email = $_POST["emailAddress"];
        $user_password = $_POST["password"];
    }
    // users.json fájlban lévő felhasználói adatok beolvasása:
    $raw_users_datas = file_get_contents("./users.json");
    $users_datas = json_decode($raw_users_datas, true);
    // Létezik-e már a felhasználó?
    $existsUser = false;
    foreach($users_datas as $user) {
        if ($user["userName"] === $user_name) {
            $errorCode = 1;
            $errorMessage = "Ilyen néven már regisztráltak!";
            $messageDatas = [];
            $existsUser = true;
            break;
        }
        if ($user["emailAddress"] === $user_email) {
                $errorCode = 1;
                $errorMessage = "Ezzel az e-mail címmel már regisztráltak!";
                $messageDatas = [];
                $existsUser = true;
                break;
        }
    }
    //Létrehozzuk az új felhasználót:
    if (!$existsUser) {
        $new_user = [
            "firstName" => $first_name,
            "lastName" => $last_name,
            "userName" => $user_name,
            "emailAddress" => $user_email,
            "password" => password_hash($user_password, PASSWORD_DEFAULT)
        ];
        $errorCode = 0;
        $errorMessage = "Sikeres regisztráció!";
        $messageDatas = [];
        array_push($users_datas, $new_user);
        file_put_contents("./users.json", json_encode($users_datas));
    }

    $message = ["errorCode" => $errorCode, "errorMessage" => $errorMessage, "messageDatas" => $messageDatas];

    echo json_encode($message);
?>