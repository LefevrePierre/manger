<?php

if(isset($_POST['demandeAjout'])) {

	//pour le sql partie ENTETES

	$sqlEtapesPartie1="";

	for($i=1;$i<=$_POST['nbrEtapes'];$i++) {
		if($i==$_POST['nbrEtapes']) {
			$sqlEtapesPartie1=$sqlEtapesPartie1.'etape'.$i;
		}
		else {
			$sqlEtapesPartie1=$sqlEtapesPartie1.'etape'.$i.',';
		}	
	}

	// pour le sql partie VALUES

	$sqlEtapesPartie2="";

	for($i=1;$i<=$_POST['nbrEtapes'];$i++) {
		if($i==$_POST['nbrEtapes']) {
			$sqlEtapesPartie2=$sqlEtapesPartie2.':etape'.$i;
		}
		else {
			$sqlEtapesPartie2=$sqlEtapesPartie2.':etape'.$i.',';
		}	
	}

	//liste etapes dans un tab
	$qEtapes=array();
	for($i=1;$i<=$_POST['nbrEtapes'];$i++) {
		$qEtapes+=array(':etape'.$i=>$_POST['etape'.$i]);
	}

	$sql1 = "INSERT INTO recette (titre,tpsPrep,tpsCui,diff,cout,ustensile,calorie,video,".$sqlEtapesPartie1.") VALUES (:titre,:tpsPrep,:tpsCui,:diff,:cout,:ustensile,:calorie,:video,".$sqlEtapesPartie2.")";

		$q1=$pdo->prepare($sql1);

		// tab des infos de base sans les étapes
		$listeParametre=array(
			':titre'=>$_POST['titre'],
			':tpsPrep'=>$_POST['tpsPrep'],
			':tpsCui'=>$_POST['tpsCui'],
			':diff'=>$_POST['diff'],
			':cout'=>$_POST['cout'],
			':ustensile'=>$_POST['ustensile'],
			':calorie'=>$_POST['calorie'],
			':video'=>$_POST['video']
		);

		// tab de parametres final avec etapes
		$tabRequete=array_merge($listeParametre,$qEtapes);

		$q1->execute($tabRequete);

		//Débuggage et affichage des différents tableaux, sql, pour comprendre le raisonnement

		// echo '<pre> qEtapes : ';
		// print_r($qEtapes);
		// echo '</pre>';

		// echo '<pre> liste parametre';
		// print_r($listeParametre);
		// echo '</pre>';

		// echo '<pre> Tab requete';
		// print_r($tabRequete);
		// echo '</pre>';

		// upload image

		if(file_exists($_FILES['imgBackground']['tmp_name'])) {
			// on vérfie si un fichier a été upload
			$imgBackground = rand(1000,100000)."-".$_FILES['imgBackground']['name'];
		    $file_loc = $_FILES['imgBackground']['tmp_name'];
		 	$file_size = $_FILES['imgBackground']['size'];
		 	$file_type = $_FILES['imgBackground']['type'];
		 	$folder="img/recette/";
		 
		 	move_uploaded_file($file_loc,$folder.$imgBackground);

		 	// recherche de l'id de la recette avec son nom qui vient d'etre ajoutee
		 	$sql2="SELECT id FROM recette WHERE titre=?";
		 	$q2=$pdo->prepare($sql2);
		 	$q2->execute(array($_POST['titre']));
		 	if($lineID=$q2->fetch()) {
		 		$sql3="UPDATE recette SET imgBg=:imgBackground,imgBgType=:file_type,imgBgSize=:file_size WHERE id=:id";
		 		$q3=$pdo->prepare($sql3);
		 		$q3->execute(array(
		 			':imgBackground'=>$imgBackground,
		 			':file_type'=>$file_type,
		 			':file_size'=>$file_size,
		 			':id'=>$lineID['id']
		 		));
		 	}
	 }
	// pour ajout des ing à la recette
	if(isset($_POST['ing'])) {
		// on regard s'il y a de nouveaux ings
		$Checked=$_POST['ing'];
		$idNouvelleRecette=1; // valeur 1 donnee pour qu'il soit du type nombre. On lui donne une autre valeur apres

		// tableaux bruts qui contiennent des quantités vides et des unites=Unite, pas exploitables. Voir $qteTab et $uniteTab

		// echo '<pre> QTE';
		// print_r($_POST['qteIng']);
		// echo '</pre>';

		// echo '<pre> Unite';
		// print_r($_POST['uniteQte']);
		// echo '</pre>';

	$qteTab=array(); // permet de récuperer seulement là où il y a une quantité différente de '' (voir le foreach) 
	$uniteTab=array(); // permet de récuperer seulement là où il y a une unité différente de "Unité" (voir le foreach)

	foreach ($_POST['qteIng'] as $key1 => $value1) {
		if($value1!='') {
			array_push($qteTab,$value1);
		}
	}

	foreach ($_POST['uniteQte'] as $key2 => $value2) {
		if($value2!='Unite') {
			array_push($uniteTab,$value2);
		}
	}
		// echo 'Vous avez checked : ';
		// echo '<pre>';
		// print_r($Checked);
		// echo '</pre>';

		// echo 'Quantités : ';
		// echo '<pre>';
		// print_r($qteTab);
		// echo '</pre>';

		// echo 'Unites : ';
		// echo '<pre>';
		// print_r($uniteTab);
		// echo '</pre>';

		$sql2 = "SELECT MAX(id) AS new FROM recette";
		// on va chercher la valeur de l'id auto incremente dans la table recette. On donne la valeur de cet id à idRecette (table estDans)
			$q2=$pdo->prepare($sql2);
			$q2->execute();
			if($line=$q2->fetch()) {
				$idNouvelleRecette=$line['new'];
			}

		$i=1;
		for($i=0;$i<sizeof($Checked);$i++) {
			$sql3 = 'INSERT INTO estDans (idRecette,idIngredient,qteIng,uniteQte) VALUES ('.$idNouvelleRecette.','.$Checked[$i].',"'.$qteTab[$i].'","'.$uniteTab[$i].'")';
			$q3=$pdo->prepare($sql3);
			$q3->execute();
		}
	} // fin du isset POST['ing']

	header("Location:index.php?action=admin");

} // fin du POST[demandeAjout]

?>