<?php

session_start(); // pour garder la var de SESSION

if(isset($_GET['id'])) {

	// recherche de l'indice de l'ing passé en parametre avec le $_GET['id']
	foreach ($_SESSION['ing_checked'] as $key => $value) {
			if(array_search($_GET['id'],$_SESSION['ing_checked'])!==false) {
				unset($_SESSION['ing_checked'][$key]);
		}
	}

	//requete pour recuperer le nom de l'ingredient supprime, puis on redirige vers page liste
    $sql="SELECT nom FROM ingredient WHERE id=?";
	$q=$pdo->prepare($sql);
	$q->execute(array($_GET['id']));
	if($line=$q->fetch()) {
		header("Location:index.php?nomSupp=".$line['nom']."&action=listeIngredients#slide2");
	}
}

?>