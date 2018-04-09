<?php

session_start(); // pour garder la var de SESSION

include('config/bd.php');
include('config/head.php');

if(isset($_GET['id'])) {

    // recherche de l'indice de l'ing passé en parametre avec le $_GET['id']
    foreach ($_SESSION['ing_checked'] as $key => $value) {
        if($value==$_GET['id']) {
            unset($_SESSION['ing_checked'][$key]);
        }

        $ingChecked_serialize = serialize($_SESSION['ing_checked']);

        setcookie("cookieIng", $ingChecked_serialize, time()+24*60*60);

    }
}

?>