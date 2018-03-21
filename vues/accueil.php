<?php
include("config/head.php");

session_start();
// création de la var de session
$_SESSION['ing_checked']=array();

?>

<div class="logo">
    <p>logo</p>
</div>
<div class="content-1">
    <div class="paragraphe-home">
        <h2 id="slogan">Qu'est-ce qu'on mange ce soir ?</h2>
        <p>Nous aussi on en a marre de se poser la même question tous les soirs.. Mais rassurez-vous, nous répondons enfin à cette question éternelle ! Vos ingrédients, nos recettes, VOS PLATS!</p>
    </div>
</div>
<div class="go">
    <a href="index.php?action=listeIngredients" class="btn-go">C'est parti</a>
</div>
<div class="img-home">

    <img src="img/home-1.jpg" id="img-home-1">
</div>

</html>