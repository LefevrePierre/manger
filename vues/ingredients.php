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
                            <a href="#slide1">Ingrédients</a>
                        </li>
                        <li class="nav-manger" id="maliste">
                            <a href="#slide2">Ma liste</a></li>
                        </li>
                        <li class="nav-manger" id="recettes">
                            <a href="#slide3">Recettes</a>
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
     $sql="SELECT imgListe,id,nom FROM ingredient WHERE type='Viandes & poissons'";
     $q = $pdo->prepare($sql);
     $q->execute();
     while ($line=$q->fetch()) {
        echo "<div class=item-container>";
        echo "<img src=img/Viande-Poisson/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
        echo "<p class=nom>".$line['nom']."</p>";
        echo "<a href=index.php?id=".$line['id']."&action=ajouter class=ajout>+</a>";
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
     $sql="SELECT imgListe,id FROM ingredient WHERE type='Divers'";
     $q = $pdo->prepare($sql);
     $q->execute();
     while ($line=$q->fetch()) {
        echo "<div class=item-container>";
        echo "<img src=img/Divers/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
        echo "<a href=index.php?id=".$line['id']."&action=ajouter class=ajout>+</a>";
        echo "</div>";

     }
?>
                </div>
            </div>
            <!-- Fin content-manger -->
        </div>
        <!-- Fin Slide ingrédients -->
        <!-- Slide liste -->
        <div class="swiper-slide" data-hash="slide2"><?php include('liste.php');?></div>
        <div class="swiper-slide" data-hash="slide3"><?php include('selectionRecette.php');?></div>
        <!-- Fin Slide liste -->
        <footer id="footer">
                    <div class="footer-manger">
                        <ul class="ul-footer">

                            <li class="nav-footer" onclick="afficherCategorie(1);"><img src="img/icones/viandespoissons.png" onmouseover="this.src='img/icones/viandespoissons-hover.png'" class="test" id="img-footer-2"onmouseout="this.src='img/icones/viandespoissons.png'" class="test" id="img-footer-1"><span id="txt-footer">Viandes</span></li>
                            <li class="nav-footer" onclick="afficherCategorie(2);"><img src="img/icones/légumes.png" onmouseover="this.src='img/icones/légumes-hover.png'" class="test" id="img-footer-2"onmouseout="this.src='img/icones/légumes.png'"><span id="txt-footer">Légumes</span></li>
                            <li class="nav-footer" onclick="afficherCategorie(3);"><img src="img/icones/féculent.png"onmouseover="this.src='img/icones/féculent-hover.png'" class="test" id="img-footer-2"onmouseout="this.src='img/icones/féculent.png'" class="test" id="img-footer-3"><span id="txt-footer">Féculents</span></li>
                            <li class="nav-footer" onclick="afficherCategorie(4);"><img src="img/icones/lait.png"onmouseover="this.src='img/icones/lait-hover.png'" class="test" id="img-footer-2"onmouseout="this.src='img/icones/lait.png'" class="test" id="img-footer-4"><span id="txt-footer">Laitages</span></li>
                            <li class="nav-footer" onclick="afficherCategorie(5);"><img src="img/icones/divers.png"onmouseover="this.src='img/icones/divers-hover.png'" class="test" id="img-footer-2"onmouseout="this.src='img/icones/divers.png'" class="test" id="img-footer-5"><span id="txt-footer">Divers</span></li>
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
