<?php
include('../config/bd.php');
include('../config/head.php');

//affichage de l'ingrédient ajouté s'il existe (pas la premiere fois)
if(isset($_GET['idAjoute'])) {
    $sql="SELECT * FROM ingredient WHERE id=?";
    $q=$pdo->prepare($sql);
    $q->execute(array($_GET['idAjoute']));
    if($line=$q->fetch()) {
        echo "<p>Vous avez ajouté : ".$line['nom']."</p>";
    }

}

else if(isset($_GET['idSupp'])) {
    $sql="SELECT * FROM ingredient WHERE id=?";
    $q=$pdo->prepare($sql);
    $q->execute(array($_GET['idSupp']));
    if($line=$q->fetch()) {
        echo "<p>Vous avez supprimé : ".$line['nom']."</p>";
    }

}

?>