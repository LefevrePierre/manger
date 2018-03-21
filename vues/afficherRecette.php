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
		echo "<h2 id=titre-projet>Qu'est-ce qu'on mange ?</h2>";
		echo "<p>".$line['titre']."</p>";
		echo "</nav>";
		echo "</div>";
		echo "<button><a href=index.php?action=selection>&#171;</a></button>";
		//fin header
		echo "<p><img src=img/bgRecette/".$line['imgBg']." alt= ".$line['titre']."</p>";
	 }
	}
?>