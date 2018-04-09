<?php

session_start(); // pour garder la var de SESSION

if(isset($_GET['id'])) {

    // ajout
    array_push($_SESSION['ing_checked'],$_GET['id']);

    $ingChecked_serialize = serialize($_SESSION['ing_checked']);

    setcookie("cookieIng", $ingChecked_serialize, time()+24*60*60);
}


?>