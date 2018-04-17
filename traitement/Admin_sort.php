<?php

include('../config/bd.php');

$critere = $_REQUEST['value'];

if(isset($critere)) {

    if($critere=="A-Z") {
        $sql1 = 'SELECT * FROM recette ORDER BY titre';
        $q1=$pdo->prepare($sql1);
        $q1->execute();
        while($lineInfo = $q1->fetch()) {
            echo '<tr>';
            echo '<td>'. $lineInfo['titre'] . '</td>';
            echo '<td>'. $lineInfo['tpsPrep'] . '</td>';
            echo '<td>'. $lineInfo['tpsCui'] . '</td>';
            echo '<td>';
            // les ingredients de la ieme recette
            $sql2= 'SELECT * FROM ingredient JOIN estDans on ingredient.id=idIngredient JOIN recette ON recette.id=idRecette WHERE recette.id=:numRecette';
            $q2=$pdo->prepare($sql2);
            $q2->execute(array(
                ':numRecette'=>$lineInfo['id']
            ));
            while($lineIng = $q2->fetch()) {
                echo '<span class="nom__ing__index">'.$lineIng['nom'].'<span><br>';
            }
            echo '</td>';
            echo '<td width=300>';
            echo ' ';
            echo '<a class="btn btn-primary" href="index.php?id='.$lineInfo['id'].'&action=Admin_view_Maj_Recette"><span class="glyphicon glyphicon-pencil"></span> Voir ou Modifier</a>';
            echo ' ';
            echo '<a class="btn btn-danger" href="index.php?id='.$lineInfo['id'].'&action=Admin_supprimerRecette"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
            echo '</td>';
            echo '</tr>';
        }
    }

    else if($critere=="Z-A") {
        $sql1 = 'SELECT * FROM recette ORDER BY titre DESC';
        $q1=$pdo->prepare($sql1);
        $q1->execute();
        while($lineInfo = $q1->fetch()) {
            echo '<tr>';
            echo '<td>'. $lineInfo['titre'] . '</td>';
            echo '<td>'. $lineInfo['tpsPrep'] . '</td>';
            echo '<td>'. $lineInfo['tpsCui'] . '</td>';
            echo '<td>';
            // les ingredients de la ieme recette
            $sql2= 'SELECT * FROM ingredient JOIN estDans on ingredient.id=idIngredient JOIN recette ON recette.id=idRecette WHERE recette.id=:numRecette';
            $q2=$pdo->prepare($sql2);
            $q2->execute(array(
                ':numRecette'=>$lineInfo['id']
            ));
            while($lineIng = $q2->fetch()) {
                echo '<span class="nom__ing__index">'.$lineIng['nom'].'<span><br>';
            }
            echo '</td>';
            echo '<td width=300>';
            echo ' ';
            echo '<a class="btn btn-primary" href="index.php?id='.$lineInfo['id'].'&action=Admin_view_Maj_Recette"><span class="glyphicon glyphicon-pencil"></span> Voir ou Modifier</a>';
            echo ' ';
            echo '<a class="btn btn-danger" href="index.php?id='.$lineInfo['id'].'&action=Admin_supprimerRecette"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
            echo '</td>';
            echo '</tr>';
        }
    }
    else if($critere=="Les + récentes") {
        $sql1 = 'SELECT * FROM recette ORDER BY id DESC';
        $q1=$pdo->prepare($sql1);
        $q1->execute();
        while($lineInfo = $q1->fetch()) {
            echo '<tr>';
            echo '<td>'. $lineInfo['titre'] . '</td>';
            echo '<td>'. $lineInfo['tpsPrep'] . '</td>';
            echo '<td>'. $lineInfo['tpsCui'] . '</td>';
            echo '<td>';
            // les ingredients de la ieme recette
            $sql2= 'SELECT * FROM ingredient JOIN estDans on ingredient.id=idIngredient JOIN recette ON recette.id=idRecette WHERE recette.id=:numRecette';
            $q2=$pdo->prepare($sql2);
            $q2->execute(array(
                ':numRecette'=>$lineInfo['id']
            ));
            while($lineIng = $q2->fetch()) {
                echo '<span class="nom__ing__index">'.$lineIng['nom'].'<span><br>';
            }
            echo '</td>';
            echo '<td width=300>';
            echo ' ';
            echo '<a class="btn btn-primary" href="index.php?id='.$lineInfo['id'].'&action=Admin_view_Maj_Recette"><span class="glyphicon glyphicon-pencil"></span> Voir ou Modifier</a>';
            echo ' ';
            echo '<a class="btn btn-danger" href="index.php?id='.$lineInfo['id'].'&action=Admin_supprimerRecette"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
            echo '</td>';
            echo '</tr>';
        }
    }
    else if($critere=="Les - récentes") {
        $sql1 = 'SELECT * FROM recette ORDER BY id';
        $q1=$pdo->prepare($sql1);
        $q1->execute();
        while($lineInfo = $q1->fetch()) {
            echo '<tr>';
            echo '<td>'. $lineInfo['titre'] . '</td>';
            echo '<td>'. $lineInfo['tpsPrep'] . '</td>';
            echo '<td>'. $lineInfo['tpsCui'] . '</td>';
            echo '<td>';
            // les ingredients de la ieme recette
            $sql2= 'SELECT * FROM ingredient JOIN estDans on ingredient.id=idIngredient JOIN recette ON recette.id=idRecette WHERE recette.id=:numRecette';
            $q2=$pdo->prepare($sql2);
            $q2->execute(array(
                ':numRecette'=>$lineInfo['id']
            ));
            while($lineIng = $q2->fetch()) {
                echo '<span class="nom__ing__index">'.$lineIng['nom'].'<span><br>';
            }
            echo '</td>';
            echo '<td width=300>';
            echo ' ';
            echo '<a class="btn btn-primary" href="index.php?id='.$lineInfo['id'].'&action=Admin_view_Maj_Recette"><span class="glyphicon glyphicon-pencil"></span> Voir ou Modifier</a>';
            echo ' ';
            echo '<a class="btn btn-danger" href="index.php?id='.$lineInfo['id'].'&action=Admin_supprimerRecette"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
            echo '</td>';
            echo '</tr>';
        }
    }
}

?>