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
            echo "<div class=item-container-search>";
            echo "<img src=img/".$line['type']."/".$line['imgListe']." class=post-it-search alt=".$line['imgListe'].">";
            echo "<p class=nom-search>".$line['nom']."</p>";
            echo '<a onclick="ajouter('.$line['id'].');" class="ajout" id="ing'.$line['id'].'">+</a>';
            echo "</div>";
        }
    }else{
        echo "<div class='aucunResultat'>Aucun résultat pour : ".$motcle."</div>";
    }
}
?>