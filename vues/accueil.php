<?php
include("config/head.php");

session_start();
// création de la var de session
if (isset($_COOKIE['cookieIng'])){
    $_SESSION['ing_checked']=array();
    $_SESSION['ing_checked']=unserialize($_COOKIE['cookieIng']);
    $ingChecked_serialize = serialize($_SESSION['ing_checked']);
    setcookie("cookieIng", $ingChecked_serialize, time()+24*60*60,'/');
}else{
    $_SESSION['ing_checked']=array();
}


//echo '<br>';
if (isset($_COOKIE['cookieIng'])) {
    $tab_cookies = unserialize($_COOKIE['cookieIng']);
//echo "<br>mes ing : ".print_r($tab_cookies); // Array ( [0] => moto [1] => voiture [2] => vélo )
}
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

<div class="home-ing">

    <?php
    if(isset($_COOKIE['cookieIng'])){
        echo "<h4>Votre liste de la dernière fois</h4>";
        echo "<div class='home-ing-grid'>";
        for($i=0;$i<sizeof($tab_cookies);$i++) {

            $sql = "SELECT * FROM ingredient WHERE id=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($tab_cookies[$i]));

            while($line=$q->fetch()) {
                echo "<div class='liste__item'>";
                echo "<img src=img/".$line['type']."/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
                echo "<p class=liste-nom>".$line['nom']."</p>";
                echo "<a href=index.php?id=".$line['id']."&action=supprimer><img src='img/icones/cancel.png' class='croix-supp' alt='supprimer'></a>";
                echo "</div>";
            }
        }
        echo "</div>";
        echo "<a class='btn-home' href='index.php?action=listeIngredients' style='margin-top: 20px;'>Continuer</a>";
        echo "<a class='btn-home' href=\"index.php?action=videPanier\" style='background: none;border: 2px #73ba74 solid;color: #73ba74;'>Nouvelle liste</a>";
    }else{
        echo "<ul>
                    <li><span class='home-etape'>1</span> Choisissez vos ingrédients parmi les différentes catégories<br></li>
                    <li><span class='home-etape'>2</span> Swipez vers la droite vous vérifier votre liste d'ingredients<br></li>
                    <li><span class='home-etape'>3</span> Swipez encore une fois et découvrez les nouvelles recettes que vous pouvez cuisiner<br></li>
               </ul>
                   <a href=\"index.php?action=listeIngredients\" class=\"btn-home\">C'est parti</a>
               ";
    }

    ?>
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
    <div class="div-iframe">
    <img src="img/icones/iphonex.png" alt="" class="iphonex">
    <iframe src="index.php" frameborder="0"></iframe>
    </div>
</div>




</html>