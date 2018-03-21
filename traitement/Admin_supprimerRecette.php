<?php

if(isset($_GET['id'])) {
	$sql='DELETE FROM recette WHERE id=?';
	$q=$pdo->prepare($sql);
	$q->execute(array($_GET['id']));

	$sql='DELETE FROM estDans WHERE idRecette=?';
	$q=$pdo->prepare($sql);
	$q->execute(array($_GET['id']));

	header("Location:index.php?action=admin");

}

?>