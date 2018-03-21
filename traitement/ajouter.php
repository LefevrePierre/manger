<?php

session_start(); // pour garder la var de SESSION

if(isset($_GET['id'])) {
	
	// ajout
	array_push($_SESSION['ing_checked'],$_GET['id']);

	//requete pour recuperer le nom de l'ingredient ajoute, puis on redirige vers page recette
    $sql="SELECT nom FROM ingredient WHERE id=?";
	$q=$pdo->prepare($sql);
	$q->execute(array($_GET['id']));
	if($line=$q->fetch()) {
		header("Location:index.php?nom=".$line['nom']."&action=listeIngredients#slide1");
	}
}


?>