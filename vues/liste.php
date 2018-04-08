<?php
include('config/head.php');
?>
<div class="swiper-slide" id="slideListe">

            <section id="MaListe">
            <!-- Début de la liste -->


            <?php
            // débuggage
            // echo "<pre> SESSION actuelle : ";
            // print_r($_SESSION['ing_checked']);
            // echo "</pre>";
        // on vérifie que la session existe
        if(isset($_SESSION['ing_checked'])) {
            //message si liste vide
            $nbrCoches=COUNT($_SESSION['ing_checked']);
            $nbrManquant=4-$nbrCoches;
            if($nbrCoches==0) {
                 echo "<img class='img-vide' src='img/icones/vide.png'>";
            }
            if($nbrManquant==1) { //gestion du pluriel
                echo "<p class=pas-ing__coch>Merci de cocher au moins ".$nbrManquant." ingrédient supplémentaire pour voir une recette</p>";
            }
            else if($nbrManquant>0) {
                    echo "<p class=pas-ing__coch>Merci de cocher au moins ".$nbrManquant." ingrédients supplémentaires pour voir une recette</p>";
            }

            // 1. on remplit un tab ViandesPoissonsBDD à partir des viandes et poissons de la BDD
            $ViandesPoissonsBDD=array();
            $sql="SELECT * FROM ingredient WHERE type='Viande-Poisson'";
            $q=$pdo->prepare($sql);
            $q->execute();
            while($line=$q->fetch()) {
                array_push($ViandesPoissonsBDD,$line['id']);

            }

            // on fait de meme pour les autres types d'ing de la BDD
            // légumes
            $LegumesBDD=array();
            $sql="SELECT * FROM ingredient WHERE type='Légume'";
            $q=$pdo->prepare($sql);
            $q->execute();
            while($line=$q->fetch()) {
                array_push($LegumesBDD,$line['id']);
            }

            //féculents
            $FeculentBDD=array();
            $sql="SELECT * FROM ingredient WHERE type='Féculent'";
            $q=$pdo->prepare($sql);
            $q->execute();
            while($line=$q->fetch()) {
                array_push($FeculentBDD,$line['id']);
            }

            //laitage
            $LaitierBDD=array();
            $sql="SELECT * FROM ingredient WHERE type='Laitier'";
            $q=$pdo->prepare($sql);
            $q->execute();
            while($line=$q->fetch()) {
                array_push($LaitierBDD,$line['id']);
            }

            //divers
            $DiversBDD=array();
            $sql="SELECT * FROM ingredient WHERE type='Divers'";
            $q=$pdo->prepare($sql);
            $q->execute();
            while($line=$q->fetch()) {
                array_push($DiversBDD,$line['id']);
            }

            // 2. on compare le type d'aliment aux ing checked
            // viandes à afficher
            $viandespoissonsAffiches=array_intersect($ViandesPoissonsBDD,$_SESSION['ing_checked']);
            
            //légumes à afficher
            $legumesAffiches=array_intersect($LegumesBDD,$_SESSION['ing_checked']);

            //féculents à afficher
            $feculentAffiches=array_intersect($FeculentBDD,$_SESSION['ing_checked']);

            //laitiers à afficher
            $laitierAffiches=array_intersect($LaitierBDD,$_SESSION['ing_checked']);

            //divers à afficher
            $diversAffiches=array_intersect($DiversBDD,$_SESSION['ing_checked']);

            // débuggage
            // echo "<pre> BDD : ";
            // print_r($ViandesPoissonsBDD);
            // echo "</pre>";

            // echo "<pre>";
            // print_r($viandespoissonsAffiches);
            // echo "</pre>";
            
            // s'il y a des viandes poissons parmi les checked, on affiche image et bouton - pour chaque
            echo "<div class='liste__cat-container'>";
            if(COUNT($viandespoissonsAffiches)>0) {

                echo "<h3 class='liste-titre'>Mes viandes et poissons</h3>";
                echo "<div class='liste__cat'>";
                // on passe en revue tous les ingredients checked du type viande/poisson
                foreach ($viandespoissonsAffiches as $key => $id) {
                    // pour chaque, on va chercher l'image et l'id (pour le supprimer si voulu)
                    $sql="SELECT * FROM ingredient WHERE id = ?";          
                    $q=$pdo->prepare($sql);
                    $q->execute(array($id));
                    while($line=$q->fetch()) {
                        echo "<div class='liste__item'>";
                        echo "<img src=img/Viande-Poisson/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
                        echo "<p class=liste-nom>".$line['nom']."</p>";
                        echo "<a href=index.php?id=".$line['id']."&action=supprimer><img src='img/icones/cancel.png' class='croix-supp' alt='supprimer'></a>";
                        echo "</div>";
                    }
                    // fin du while
                }
                // fin du foreach
                echo "</div>";
            }
            // fin du if COUNT Viandes & Poissons

            if(COUNT($legumesAffiches)>0) {

                echo "<h3 class='liste-titre'>Mes légumes</h3>";
                echo "<div class='liste__cat'>";
                // on passe en revue tous les ingredients checked du type viande/poisson
                foreach ($legumesAffiches as $key => $id) {
                    // pour chaque, on va chercher l'image et l'id (pour le supprimer si voulu)
                    $sql="SELECT * FROM ingredient WHERE id = ?";          
                    $q=$pdo->prepare($sql);
                    $q->execute(array($id));
                    while($line=$q->fetch()) {
                        echo "<div class='liste__item'>";
                        echo "<img src=img/Légume/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
                        echo "<p class=liste-nom>".$line['nom']."</p>";
                        echo "<a href=index.php?id=".$line['id']."&action=supprimer><img src='img/icones/cancel.png' class='croix-supp' alt='supprimer'></a>";
                        echo "</div>";
                    }
                    // fin du while
                }
                // fin du foreach
                echo "</div>";

            }
            // fin du if COUNT Légumes

            if(COUNT($feculentAffiches)>0) {

                echo "<h3 class='liste-titre'>Mes féculents</h3>";
                echo "<div class='liste__cat'>";
                // on passe en revue tous les ingredients checked du type viande/poisson
                foreach ($feculentAffiches as $key => $id) {
                    // pour chaque, on va chercher l'image et l'id (pour le supprimer si voulu)
                    $sql="SELECT * FROM ingredient WHERE id = ?";          
                    $q=$pdo->prepare($sql);
                    $q->execute(array($id));
                    while($line=$q->fetch()) {
                        echo "<div class='liste__item'>";
                        echo "<img src=img/Féculent/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
                        echo "<p class=liste-nom>".$line['nom']."</p>";
                        echo "<a href=index.php?id=".$line['id']."&action=supprimer><img src='img/icones/cancel.png' class='croix-supp' alt='supprimer'></a>";
                        echo "</div>";
                    }
                    // fin du while
                }
                // fin du foreach
                echo "</div>";

            }
            // fin du if COUNT Féculents

            if(COUNT($laitierAffiches)>0) {

                echo "<h3 class='liste-titre'>Mes produits laitiers</h3>";
                echo "<div class='liste__cat'>";
                // on passe en revue tous les ingredients checked du type viande/poisson
                foreach ($laitierAffiches as $key => $id) {
                    // pour chaque, on va chercher l'image et l'id (pour le supprimer si voulu)
                    $sql="SELECT * FROM ingredient WHERE id = ?";          
                    $q=$pdo->prepare($sql);
                    $q->execute(array($id));
                    while($line=$q->fetch()) {
                        echo "<div class='liste__item'>";
                        echo "<img src=img/Laitier/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
                        echo "<p class=liste-nom>".$line['nom']."</p>";
                        echo "<a href=index.php?id=".$line['id']."&action=supprimer><img src='img/icones/cancel.png' class='croix-supp' alt='supprimer'></a>";
                        echo "</div>";
                    }
                    // fin du while
                }
                // fin du foreach
                echo "</div>";

            }
            // fin du if COUNT Laitiers

             if(COUNT($diversAffiches)>0) {

                echo "<h3 class='liste-titre'>Mes autres produits</h3>";
                 echo "<div class='liste__cat'>";
                // on passe en revue tous les ingredients checked du type viande/poisson
                foreach ($diversAffiches as $key => $id) {
                    // pour chaque, on va chercher l'image et l'id (pour le supprimer si voulu)
                    $sql="SELECT * FROM ingredient WHERE id = ?";          
                    $q=$pdo->prepare($sql);
                    $q->execute(array($id));
                    while($line=$q->fetch()) {
                        echo "<div class='liste__item'>";
                        echo "<img src=img/Divers/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
                        echo "<p class=liste-nom>".$line['nom']."</p>";
                        echo "<a href=index.php?id=".$line['id']."&action=supprimer><img src='img/icones/cancel.png' class='croix-supp' alt='supprimer'></a>";
                        echo "</div>";
                    }
                    // fin du while
                }
                // fin du foreach
                 echo "</div>";

             }
            // fin du if COUNT Divers
            echo "</div>";

        }
    // fin du if isset SESSION
        
            
?>
            <!-- Fin Affichage divers sélectionnés -->
            </section>
</div>
        <!-- Fin Slide liste -->


    <!-- Swiper JS -->
    <script src="dist/js/swiper.min.js"></script>
