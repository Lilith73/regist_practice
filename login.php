<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Request-ben érkező adatok kinyerése:
$raw_datas = file_get_contents("php://input");
$datas = json_decode($raw_datas, true);

if ($datas !== null) {
    $user_name = $datas["userName"];
    $user_password = $datas["userPassword"];
} else {
    $user_name = $_POST["userName"];
    $user_password = $_POST["userPassword"];
}

// Userek adatbázisának beolvasása:
$raw_datas_users = file_get_contents("./users.json");
$datas_users = json_decode($raw_datas_users, true);

// Alaphelyzet:
$errorCode = 1;
$errorMessage = "Sikertelen bejelentkezés!";
$dataLine = [];

// Szerepel-e a felhasználók adatbázisában a bejelentkezni kívánó?
foreach ($datas_users as $user) {
    if ($user["userName"] === $user_name  && password_verify($user_password, $user["password"])) {
        //Ha szerepel, de már benne van a session-tömbben, akkor már...
        if (isset($_SESSION["userName"]) && $_SESSION["userName"] === $user_name) {
            $errorCode = 0;
            $errorMessage = "Ön már be van jelentkezve";
            $dataLine = [];
        } else {
            // Ha szerepel, de még nincs a session-tömbben, akkor beletesszük:
            $_SESSION["userName"] = $user_name;
            $_SESSION["fullName"] = $user["lastName"] . " " . $user["firstName"];

            $errorCode = 0;
            $errorMessage = "Sikeres bejelentkezés!";
            $dataLine = [];

        }
    }
}

// Visszaküldendő adatok:
$message = ["errorCode" => $errorCode, "errorMessage" => $errorMessage, "dataLine" => $dataLine];

echo json_encode($message);
?>