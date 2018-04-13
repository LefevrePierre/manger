<?php
include('../config/bd.php');
$tab_cookies = unserialize($_COOKIE['cookieIng']);
$tabUniques=array();
$tabUniques=array_unique($tab_cookies);

foreach($tabUniques as $key=>$value) {

    $sql = "SELECT * FROM ingredient WHERE id=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($value));

    while($line=$q->fetch()) {
        echo "<div class='liste__item'>";
        echo "<img src=img/".$line['type']."/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
        echo "<p class=liste-nom>".$line['nom']."</p>";
        echo '<a onclick="supprimer('.$line['id'].');" id="ing'.$line['id'].'"><img src="img/icones/cancel.png" class="croix-supp" alt="supprimer"></a>';
        echo '</div>';
    }
}
?>