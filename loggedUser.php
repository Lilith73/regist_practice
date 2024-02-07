<?php
    session_start();

    if (!isset($_SESSION["userName"])) {
        $errorCode = 1;
        $errorMessage = "Ön még nem jelentkezett be!";
        $dataLine = [];
    } else {
        $errorCode = 0;
        $errorMessage = "";
        $dataLine = ["messageLine" => $_SESSION["fullName"]];
    }

    $messageDatas = ["errorCode" => $errorCode, "errorMessage" => $errorMessage, "dataLine" => $dataLine];

    echo json_encode($messageDatas);
?>