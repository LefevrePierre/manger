<?php
include('config/head.php');
if(isset($_GET['id'])) {
    $sql = "SELECT * FROM recette WHERE id=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($_GET['id']));
    if ($line = $q->fetch()) {
        //header
        echo "<div class='header-manger'>";
        echo "<nav>";
        echo "<h1 class='recette__title'>" . $line['titre'] . "</h1>";
        echo "</nav>";
        echo "</div>";
        echo "<button><a href=index.php?action=selection>&#171;</a></button>";
        //fin header

        echo "<div class=recette__mainimg style='background: url(img/recette/" . $line['imgBg'] . ");background-size: cover;'></div>";

        echo "<div class='div-recette__info'>";
        echo "<h2 class='recette__infos-title'>" . $line['titre'] . "</h2>";
        echo "<div class='recette__infos'>";

        echo "<div class='recette__g'>";
        echo "<span class='icon-stopwatch'></span><span class='recette__tps1'>" . $line['tpsPrep'] . " min</span>";
        echo "</div>";
        echo "<div class='recette__g'>";
        echo "<span class='icon-stopwatch'></span><span class='recette__tps2'>" . $line['tpsCui'] . " min</span>";
        echo "</div>";

        echo "<div class='recette__g'>";
        echo "<p class='recette__inf'>Difficulté : " . $line['diff'] . "</p>";
        echo "</div>";
        echo "<div class='recette__g'>";
        echo "<p class='recette__inf'>Coût : " . $line['cout'] . "</p>";
        echo "</div>";
        echo "</div>";

        echo "<span class='recette__ustensiles'>" . $line['ustensile'] . "</span>";


        echo "<p class=''>" . $line['calorie'] . " kcal</p>";
        echo "</div>";


        echo "<div class='recette__container'>";

        echo "<div class='ingredients-recette-div'>";

        $sql = "SELECT * FROM ingredient JOIN estdans ON ingredient.id=idIngredient WHERE idRecette=? ";
        $q = $pdo->prepare($sql);
        $q->execute(array($_GET['id']));
        echo "<div class='ingredients-recette'>";
        while ($line = $q->fetch()) {
            echo "<div>" . $line['nom'] . "<img class='ingredients-recette-img' src='img/Féculent/".$line['imgListe']."'> </div>";
        }
        echo "</div>";
        echo "</div>";

        echo "<div>";


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
	?>