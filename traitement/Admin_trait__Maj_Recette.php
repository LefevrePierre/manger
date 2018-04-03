<?php

if(isset($_POST['demandeModif'])) {

    // mettre à jour les donnees de la recette + etapes
    //pour le sql des etapes

    $sqlEtapes="";

    for($i=1;$i<=$_POST['nbrEtapes'];$i++) {
        if($i==$_POST['nbrEtapes']) {
            $sqlEtapes=$sqlEtapes.'etape'.$i.'=:etape'.$i;
        }
        else {
            $sqlEtapes=$sqlEtapes.'etape'.$i.'=:etape'.$i.',';
        }
    }

    $sql='UPDATE recette SET titre=:titre,tpsPrep=:tpsPrep,tpsCui=:tpsCui,diff=:diff,cout=:cout,calorie=:calorie,video=:video,'.$sqlEtapes.' WHERE id=:numRecette';

    $q=$pdo->prepare($sql);
    $listeModif=array(
        ':titre'=>$_POST['titre'],
        ':tpsPrep'=>$_POST['tpsPrep'],
        ':tpsCui'=>$_POST['tpsCui'],
        ':diff'=>$_POST['diff'],
        ':cout'=>$_POST['cout'],
        ':calorie'=>$_POST['calorie'],
        ':video'=>$_POST['video'],
        ':numRecette'=>$_POST['numeroRecette']
    );

    // modifier les étapes
    $etapesModif=array();
    for($i=1;$i<=$_POST['nbrEtapes'];$i++) {
        $etapesModif+=array(':etape'.$i=>$_POST['etape'.$i]);
    }

    $tabRequete=array_merge($listeModif,$etapesModif);

    // echo $sql;

    // echo '<pre> Etapes modif ';
    // print_r($etapesModif);
    // echo '</pre>';

    // echo '<pre> Tab final ';
    // print_r($tabRequete);
    // echo '</pre>';

    $q->execute($tabRequete);

    // changement et upload nouvelle image
    if(file_exists($_FILES['imgBackground']['tmp_name'])) {
        // on vérfie si un fichier a été upload
        $imgBackground = rand(1000,100000)."-".$_FILES['imgBackground']['name'];
        $file_loc = $_FILES['imgBackground']['tmp_name'];
        $file_size = $_FILES['imgBackground']['size'];
        $file_type = $_FILES['imgBackground']['type'];
        $folder="img/recette/";

        move_uploaded_file($file_loc,$folder.$imgBackground);

        $sql3="UPDATE recette SET imgBg=:imgBackground,imgBgType=:file_type,imgBgSize=:file_size WHERE id=:id";
        $q3=$pdo->prepare($sql3);
        $q3->execute(array(
            ':imgBackground'=>$imgBackground,
            ':file_type'=>$file_type,
            ':file_size'=>$file_size,
            ':id'=>$_POST['numeroRecette']
        ));
    }

    // modifier les ustensiles

    // on récupère ceux qui y sont déjà
    if(isset($_POST['already__ustensile'])) {
        // verification obligatoire si user supprime tous ceux deja presents alors on repart sur un tab vide (else)
        $ustensilesDejaPresent=$_POST['already__ustensile'];
    }
    else {
        $ustensilesDejaPresent=array();
    }

    // on fait le point sur les ustensiles dans la recette, soit il y en a des nouveaux et on les ajoute à ceux deja presents, soit on en a pas ajoute et on a seulement ceux presents

    if(isset($_POST['others__ustensile'])) {
        // nouveaux checked
        $nouveauxUstensiles=$_POST['others__ustensile'];

        // on fait la somme des anciens et des nouveaux
        $ustensilesDansLaRecette=array_merge($ustensilesDejaPresent,$nouveauxUstensiles);

        // ajout
        $i=1;
        for($i=0;$i<sizeof($nouveauxUstensiles);$i++) {
            $sql3 = 'INSERT INTO estDans (idRecette,idUstensile) VALUES ('.$_POST['numeroRecette'].','.$nouveauxUstensiles[$i].')';
            $q3=$pdo->prepare($sql3);
            $q3->execute();
        }
    }

    else {
        // si pas de nouveaux, on garde ceux qui y sont déjà
        $ustensilesDansLaRecette=$ustensilesDejaPresent;
    }

    // on remplit un tableau avec tous les ustensiles de la BDD
    $tousLesUstensilesBDD=array();
    $sql='SELECT * FROM ustensile';
    $q=$pdo->prepare($sql);
    $q->execute();
    while($line=$q->fetch()) {
        array_push($tousLesUstensilesBDD, $line['id']);
    }

    // suppression
    $ustensilesAsupp=array_diff($tousLesUstensilesBDD,$ustensilesDansLaRecette);

    foreach($ustensilesAsupp as $ustensile_id) {
        $sql='DELETE FROM estDans WHERE idRecette=:numRecette AND idUstensile=:ustensileAsupp';
        $q=$pdo->prepare($sql);
        $q->execute(array(
            ':numRecette'=>$_POST['numeroRecette'],
            ':ustensileAsupp'=>$ustensile_id
        ));
    }


    // ajouter les nveaux ing voulus à la recette selectionne

    if(isset($_POST['others'])) {
        // on regard s'il y a de nouveaux ings
        $nouveauxChecked=$_POST['others'];
        // pour debuggage, pour comprendre
        // echo '<pre> Nouveaux checked ';
        // print_r($nouveauxChecked);
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

        $i=1;
        for($i=0;$i<sizeof($nouveauxChecked);$i++) {
            $sql3 = 'INSERT INTO estDans (idRecette,idIngredient,qteIng,uniteQte) VALUES ('.$_POST['numeroRecette'].','.$nouveauxChecked[$i].',"'.$qteTab[$i].'","'.$uniteTab[$i].'")';
            $q3=$pdo->prepare($sql3);
            $q3->execute();
        }
        // fin ajouter les nveaux ing
    }


    // pour video, oui coche

    if(isset($_POST['validerVideo']) && $_POST['validerVideo']=="oui") {
        // recherche de l'id de la recette avec son nom qui vient d'etre ajoutee
        $sql5="UPDATE recette SET video=:video WHERE id=:id";
        $q5=$pdo->prepare($sql5);
        $q5->execute(array(
            ':video'=>$_POST['video'],
            ':id'=>$_POST['numeroRecette']
        ));
    } // fin du if isset video && oui


    // supprimer les ing presents dans la recette selectionnee <=> supprimer tous les ingredients pas coches

    // on récupère ceux qui y étaient déjà, on les ajoutera aux nouveaux checked puis on fera tous - (presents + nouveaux)
    if(isset($_POST['already__checked'])) {
        // verification obligatoire si user supprime tous ceux deja presents alors on repart sur un tab vide (else)
        $ingDejaPresent=$_POST['already__checked'];
    }
    else {
        $ingDejaPresent=array();
    }

    // on remplit un tableau avec tous les ing de la BDD
    $tousLesIngBDD=array();
    $sql='SELECT * FROM ingredient';
    $q=$pdo->prepare($sql);
    $q->execute();
    while($line=$q->fetch()) {
        array_push($tousLesIngBDD, $line['id']);
    }

    // on fait le point sur les ings dans la recette, soit il y en a des nouveaux et on les ajoute à ceux deja presents, soit on en a pas ajoute et on a seulement ceux presents

    if(isset($_POST['others'])) {
        $ingDansLaRecette=array_merge($ingDejaPresent,$nouveauxChecked);
    }
    else {
        $ingDansLaRecette=$ingDejaPresent;
    }

    // pour debuggage, pour comprendre
    // echo '<pre> Ing dans la recette ';
    // print_r($ingDansLaRecette);
    // echo '</pre>';

    // on créer un tableau qui contient tous les ing à supprimer => tous ceux non coches donc diff entre $tousLesIngBDD et ingDansLaRecette

    $ingAsupp=array_diff($tousLesIngBDD,$ingDansLaRecette);

    foreach($ingAsupp as $ing_id) {
        $sql='DELETE FROM estDans WHERE idRecette=:numRecette AND idIngredient=:ingAsupp';
        $q=$pdo->prepare($sql);
        $q->execute(array(
            ':numRecette'=>$_POST['numeroRecette'],
            ':ingAsupp'=>$ing_id
        ));
    }

    // pour debuggage, pour comprendre
    // echo '<pre> Pas dedans ';
    // print_r($ingAsupp);
    // echo '</pre>';

    // mise à jour des qtés et unités

    if(isset($_POST['qteIngDejaDedans']) && isset($_POST['uniteQteDejaDedans'])) {

        $qteIngDejaPresent=$_POST['qteIngDejaDedans']; // qté pour chacun de ces checked
        $uniteIngDejaPresent=$_POST['uniteQteDejaDedans']; // unite pour chacun de ces checked

        for($i=0;$i<sizeof($ingDejaPresent);$i++) {
            $sql2='UPDATE estDans SET qteIng='.$qteIngDejaPresent[$i].',uniteQte="'.$uniteIngDejaPresent[$i].'" WHERE idIngredient='.$ingDejaPresent[$i];
            $q2=$pdo->prepare($sql2);
            $q2->execute();
        }

    }


    header("Location:index.php?action=Admin_accueil");

}

?>