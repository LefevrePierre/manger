supprimer.php<?php

session_start(); // pour garder la var de SESSION

if(isset($_SESSION['ing_checked'])) {
    $_SESSION['ing_checked']=array();
    header("Location:index.php?action=listeIngredients");

}

?>