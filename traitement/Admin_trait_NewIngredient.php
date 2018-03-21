<?php

if(isset($_POST['demandeAjout'])) {

	// requete pour imgListe
	$imgListeFile = rand(1000,100000)."-".$_FILES['imgListe']['name'];
    $file_loc1 = $_FILES['imgListe']['tmp_name'];
 	$file_size1 = $_FILES['imgListe']['size'];
 	$file_type1 = $_FILES['imgListe']['type'];
 	$folder1="img/".$_POST['type']."/";
 
 	move_uploaded_file($file_loc1,$folder1.$imgListeFile);

 	// requete pour imgRecette
	$imgRecetteFile = rand(1000,100000)."-".$_FILES['imgRecette']['name'];
    $file_loc2 = $_FILES['imgRecette']['tmp_name'];
 	$file_size2 = $_FILES['imgRecette']['size'];
 	$file_type2 = $_FILES['imgRecette']['type'];
 	$folder2="img/".$_POST['type']."/";
 
 	move_uploaded_file($file_loc2,$folder2.$imgRecetteFile);

 	// infos sur nom et type
 	$type=$_POST['type'];
	$nom=$_POST['newIngredient'];

	$sql1="INSERT INTO ingredient(type,nom,imgListe,imgListeType,imgListeSize,imgRecette,imgRecetteType,imgRecetteSize) VALUES('$type','$nom','$imgListeFile','$file_type1','$file_size1','$imgRecetteFile','$file_type2','$file_size2')";

	 	$q1=$pdo->prepare($sql1);
		$q1->execute();

	header("Location:index.php?new=".$nom."&action=Admin_acceuil");

}

?>