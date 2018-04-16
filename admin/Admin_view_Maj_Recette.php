<?php session_start();
include('config/bd.php');
include('config/head.php');

// pour savoir si co
if(!isset($_SESSION['login'])) {
    header("Location:index.php?action=admin");
}

if(isset($_GET['id'])==false) {
    header("Location:index.php?action=error");
}


$sql2 = 'SELECT COUNT(idIngredient) AS nbrIngredients FROM estDans WHERE idIngredient!=0 AND idRecette=?';
$nbrIngredients=1;
$q2=$pdo->prepare($sql2);
$q2->execute(array($_GET['id']));
if($line2=$q2->fetch()) {
    $nbrIngredients=$line2['nbrIngredients'];
}

echo '<body onload="tabIngQte('.$nbrIngredients.');">';

?>

<div class="container__admin">

    <form action="index.php?action=Admin_trait__Maj_Recette" method="post" enctype="multipart/form-data">

        <a href="index.php?action=Admin_accueil"><span class="triangle-admin"></span></a>
        <a href="index.php?action=Admin_accueil" class="retour">Retour</a>

        <div class="form__content">

            <?php
            $sql = 'SELECT * FROM recette WHERE id=?';
            $q=$pdo->prepare($sql);
            $q->execute(array($_GET['id']));

            $i=1;
            if($line=$q->fetch()) {

                // pour récupérer l'id de la recette choisie, pas possible de le passer en GET avec un a href à cause du submit donc en POST en hidden
                echo '<input type="hidden" name="numeroRecette" value='.$line['id'].'>';

                echo '<div class="un">';
                echo '<h4 class="admin__title">Modifier la recette</h4>';

                echo '<hr size=1 width=100% color=#1C1C1C>';

                echo '<table>';

                echo '<tr><td><label for=titre>Titre</label></td>';
                echo '<td><input type="text" id="titre" name="titre" value="'.$line['titre'].'" required></td></tr>';

                echo '<tr><td><label for="tpsPrep">Préparation</label></td>';
                echo '<td><input type="number" id="tpsPrep" name="tpsPrep" value="'.$line['tpsPrep'].'" onKeypress="blocage();" required></td></tr>';

                echo '<tr><td><label for="tpsCui">Cuisson</label></td>';
                echo '<td><input type="number" id="tpsCui" name="tpsCui" value="'.$line['tpsCui'].'" onKeypress="blocage();" required></td></tr>';

                echo '<tr><td><label for="diff">Difficulté</label></td>';
                echo '<td><SELECT name="diff" id="diff">';
                for($i=1;$i<=3;$i++) {
                    if ($i==$line['diff']) {
                        echo '<option selected="selected">'.$i.'</option>';
                    }
                    else {
                        echo '<option>'.$i.'</option>';
                    }
                }
                echo '</SELECT></td></tr>';

                echo '<tr><td><label for="cout">Coût</label></td>';
                echo '<td><SELECT name="cout" id="cout">';
                for($i=1;$i<=3;$i++) {
                    if ($i==$line['cout']) {
                        echo '<option selected="selected">'.$i.'</option>';
                    }
                    else {
                        echo '<option>'.$i.'</option>';
                    }
                }
                echo '</SELECT></td></tr>';

                echo '<tr><td><label>Ustensile(s)</label></td>';
                echo '<td>';
                echo '<table>';
                echo '<tr>';
                // les ustensiles checked
                $sql3="SELECT * FROM estDans JOIN ustensile ON ustensile.id=idUstensile WHERE idRecette=?";
                $q3=$pdo->prepare($sql3);
                $q3->execute(array($_GET['id']));

                $ligne=0;
                $premierefois=true;
                while($line3=$q3->fetch()) {
                    if($ligne%2==0 && $premierefois==false) {
                        echo '</tr>';
                        echo '<tr>';
                    }
                    $premierefois=false;
                    echo '<td id="ustensile'.$line3['idUstensile'].'">';

                    echo '<label class="check__admin nom__ing">'.$line3['nom'];
                    echo '<input type="checkbox" name="already__ustensile[]" value="'.$line3['id'].'" checked>';
                    echo '<span class="checkmark"></span>';
                    echo '</label>';

                    echo '</td>';
                    $ligne++;
                }
                echo '</tr>';
                echo '<tr>';

                // tous les autres ustensiles
                $sql4="SELECT * FROM ustensile WHERE NOT EXISTS (SELECT idUstensile FROM estDans WHERE ustensile.id=idUstensile AND idRecette=?);";
                $q4=$pdo->prepare($sql4);
                $q4->execute(array($_GET['id']));
                $ligne=0;
                $premierefois=true;
                while($line4=$q4->fetch()) {
                    if($ligne%2==0 && $premierefois==false) {
                        echo '</tr>';
                        echo '<tr>';
                    }
                    $premierefois=false;
                    echo '<td id="ustensile'.$line4['id'].'">';
                    // echo '<div><input type="checkbox" class="check__admin" name="others__ustensile[]" value="'.$line4['id'].'">';
                    // echo '<label class="nom__ing">'.$line4['nom'].'</label></div>';

                    echo '<label class="check__admin nom__ing">'.$line4['nom'];
                    echo '<input type="checkbox" name="others__ustensile[]" value="'.$line4['id'].'">';
                    echo '<span class="checkmark"></span>';
                    echo '</label>';

                    echo '</td>';
                    $ligne++;
                }

                echo '</tr>';
                echo '</table>';
                echo '</td>';
                echo '</tr>';

                echo '<tr><td><label for="calorie">Calories</label></td>';
                echo '<td><input type="number" id="calorie" name="calorie" value="'.$line['calorie'].'" onKeypress="blocage();" required></td></tr>';

                if(!empty($line['imgBg'])) {
                    echo '<tr><td>Image</td>';
                    echo '<td class="image__actuelle">';
                    echo '<div class="hover__image">';
                    echo '<img src="img/recette/'.$line['imgBg'].'" class="apercu__image">';
                    echo '<a class="voir__image" href="http://localhost:8888/projet-manger/img/recette/'.$line['imgBg'].'" target="_blank">Voir</a>';
                    echo '</div>';
                    echo '<label for="imgBgbutton" class="modif" id="modif__img">Modifier</label>';
                    echo '<input type="file" accept=".png, .jpg, .jpeg" name="imgBackground" id="imgBg" class="input__cache" onclick="notifUpload();">';
                    echo'</td>';
                    // nom de dossier peut changer /!\
                }
                else {
                    echo '<tr><td>Image</td>';
                    echo '<td><input id="imgBgbutton" type="file" name="imgBackground" accept=".png, .jpg, .jpeg"></td></tr>';
                }

                echo '<tr>
                    <td><label for="video">Vidéo</label></td>
                    <td class="reponse__video">';
                if(!empty($line['video'])) {
                    echo '<div>
                            <label for="ouiVideo">Oui</label>
                            <input type="radio" name="validerVideo" value="oui" id="ouiVideo" onclick="afficherInputLien();" checked="checked">
                            <div id="lien__video" style="display:block;">
                                <input type="text" value="'.$line['video'].'" id="video" name="video">
                            </div>
                        </div>';
                    echo '<div> 
                                <label for="nonVideo">Non</label>
                                <input type="radio" name="validerVideo" value="non" id="nonVideo" onclick="desafficherInputLien();">
                        </div>';
                }

                else {
                    echo '<div>
                            <label for="ouiVideo">Oui</label>
                            <input type="radio" name="validerVideo" value="oui" id="ouiVideo" onclick="afficherInputLien();">
                            <div id="lien__video">
                                <input type="text" placeholder="http://www.youtube.fr/watch?..." id="video" name="video">
                            </div>
                        </div>';
                    echo '<div> 
                                <label for="nonVideo">Non</label>
                                <input type="radio" name="validerVideo" value="non" id="nonVideo" onclick="desafficherInputLien();" checked="checked">
                            </div>';
                }
                echo '</td>';
                echo '</tr>';

                echo '</table>';


                echo '<div class="actuels">';

                echo '<div class="personne">';
                echo '<label for="nbrPersonne">Quantités pour </label>';
                echo '<SELECT name="nbrPersonne" id="nbrPersonne" onchange="quantiteParPersonne();">';
                for($i=1;$i<=10;$i++) {
                    echo '<option>'.$i.'</option>';
                }
                echo '</SELECT>';
                echo '<span>personne(s)</span>';
                echo '</div>';

                echo '<h4>Ingrédients actuels</h4>';

                echo '<table>';
                echo '<tr>';

                $sql = 'SELECT ingredient.id,nom,qteIng,uniteQte FROM ingredient JOIN estDans ON ingredient.id=idIngredient JOIN recette ON recette.id=idRecette WHERE ingredient.id IN (SELECT idIngredient FROM estDans WHERE recette.id=?) ORDER BY type';
                $q=$pdo->prepare($sql);
                $q->execute(array($_GET['id']));

                $ligne=0;
                $i=0;
                while($line=$q->fetch()) {
                    if($ligne%3==0) {
                        echo '</tr>';
                        echo '<tr>';
                    }

                    echo '<td id="contour'.$line['id'].'">';
                    echo '<label class="check__admin nom__ing">'.$line['nom'];
                    echo '<input type="checkbox" name="already__checked[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');" checked>';
                    echo '<span class="checkmark"></span>';
                    echo '</label>';

                    echo '<div id="qteAfficheeIng'.$line['id'].'" style="display:block;" class="divQte">';
                    echo '<label for="qteIng">Quantité</label>';
                    echo '<br>';
                    echo '<input type="number" id="qteIng'.$i.'" name="qteIngDejaDedans[]" value="'.$line['qteIng'].'" min="1" max="5000">';
                    echo '<div class="indication-none" id="indication'.$i.'">';
                    echo '<span id="afficherQte'.$i.'"></span>';
                    echo '</div>';
                    echo '<SELECT name="uniteQteDejaDedans[]">';
                    if($line['uniteQte']=="g") {
                        echo '<option selected="selected">g</option>';
                        echo '<option>mL</option>';
                        echo '<option>cuillère(s) à soupe</option>';
                        echo '<option>cuillère(s) à café</option>';
                        echo '<option>tranche(s)</option>';
                    }
                    else if ($line['uniteQte']=="mL") {
                        echo '<option>g</option>';
                        echo '<option selected="selected">mL</option>';
                        echo '<option>cuillère(s) à soupe</option>';
                        echo '<option>cuillère(s) à café</option>';
                        echo '<option>tranche(s)</option>';
                    }
                    else if($line['uniteQte']=="cuillère(s) à soupe") {
                        echo '<option>g</option>';
                        echo '<option>mL</option>';
                        echo '<option selected="selected">cuillère(s) à soupe</option>';
                        echo '<option>cuillère(s) à café</option>';
                        echo '<option>tranche(s)</option>';
                    }
                    else if($line['uniteQte']=="cuillère(s) à café") {
                        echo '<option>g</option>';
                        echo '<option>mL</option>';
                        echo '<option selected="selected">cuillère(s) à café</option>';
                        echo '<option>tranche(s)</option>';
                    }
                    else {
                        echo '<option>g</option>';
                        echo '<option>mL</option>';
                        echo '<option>cuillère(s) à soupe</option>';
                        echo '<option>cuillère(s) à café</option>';
                        echo '<option selected="selected">'.$line['uniteQte'].'</option>';
                    }
                    echo '</SELECT>';
                    echo '</div>';
                    echo '</td>';
                    $ligne++;
                    $i++;
                }

                echo '</tr>';
                echo '</table>';

                echo '</div>'; // fin <div class="actuels">
                echo '</div>'; // fin de <div class="un">


                // autres viandes pas presents
                echo '<div class="deux">';
                echo '<h4>Autres ingrédients</h4>';
                echo '<hr size=1 width=100% color=#1C1C1C>';
                echo '<h4>Viandes et poissons</h4>';
                echo '<table>';
                echo '<tr>';

                $ligne=0;

                $sql='SELECT * FROM ingredient WHERE type="Viande-Poisson" AND NOT EXISTS (SELECT idIngredient FROM estDans WHERE ingredient.id=idIngredient AND idRecette=?);';
                $q=$pdo->prepare($sql);
                $q->execute(array($_GET['id']));
                while($line=$q->fetch()) {
                    if($ligne%3==0) {
                        echo '</tr>';
                        echo '<tr>';
                    }
                    echo '<td id="contour'.$line['id'].'">';
                    echo '<label class="check__admin nom__ing">'.$line['nom'];
                    echo '<input type="checkbox" name="others[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
                    echo '<span class="checkmark"></span>';
                    echo '</label>';
                    echo '<div id="qteAfficheeIng'.$line['id'].'" style="display:none;" class="divQte">';
                    echo '<label for="qteIng">Quantité</label>';
                    echo '<br>';
                    echo '<input type="number" id="qteIng'.$i.'" name="qteIng[]" onKeypress="blocage();" min="1" max="5000">';
                    echo '<SELECT name="uniteQte[]">';
                    echo '<option>Unite</option>';
                    echo '<option>g</option>';
                    echo '</SELECT>';
                    echo '</div>';
                    echo '</td>';
                    $ligne++;
                    $i++;
                }

                echo '</tr>';
                echo '</table>';

                echo '<br>';

                // autres legumes pas presents
                echo '<h4>Légumes</h4>';
                echo '<table>';
                echo '<tr>';

                $ligne=0;

                $sql='SELECT * FROM ingredient WHERE type="Légume" AND NOT EXISTS (SELECT idIngredient FROM estDans WHERE ingredient.id=idIngredient AND idRecette=?);';
                $q=$pdo->prepare($sql);
                $q->execute(array($_GET['id']));
                while($line=$q->fetch()) {
                    if($ligne%3==0) {
                        echo '</tr>';
                        echo '<tr>';
                    }
                    echo '<td id="contour'.$line['id'].'">';
                    echo '<label class="check__admin nom__ing">'.$line['nom'];
                    echo '<input type="checkbox" name="others[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
                    echo '<span class="checkmark"></span>';
                    echo '</label>';
                    echo '<div id="qteAfficheeIng'.$line['id'].'" style="display:none;" class="divQte">';
                    echo '<label for="qteIng">Quantité</label>';
                    echo '<br>';
                    echo '<input type="number" id="qteIng'.$i.'" name="qteIng[]" onKeypress="blocage();" min="1" max="5000">';
                    echo '<SELECT name="uniteQte[]">';
                    echo '<option>Unite</option>';
                    echo '<option>g</option>';
                    echo '</SELECT>';
                    echo '</div>';
                    echo '</td>';
                    $ligne++;
                    $i++;
                }

                echo '</tr>';
                echo '</table>';

                echo '<br>';

                // autres féculents pas presents

                echo '<h4>Féculents</h4>';
                echo '<table>';
                echo '<tr>';

                $ligne=0;

                $sql='SELECT * FROM ingredient WHERE type="Féculent" AND NOT EXISTS (SELECT idIngredient FROM estDans WHERE ingredient.id=idIngredient AND idRecette=?);';
                $q=$pdo->prepare($sql);
                $q->execute(array($_GET['id']));
                while($line=$q->fetch()) {
                    if($ligne%3==0) {
                        echo '</tr>';
                        echo '<tr>';
                    }
                    echo '<td id="contour'.$line['id'].'">';
                    echo '<label class="check__admin nom__ing">'.$line['nom'];
                    echo '<input type="checkbox" name="others[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
                    echo '<span class="checkmark"></span>';
                    echo '</label>';
                    echo '<div id="qteAfficheeIng'.$line['id'].'" style="display:none;" class="divQte">';
                    echo '<label for="qteIng">Quantité</label>';
                    echo '<br>';
                    echo '<input type="number" id="qteIng'.$i.'" name="qteIng[]" onKeypress="blocage();" min="1" max="5000">';
                    echo '<SELECT name="uniteQte[]">';
                    echo '<option>Unite</option>';
                    echo '<option>g</option>';
                    echo '</SELECT>';
                    echo '</div>';
                    echo '</td>';
                    $ligne++;
                    $i++;
                }

                echo '</tr>';
                echo '</table>';

                echo '<br>';

                // autres laitages pas presents
                echo '<h4>Laitages</h4>';
                echo '<table>';
                echo '<tr>';

                $ligne=0;

                $sql='SELECT * FROM ingredient WHERE type="Laitier" AND NOT EXISTS (SELECT idIngredient FROM estDans WHERE ingredient.id=idIngredient AND idRecette=?);';
                $q=$pdo->prepare($sql);
                $q->execute(array($_GET['id']));
                while($line=$q->fetch()) {
                    if($ligne%3==0) {
                        echo '</tr>';
                        echo '<tr>';
                    }
                    echo '<td id="contour'.$line['id'].'">';
                    echo '<label class="check__admin nom__ing">'.$line['nom'];
                    echo '<input type="checkbox" name="others[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
                    echo '<span class="checkmark"></span>';
                    echo '</label>';
                    echo '<div id="qteAfficheeIng'.$line['id'].'" style="display:none;" class="divQte">';
                    echo '<label for="qteIng">Quantité</label>';
                    echo '<br>';
                    echo '<input type="number" id="qteIng'.$i.'" name="qteIng[]" onKeypress="blocage();" min="1" max="5000">';
                    echo '<SELECT name="uniteQte[]">';
                    echo '<option>Unite</option>';
                    echo '<option>g</option>';
                    echo '</SELECT>';
                    echo '</div>';
                    echo '</td>';
                    $ligne++;
                    $i++;
                }

                echo '</tr>';
                echo '</table>';

                echo '<br>';

                // autres divers pas presents
                echo '<h4>Divers</h4>';
                echo '<table>';
                echo '<tr>';

                $ligne=0;

                $sql='SELECT * FROM ingredient WHERE type="Divers" AND NOT EXISTS (SELECT idIngredient FROM estDans WHERE ingredient.id=idIngredient AND idRecette=?);';
                $q=$pdo->prepare($sql);
                $q->execute(array($_GET['id']));
                while($line=$q->fetch()) {
                    if($ligne%3==0) {
                        echo '</tr>';
                        echo '<tr>';
                    }
                    echo '<td id="contour'.$line['id'].'">';
                    echo '<label class="check__admin nom__ing">'.$line['nom'];
                    echo '<input type="checkbox" name="others[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
                    echo '<span class="checkmark"></span>';
                    echo '</label>';
                    echo '<div id="qteAfficheeIng'.$line['id'].'" style="display:none;" class="divQte">';
                    echo '<label for="qteIng">Quantité</label>';
                    echo '<br>';
                    echo '<input type="number" id="qteIng'.$i.'" name="qteIng[]" onKeypress="blocage();" min="1" max="5000">';
                    echo '<SELECT name="uniteQte[]">';
                    echo '<option>Unite</option>';
                    echo '<option>g</option>';
                    echo '</SELECT>';
                    echo '</div>';
                    echo '</td>';
                    $ligne++;
                    $i++;
                }

                echo '</tr>';
                echo '</table>';
                echo '</div>'; // fin de <div class="deux">

                // liste des étapes, on affiche toutes celles qui ne sont pas vides dans la BDD
                $i=1;
                $sql2 = 'SELECT * FROM recette WHERE id=?';
                $q2=$pdo->prepare($sql2);
                $q2->execute(array($_GET['id']));
                $line2=$q2->fetch();
                echo '<div class="trois">';
                echo '<h4>Étapes</h4>';
                echo '<hr size=1 width=100% color=#1C1C1C>';
                while(!empty($line2['etape'.$i]) AND $i<10) {
                    echo '<div class="etp" id="etape'.$i.'" style="display:block; position:relative;">';
                    echo '<span class="etape__title">Etape '.$i.'</span>';
                    echo '<textarea style=\'display:block;\' id=\'etape'.$i.'\' name=\'etape'.$i.'\'>'.$line2['etape'.$i].'</textarea>';
                    echo '<button id="bouton__supp'.$i.'" class="supprimer__etape" value="'.$i.'" onclick="supprimerEtape(this.value);">-</button>';
                    $i++;
                    echo '</div>';
                }

                // affichage en display none des autres pour pouvoir les display block. On commence à $i, enfin $i+1 comme on sort de la boucle while
                for($j=$i;$j<=10;$j++) {
                    echo '<div class="etp" id="etape'.$j.'" style="display:none; position:relative;">
                        <span class="etape__title" id="nom__etape'.$j.'">Etape '.$j.'</span> 
                        <button id="bouton__supp'.$j.'" class="supprimer__etape" value="'.$j.'" onclick="supprimerEtape(this.value);">-</button>
                        <br>
                        <textarea id="etape'.$j.'__contenu" name="etape'.$j.'"></textarea>
                    </div>';
                }

                $i--; // pour pas avoir $i+1 en sortie de boucle
                echo '<input type="hidden" value="'.$i.'" name="nbrEtapes" id="nbrEtapes">';

                // bouton d'ajout d'etapes comme pour creation
                echo '<input type="button" onclick="ajouterEtapeModif();" value="+" id="bouton__ajouter" class="bouton__plus">';


                echo '</div>'; // fin de <div class="trois">
                echo '</div>'; // fin de <div class="form__content">

                echo '<input type="submit" value="Modifier la recette" name="demandeModif">';
                echo '<a href="index.php?action=Admin_accueil" class="annuler">Annuler</a>';
            } // fin du if ligne 26

            ?>

    </form>

</div>

</body>



