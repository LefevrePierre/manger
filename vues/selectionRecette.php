<?php

include('config/head.php');

//message si pas assez d'ingrédients
if(isset($_SESSION['ing_checked'])) {
    $nbrCoches=COUNT($_SESSION['ing_checked']);
    if($nbrCoches<4) {
        echo "<div class=pas-ing>";
        echo "<img class='img-vide' src='img/icones/recetteVide.png'>";
        echo "<p class=pas-ing__coch>Pas de recette trouvée</p>";
        echo "</div>";
    }
    else {
        //remplissage des tableaux de recettes et ingredients de cette recette
        $recetteTab=array();
        $recetteTabImg=array();
        $ingredientsDeLaRecette=array($recetteTab);

        $sql1="SELECT DISTINCT titre, imgBg FROM recette";
        $sql2="SELECT idIngredient FROM estDans JOIN recette ON recette.id=idRecette WHERE idRecette=? GROUP BY idIngredient";

        $q1 = $pdo->prepare($sql1);

        $numRecette=1;
        $a=1;

        $q1->execute();

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

        echo "<div class='selectionRecette-conteneur'>";
        // TOUS LES INGREDIENTS ET PLUS FONCTIONNE
        echo "<h2 class='selectionRecette-titre'>Recettes trouvées</h2>";
        $x=0;
        $recetteTrouve=false;

        foreach($ingredientsDeLaRecette as $niemeIng => $idIng) {
            $result= array_diff($ingredientsDeLaRecette[$niemeIng], $_SESSION['ing_checked']); 
            /* var_dump($result)*/;
            /*echo "niemeIng = ".$niemeIng."<br>";*/
            if($result==array() && $x>0){
                   /* echo "<h5>".$recetteTab[$niemeIng]."</h5>";

                    //div fictive pour intégrer
                    echo "<div class='imgRecette'></div>";
                    echo "<div class='titreRecette'>
                            
                        </div>";*/


                    echo "<div class='selectionRecette-div'>
                                <div class='selectionRecette-desc'>
                                    <h5>".$recetteTab[$niemeIng]."</h5>
                                    <a href=index.php?id=".$niemeIng."&action=afficherRecette><img src='img/icones/iconfleche.png' alt=''></a>
                                </div>
                          </div>";


                    //il faut mettre dans ce echo une div avec un bgimg
                    //echo "<img src='img/recette/".$recetteTabImg[$niemeIng]."'>";


                    $recetteTrouve=true;
/*                    echo "<a href=index.php?id=".$niemeIng."&action=afficherRecette><img src='img/icones/iconfleche.png' alt=''></a>";*/
                }
            $x++;
        }

        if($recetteTrouve==false){
            echo "";
        }


        echo "<h2 class='selectionRecette-titre'>Il vous manque 1 ingrédient</h2>";
            
        $y=0;
        $recetteTrouveManque1=false;
        $ingredientManquant="";
        $nomIngredientManquant="";

        foreach($ingredientsDeLaRecette as $niemeIng => $idIng) {
            $result= array_diff($ingredientsDeLaRecette[$niemeIng], $_SESSION['ing_checked']); 
           /* var_dump($result)*/;
            /*echo "niemeIng = ".$niemeIng."<br>";*/
            if(count($result)==1 && $y>0){ 
                    //var_dump($result);
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



                echo "<div class='selectionRecette-div'>
                                <div class='manque'>Ingrédient manquant :<br> ".$nomIngredientManquant."</div>
                                <div class='selectionRecette-desc'>
                                    <h5>".$recetteTab[$niemeIng]."</h5>
                                    <a href=index.php?id=".$niemeIng."&action=afficherRecette><img src='img/icones/iconfleche.png' alt=''></a>
                                </div>
                          </div>";


                $recetteTrouveManque1=true;
                /*$ingredientManquant=$result[1];*/

            }
            $y++;
        }

        if($recetteTrouveManque1==false){
            echo "Pas de recette trouvée debug !";
        }
        echo "</div>";

    }
}

?>
    </div>
    <!-- Fin swiper wrapper -->
</div>