<?php

include_once '../config/bd.php';

if(isset($_GET['motcle'])){
    $motcle = $_GET['motcle'];
    $q = array('motcle'=>'%'.$motcle.'%');
    $sql = 'SELECT imgListe,id,nom,type FROM ingredient WHERE nom LIKE :motcle';
    $req = $pdo->prepare($sql);
    $req->execute($q);
    $count = $req->rowCount($sql);

    if($count == 1){
        while ($line=$req->fetch()) {
            echo "<div class=item-container>";
            echo "<img src=img/".$line['type']."/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
            echo "<p class=nom>".$line['nom']."</p>";
            echo "<a href=index.php?id=".$line['id']."&action=ajouter class=ajout>+</a>";
            echo "</div>";
        }
    }else{
        echo "Aucun resultat pour : ".$motcle;
    }
}
?>