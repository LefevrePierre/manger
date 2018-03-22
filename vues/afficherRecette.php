<?php
include('config/head.php');
if(isset($_GET['id'])) {
	 $sql="SELECT * FROM recette WHERE id=?";
	 $q = $pdo->prepare($sql);
	 $q->execute(array($_GET['id']));
	 if ($line=$q->fetch()) {
	 	//header
        echo "<div class='header-manger'>";
		echo "<nav>";
		echo "<h1 class='recette__title'>".$line['titre']."</h1>";
		echo "</nav>";
		echo "</div>";
		echo "<button><a href=index.php?action=selection>&#171;</a></button>";
		//fin header

         echo "<div class=recette__mainimg style='background: url(img/recette/".$line['imgBg']."');></div>";


         echo "<h2 class='recette__infos-title'>".$line['titre']."</h2>";
         echo "<div class='recette__infos'>";

                echo "<div class='recette__g'>";
                     echo "<span class='icon-stopwatch'></span><span class='recette__tps1'>".$line['tpsPrep']." min</span>";
                     echo "</div>";
                  echo "<div class='recette__g'>";
            echo "<span class='icon-stopwatch'></span><span class='recette__tps2'>".$line['tpsCui']." min</span>";
         echo "</div>";


         echo "<div class='recette__g'>";
         echo "<p class='recette__inf'>Difficulté : ".$line['diff']."</p>";
         echo "</div>";
         echo "<div class='recette__g'>";
         echo "<p class='recette__inf'>Coût : ".$line['cout']."</p>";
         echo "</div>";
         echo "</div>";

         echo "<span class='recette__ustensiles'>".$line['ustensile']."</span>";

         echo "<p class=''>".$line['calorie']." kcal</p>";


         echo "<div class='recette__container'>";
         echo "</div>";

	 }
	}
?>