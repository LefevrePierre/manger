<!-- Page ingrédients et liste de checked -->
<!-- Swiper -->
<?php

include('config/head.php');
session_start(); // pour garder la var de SESSION

?>
<div class="ingredient-panier">
            <?php
                        //affichage de l'ingrédient ajouté s'il existe (pas la premiere fois)
                        if(isset($_GET['nom'])) {
                            echo "<p>Vous avez ajouté : ".$_GET['nom']."</p>";
                        }
            ?>
</div>
<div class="ingredient-panier-supp"> 
            <?php 
                        //affichage de l'ingrédient supprimé s'il existe (pas la premiere fois)
                        if(isset($_GET['nomSupp'])) {
                            echo "<p>Vous avez supprimé : ".$_GET['nomSupp']."</p>";
                        }
            ?>
</div>
 <div class="header-manger" id="header">
                <nav>

                    <ul class="ul-header">
                        <li class="nav-manger" id="page-ingredients">
                            <a href="#slide1">Ingrédients<div class="triangle"></div></a>

                        </li>
                        <li class="nav-manger" id="maliste">
                            <a href="#slide2">Ma liste<div class="triangle"></div></a>

                        </li>
                        </li>
                        <li class="nav-manger" id="recettes">
                            <a href="#slide3">Recettes<div class="triangle"></div></a>

                        </li>
                    </ul>

                </nav>
</div>
<div class="swiper-container">

    <div class="swiper-wrapper">

        <div class="swiper-slide" data-hash="slide1" id="slideIng">

            <div class="content-manger">
                <div class="col-md-6 col-sm-6 col-xs-6" id="categorie1">
                    

                    <!-- test affichage une image
                    <div class="ingredient-checkable">
                        <img src="img/viandes/colin.png" alt="colin.png"> PAS de ../
                        <a href="#">+</a>
                    </div>-->
                    
                    <?php
    //affichage des div comprenant img + bouton ajouter
     $sql="SELECT imgListe,id,nom FROM ingredient WHERE type='Viande-Poisson'";
     $q = $pdo->prepare($sql);
     $q->execute();
     while ($line=$q->fetch()) {
        echo "<div class=item-container>";
        echo "<img src=img/Viande-Poisson/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
        echo "<p class=nom>".$line['nom']."</p>";
        echo "<a href=index.php?id=".$line['id']."&action=ajouter class='ajout'>+</a>";
         echo "</div>";
         


     }

?>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6" id="categorie2">
                    <?php
    //affichage des div comprenant img + bouton ajouter
     $sql="SELECT imgListe,id,nom FROM ingredient WHERE type='Légume'";
     $q = $pdo->prepare($sql);
     $q->execute();
     while ($line=$q->fetch()) {
        echo "<div class=item-container>";
        echo "<img src=img/Légume/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
         echo "<p class=nom>".$line['nom']."</p>";
        echo "<a href=index.php?id=".$line['id']."&action=ajouter class=ajout>+</a>";
        echo "</div>";

     }

?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6" id="categorie3">

                    <?php
    //affichage des div comprenant img + bouton ajouter
     $sql="SELECT imgListe,id,nom FROM ingredient WHERE type='Féculent'";
     $q = $pdo->prepare($sql);
     $q->execute();
     while ($line=$q->fetch()) {
        echo "<div class=item-container>";
        echo "<img src=img/Féculent/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
         echo "<p class=nom>".$line['nom']."</p>";
        echo "<a href=index.php?id=".$line['id']."&action=ajouter class=ajout>+</a>";
        echo "</div>";

     }

?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6" id="categorie4">

                    <?php
    //affichage des div comprenant img + bouton ajouter
     $sql="SELECT imgListe,id,nom FROM ingredient WHERE type='Laitier'";
     $q = $pdo->prepare($sql);
     $q->execute();
     while ($line=$q->fetch()) {
        echo "<div class=item-container>";
        echo "<img src=img/Laitier/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
         echo "<p class=nom>".$line['nom']."</p>";
        echo "<a href=index.php?id=".$line['id']."&action=ajouter class=ajout>+</a>";
        echo "</div>";

     }

?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6" id="categorie5">

                    <?php
    //affichage des div comprenant img + bouton ajouter
     $sql="SELECT imgListe,id,nom FROM ingredient WHERE type='Divers'";
     $q = $pdo->prepare($sql);
     $q->execute();
     while ($line=$q->fetch()) {
        echo "<div class=item-container>";
        echo "<img src=img/Divers/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
         echo "<p class=nom>".$line['nom']."</p>";
        echo "<a href=index.php?id=".$line['id']."&action=ajouter class=ajout>+</a>";
        echo "</div>";

     }
?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6" id="categorie6">

                    <div class='search-div'> <input type='text' name='search-input' id='search-input'/></div>
                    <div class='searchResult-div'></div>
                </div>

            </div>
            <!-- Fin content-manger -->
        </div>
        <!-- Fin Slide ingrédients -->
        <!-- Slide liste -->
        <div class="swiper-slide" data-hash="slide2"><?php include('liste.php');?></div>
        <div class="swiper-slide" data-hash="slide3"><?php include('selectionRecette.php');?></div>
        <!-- Fin Slide liste -->

        <footer>
<div class="footer__container">
                        <ul>

                            <li class="footer__icon" id="footer__first-icon" onclick="afficherCategorie(1);"><span class="icon-chicken"></li>
                            <li class="footer__icon" onclick="afficherCategorie(2);"><span class="icon-cabbage"></li>
                            <li class="footer__icon" onclick="afficherCategorie(3);"><span class="icon-spaguetti"></li>
                            <li class="footer__icon" onclick="afficherCategorie(4);"><span class="icon-milk"></span></li>
                            <li class="footer__icon" onclick="afficherCategorie(5);"><span class="icon-salt-and-pepper"></li></li>
                            <li class="footer__icon" id="footer__last-icon"onclick="afficherCategorie(6);"><span class="icon-magnifying-glass"></li></li>
                        </ul>
</div>
            </footer>
       
    <!-- Initialize Swiper -->
    <script>
        var mySwiper = new Swiper('.swiper-container', {
                watchState: true,
                replaceState: true,
                hashNavigation: {
                    watchState: true,
                },
            });

    </script>

    <!-- Fin Page ingrédients et liste de checked -->
