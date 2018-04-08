<?php

session_start(); // pour garder la var de SESSION

if(isset($_GET['id'])) {
	
	// ajout
	array_push($_SESSION['ing_checked'],$_GET['id']);

    $ingChecked_serialize = serialize($_SESSION['ing_checked']);
    print_r($ingChecked_serialize);// Affiche a:3:{i:0;s:4:"moto";i:1;s:7:"voiture";i:2;s:5:"vélo";}

    setcookie("cookieIng", $ingChecked_serialize, time()+24*60*60);
    $tab_cookies = unserialize($_COOKIE['cookieIng']);

    //requete pour recuperer le nom de l'ingredient ajoute, puis on redirige vers page recette
    $sql="SELECT nom FROM ingredient WHERE id=?";
	$q=$pdo->prepare($sql);
	$q->execute(array($_GET['id']));
	if($line=$q->fetch()) {
		header("Location:index.php?nom=".$line['nom']."&action=listeIngredients#slide1");
	}
}


?>