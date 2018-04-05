<?php
include("config/head.php");

session_start();
// création de la var de session
$_SESSION['ing_checked']=array();

?>

<!--<div class="logo">
    <p>logo</p>
</div>
<div class="content-1">
    <div class="paragraphe-home">
        <h2 id="slogan">Qu'est-ce qu'on mange ce soir ce soir  ?</h2>
        <p>Nous aussi on en a marre de se poser la même question tous les soirs.. Mais rassurez-vous, nous répondons enfin à cette question éternelle ! Vos ingrédients, nos recettes, VOS PLATS!</p>
    </div>
</div>
<div class="go">
    <a href="index.php?action=listeIngredients" class="btn-go">C'est parti</a>
</div>
<div class="img-home">

    <img src="../img/home-1.jpg" id="img-home-1">
</div>-->

<div class="home-fond">
    <img class="home-logo" src="img/icones/logo.png" alt="">
    <p class="home-p">Qu'est ce qu'on mange ? <br> Nous répondons enfin à cette question éternelle ! <br> Vos ingrédients, nos recettes, vos plats.</p>
    <img class="home-iphone" src="img/icones/iphone.png" alt="">
    <img class="home-forme" src="img/icones/homeblanc.png" alt="">
    <a href="index.php?action=listeIngredients" class="home-go">C'est parti ></a>
</div>

<div class="home-pc">
    <img src="img/icones/fourchette.png" alt="" class="fourchette">
    <div class="home-vert">
        <img src="img/icones/logo.png" alt="">
        <p>Webapplication</p>
        <h1>Qu'est ce qu'on mange ?</h1>
    </div>
    <div class="home-blanc">
        <h3>Rendez vous sur mobile</h3>
        <p>Parce qu'on a rarement son ordinateur avec soi devant le frigo ou le placard, <strong>rendez-vous</strong> sur <strong>mobile</strong> dès maintenant ! <strong>Sélectionnez</strong> vos ingrédients. <strong>Découvrez</strong> nos recettes étudiantes. Du burger maison à la poêlée de légumes, un large choix vous attend. <strong>À partager</strong> seul ou entre amis !</p>
    </div>
    <img src="img/icones/s8" alt="" class="s8">
    <iframe src="index.php" frameborder="0"></iframe>
</div>




</html>