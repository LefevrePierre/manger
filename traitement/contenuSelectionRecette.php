<?php

session_start();
include('../config/head.php');
include('../config/bd.php');

//remplissage des tableaux de recettes et ingredients de cette recette
$recetteTab=array();
$recetteTabImg=array();
$ingredientsDeLaRecette=array($recetteTab);

$sql1="SELECT DISTINCT titre, imgBg FROM recette";
$sql2="SELECT idIngredient FROM estDans JOIN recette ON recette.id=idRecette WHERE idIngredient!=0 AND idRecette=? GROUP BY idIngredient";

$q1 = $pdo->prepare($sql1);

$numRecette=1;
$a=1;

$q1->execute();
$_SESSION['nbRecettes'] = 0;
while ($line1=$q1->fetch()) { // ne pas oublier de le mettre

    $recetteTab[$numRecette]=$line1['titre'];
    $recetteTabImg[$numRecette]=$line1['imgBg'];

    $q2 = $pdo->prepare($sql2);
    $q2->execute(array($numRecette));

    while ($line2=$q2->fetch()) { // ne pas oublier de le mettre
        $ingredientsDeLaRecette[$numRecette][$a]=$line2['idIngredient'];
        $a=$a+1;
    }

    $a=1;

    $numRecette=$numRecette+1;

}

//message si pas assez d'ingrédients
if(isset($_SESSION['ing_checked'])) {
    $nbrCoches=COUNT($_SESSION['ing_checked']);
    if($nbrCoches<2) {
        echo "<div class=pas-ing>";
        echo "<img class='img-vide' src='img/icones/recetteVide.png'>";
        echo "<p class=pas-ing__coch>Pas de recette trouvée</p>";
        echo "</div>";
    }
    // TOUS LES INGREDIENTS ET PLUS
    else {

        $x=0;
        $recetteTrouve=false;


        foreach($ingredientsDeLaRecette as $niemeIng => $idIng) {
            $result= array_diff($ingredientsDeLaRecette[$niemeIng], $_SESSION['ing_checked']);
            /*echo "niemeIng = ".$niemeIng."<br>";*/

            if($result==array() && $x>0){
                /* echo "<h5>".$recetteTab[$niemeIng]."</h5>";

                 //div fictive pour intégrer
                 echo "<div class='imgRecette'></div>";
                 echo "<div class='titreRecette'>

                     </div>";*/

                echo "<h2 class='selectionRecette-titre'>Recettes trouvées</h2>";
                echo "<div class='selectionRecette-conteneur'>";
                echo "<div class='selectionRecette-div'>
                                <div class='selectionRecette-desc'>
                                    <h5>".$recetteTab[$niemeIng]."</h5>
                                    <a href=index.php?id=".$niemeIng."&action=afficherRecette><img src='img/icones/iconfleche.png' alt=''></a>
                                </div>
                          </div>";
                echo "</div>";
                $_SESSION['nbRecettes']++;

                //il faut mettre dans ce echo une div avec un bgimg
                //echo "<img src='img/recette/".$recetteTabImg[$niemeIng]."'>";

                $recetteTrouve=true;
                /*                    echo "<a href=index.php?id=".$niemeIng."&action=afficherRecette><img src='img/icones/iconfleche.png' alt=''></a>";*/
            }
            $x++;
        }


        // TOUS LES INGREDIENTS MOINS 1
        $y=0;
        $recetteTrouveManque1=false;
        $ingredientManquant="";
        $nomIngredientManquant="";




        foreach($ingredientsDeLaRecette as $niemeIng => $idIng) {
            $result= array_diff($ingredientsDeLaRecette[$niemeIng], $_SESSION['ing_checked']);
            /* var_dump($result)*/;
            /*echo "niemeIng = ".$niemeIng."<br>";*/
            if(count($result)==1 && $y>0) {
                // echo '<pre>';
                // print_r($result);
                // echo '</pre>';
                //echo $recetteTab[$niemeIng]."<br>";
                //echo "<img src='img/recette/".$recetteTabImg[$niemeIng]."'>";
                foreach($result as $idManquant => $idRecette){
                    $ingredientManquant=$result[$idManquant];
                    $sql="SELECT nom FROM ingredient WHERE id=?";
                    $q=$pdo->prepare($sql);
                    $q->execute(array($ingredientManquant));
                    if($line=$q->fetch()) {
                        $nomIngredientManquant=$line['nom'];
                    }
                }
                echo "<h2 class='selectionRecette-titre'>Il vous manque 1 ingrédient</h2>";
                echo "<div class='selectionRecette-conteneur'>";
                echo "<div class='selectionRecette-div'>";
                $sql="SELECT * FROM recette WHERE id=?";
                $q=$pdo->prepare($sql);
                $q->execute(array($recetteTab[$niemeIng]));
                if($line=$q->fetch()) {
                    echo    '<div class="manque" style="background-image:url(img/recette/94878-thon_puree.jpg);">Ingrédient manquant :<br> '.$nomIngredientManquant.'</div>
                                <div class="selectionRecette-desc">
                                    <h5>'.$recetteTab[$niemeIng].'</h5>
                                    <a href=index.php?id='.$niemeIng.'&action=afficherRecette><img src="img/icones/iconfleche.png" alt=""></a>
                                </div>
                     </div>';
                    echo "</div>"; // fin de div selectionRecette-conteneur
                }

                $_SESSION['nbRecettes']++;

                $recetteTrouveManque1=true;
                /*$ingredientManquant=$result[1];*/

            } // fin du if count resultat

            $y++;

        } // fin du foreach ingredientsDeLaRecette

        if($recetteTrouve==false && $recetteTrouveManque1==false) {
            echo "<div class=pas-ing>";
            echo "<img class='img-vide' src='img/icones/recetteVide.png'>";
            echo "<p class=pas-ing__coch>Pas de recette trouvée</p>";
            echo "</div>";
        }

    } // fin du else <=> il y a plus de 4 ing coches

} // fin du isset SESSION

?>
