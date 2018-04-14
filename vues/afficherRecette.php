<?php
include('config/head.php');
include('config/bd.php');

if(isset($_GET['id'])) {
    $sql = "SELECT * FROM recette WHERE id=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($_GET['id']));
    if ($line = $q->fetch()) {
        //header
        echo "<div class='header-manger'>";
        echo "<nav>";
        echo "<h1 class='recette__title'>" . $line['titre'] . "</h1>";
        echo "<a href='javascript:history.go(-1)'><span id='retourne'  class='icon-back'></a></span>";
        echo "</nav>";
        echo "</div>";
        echo "<button><a href=index.php?action=selection>&#171;</a></button>";

        //fin header

        echo "<div class=recette__mainimg style='background: url(img/recette/" . $line['imgBg'] . ");background-size: cover;background-position: center;'></div>";

        echo "<div class='div-recette__info'>";
        echo "<h2 class='recette__infos-title'>" . $line['titre'] . "</h2>";
        echo "<div class='recette__infos'>";

        echo "<div class='recette__g'>";
        echo "<span class='icon-chopping-board'></span><span class='recette__tps1'>" . $line['tpsPrep'] . " min</span>";
        echo "</div>";
        echo "<div class='recette__g'>";
        echo "<span class='icon-pan'></span><span class='recette__tps2'>" . $line['tpsCui'] . " min</span>";
        echo "</div>";

        echo "<div class='recette__g'>";
        echo "<p class='recette__inf'>Difficulté : " . $line['diff'] . "</p>";
        echo "</div>";
        echo "<div class='recette__g'>";
        echo "<p class='recette__inf'>Coût : " . $line['cout'] . "</p>";
        echo "</div>";
        echo "</div>";

        $sql2= "SELECT nom FROM ustensile JOIN estDans on ustensile.id=idUstensile JOIN recette ON recette.id=idRecette WHERE idRecette=?";
        $q2 = $pdo->prepare($sql2);
        $q2->execute(array($_GET['id']));
        while($line2 = $q2->fetch()) {
            echo "<span class='recette__ustensiles'>" . $line2['nom'] . "</span><br>";
        }

        echo "<br><span class='recette__ustensiles'>" . $line['calorie'] . " cal</span><br>";
        echo "</div>";


        echo "<div class='recette__container'>";
        echo "<h4>INGRÉDIENTS</h4>";
        echo "<div class=\"div-nbPersonne\">
                    <button class=\"btn-moins\">-</button><span class=\"disp-np\">1</span><button class=\"btn-plus\">+</button> personne(s)
                </div>";
        echo "<div class='ingredients-recette-div'>";

        $sql3="SELECT nom,qteIng,uniteQte,type,imgListe FROM estDans JOIN ingredient ON ingredient.id=idIngredient WHERE idRecette=?";
        $q3=$pdo->prepare($sql3);
        $q3->execute(array($_GET['id']));
        echo "<div class='ingredients-recette'>";
        while ($line = $q3->fetch()) {
            echo "<div><span>".$line['nom']."</span>"."<span><input value='".$line['qteIng']."' class='quantite'></input>".$line['uniteQte']."</span>". "<img class='ingredients-recette-img' src='img/".$line['type']."/".$line['imgListe']."'>"." </div>";
        }
        echo "</div>";
        echo "</div>";

        echo "<div>";


        /*
                $sql3="SELECT nom,qteIng,uniteQte,type,imgListe FROM estDans JOIN ingredient ON ingredient.id=idIngredient WHERE idRecette=?";
                $q3=$pdo->prepare($sql3);
                $q3->execute(array($_GET['id']));

        while($line=$q3->fetch()) {
            echo $line['qteIng'];
            echo $line['uniteQte'];
            echo $line['nom'];
            echo $line['type'];
            echo $line['imgListe'];
        }*/

        echo "<iframe width=\"100%\" height=\"218px\" src=\"https://www.youtube.com/embed/woYrzHuC7yw?rel=0&amp;showinfo=0\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>";



        if (isset($_GET['id'])) {
            // liste des étapes, on affiche toutes celles qui ne sont pas vides dans la BDD
            $i = 1;
            $sql2 = 'SELECT * FROM recette WHERE id=?';
            $q2 = $pdo->prepare($sql2);
            $q2->execute(array($_GET['id'])); //id de la recette sélectionnée dans la liste proposée
            $line2 = $q2->fetch();
            echo '<div>';
            while (!empty($line2['etape' . $i]) AND $i < 10) {
                echo "<div class='etape'>";
                echo '<h4>Etape ' . $i . '</h4>';
                echo '<div>' . $line2['etape' . $i] . '</div>';
                $i++;
                echo '</div>';
            }
            echo '</div>';

            echo "</div>";

        }
    }
}


if(isset($_GET['id']) AND !empty($_GET['id'])) {

    $getid = htmlspecialchars($_GET['id']);

    $sql="SELECT * FROM recette WHERE id = ?";

    $recette = $pdo->prepare($sql);


    $recette->execute(array($getid));


    $recette = $recette->fetch();

    if(isset($_POST['submit_commentaire'])) {


        if(isset($_POST['pseudo'],$_POST['commentaire']) AND !empty($_POST['pseudo']) AND !empty($_POST['commentaire'])) {

            $pseudo = htmlspecialchars($_POST['pseudo']);

            $commentaire = htmlspecialchars($_POST['commentaire']);

            if(strlen($pseudo) < 25) {
                $ins = $pdo->prepare('INSERT INTO commentaires (pseudo, commentaire, id_recette) VALUES (?,?,?)');

                $ins->execute(array($pseudo,$commentaire,$getid));


                $c_msg = "<span style='color:green'>Votre commentaire a bien été posté</span>";

            } else {
                $c_msg = "Erreur: Le pseudo doit faire moins de 25 caractères";
            }
        } else {
            $c_msg = "Erreur: Tous les champs doivent être complétés";
        }
    }


    $commentaires = $pdo->prepare('SELECT * FROM commentaires WHERE id_recette = ? ORDER BY id DESC');
    $commentaires->execute(array($getid));

    echo"<div class='commentaire__container'>";
    echo" <h5 class='commentaire__title'>Commentaires:</h5>";
    while($c = $commentaires->fetch()) {
        echo" <div class='fieldset'>";
        echo" </div>";
        echo "<span class='commentaire__pseudo'>" . $c['pseudo'] . " à écrit:</span>";
        echo "<span class='commentaire__contenu'>" . $c['commentaire'] . "</span>";

    }
    echo" <h5 class='commentaire__title'>Partagez votre expérience :</h5>";?>

    <br />

    <form method="POST">
        <input type="text" name="pseudo" class="commentaire__form-pseudo" placeholder="Prenom" /><br />
        <textarea name="commentaire" class="commentaire__form-contenu" placeholder="Commentaire"></textarea><br />
        <input type="submit" value="Poster mon commentaire" class="commentaire__form-btn" name="submit_commentaire" style="margin-bottom: 50px" />
    </form>
    </div>


    <?php if(isset($c_msg)) { echo "<p class='commentaire__message'>".$c_msg."</p>"; } ?>
    <br /><br />

    <?php
}

?>