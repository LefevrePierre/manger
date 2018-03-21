<?php session_start();
include('config/bd.php');
include('config/head.php');

// pour savoir si co
if(!isset($_SESSION['login'])) {
	header("Location:index.php?action=admin");
}

if(isset($_GET['id'])==false) {
	header("Location:index.php?action=error");
}

?>

<div class="container__admin">

	<form action="index.php?action=Admin_trait__Maj_Recette" method="post" enctype="multipart/form-data">

		<a href="index.php?action=Admin_acceuil"><span class="triangle"></span></a>
		<a href="index.php?action=Admin_acceuil" class="retour">Retour</a>

			<div class="form__content">

			<?php 
				$sql = 'SELECT * FROM recette WHERE id=?';
		        $q=$pdo->prepare($sql);
		        $q->execute(array($_GET['id']));
			
			$i=1;
			if($line=$q->fetch()) {

		// pour récupérer l'id de la recette choisie, pas possible de le passer en GET avec un a href à cause du submit donc en POST en hidden
		echo '<input type="hidden" name="numeroRecette" value='.$line['id'].'>';

		echo '<div class="un">';
			echo '<h3 class="admin__title">Modifier la recette</h3>';
			echo '<hr size=1 width=100% color=#1C1C1C>';

			echo '<table>';

			echo '<tr><td><label for=titre>Titre</label></td>';
			echo '<td><input type="text" id="titre" name="titre" value="'.$line['titre'].'" required></td></tr>';

			echo '<tr><td><label for="tpsPrep">Préparation</label></td>';
			echo '<td><input type="text" id="tpsPrep" name="tpsPrep" value="'.$line['tpsPrep'].'" required></td></tr>';

			echo '<tr><td><label for="tpsCui">Cuisson</label></td>';
			echo '<td><input type="text" id="tpsCui" name="tpsCui" value="'.$line['tpsCui'].'" required></td></tr>';

			echo '<tr><td><label for="diff">Difficulté</label></td>';
			echo '<td><SELECT name="diff" id="diff">';
					for($i=1;$i<=3;$i++) {
						if ($i==$line['diff']) {
							echo '<option selected="selected">'.$i.'</option>';
						}
						else {
							echo '<option>'.$i.'</option>';
						}	
					}
			echo '</SELECT></td></tr>';

			echo '<tr><td><label for="cout">Coût</label></td>';
			echo '<td><SELECT name="cout" id="cout">';
					for($i=1;$i<=3;$i++) {
						if ($i==$line['cout']) {
							echo '<option selected="selected">'.$i.'</option>';
						}
						else {
							echo '<option>'.$i.'</option>';
						} 
					}
			echo '</SELECT></td></tr>';

			echo '<tr><td><label for="ustensile">Ustensile(s)</label></td>';
			echo '<td><input type="text" id="ustensile" name="ustensile" value="'.$line['ustensile'].'" required></td></tr>';

			echo '<tr><td><label for="calorie">Calories</label></td>';
			echo '<td><input type="text" id="calorie" name="calorie" value="'.$line['calorie'].'" required></td></tr>';

			if(!empty($line['imgBg'])) {
				echo '<tr><td>Image</td>';
				echo '<td><img src="img/recette/'.$line['imgBg'].'" class="apercu__image">';
				echo '<label for="imgBgbutton" class="modif" id="modif__img">Modifier</label>';
				echo '<input type="file" accept=".png, .jpg, .jpeg" name="imgBackground" id="imgBg" class="input__cache" onclick="notifUpload();"></td>';
			}
			else {
				echo '<tr><td>Image</td>';
				echo '<td><input id="imgBgbutton" type="file" name="imgBackground" accept=".png, .jpg, .jpeg"></td></tr>';
			}
			echo '<tr><td><label for="video">Vidéo (lien)</label></td>';
			echo '<td><input type="text" id="video" name="video" value="'.$line['video'].'" required></td></tr>';

			echo '</table>';

			// tab d'ing presents
			$ingPresents=array();

			// tab de tous les ingg pour array_diff, afficher ceux pas presents
			$tousIng=array();

			//liste de tous les ingrédients déjà dans la recette choisie

			echo '<div class="actuels">';
				echo '<h3>Ingrédients actuels</h3>';
				
				echo '<table>';
				echo '<tr>';

				$sql = 'SELECT ingredient.id,nom,qteIng,uniteQte FROM ingredient JOIN estDans ON ingredient.id=idIngredient JOIN recette ON recette.id=idRecette WHERE ingredient.id IN (SELECT idIngredient FROM estDans WHERE recette.id=?) ORDER BY type';
			    $q=$pdo->prepare($sql);
			    $q->execute(array($_GET['id']));

			    $ligne=0;
			    while($line=$q->fetch()) {
			    	if($ligne%3==0) {
						echo '</tr>';
						echo '<tr>';
					}
					echo '<td id="contour'.$line['id'].'">';
					        echo '<div><input type="checkbox" class="check__admin" name="already__checked[]" checked value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
					        echo '<label class="nom__ing">'.$line['nom'].'</label></div>';
					        echo '<div id="qteAfficheeIng'.$line['id'].'" style="display:block;" class="divQte">';
						        echo '<label for="qteIng">Quantité</label>';
						        echo '<br>';
						        echo '<input type="number" id="qteIng" name="qteIngDejaDedans[]" value="'.$line['qteIng'].'" min="1" max="3000">';
						        echo '<SELECT name="uniteQteDejaDedans[]">';
						        if($line['uniteQte']=="g") {
						        	echo '<option selected="selected">'.$line['uniteQte'].'</option>'; 
						        	echo '<option>mL</option>';
							        echo '<option>cuillère(s)</option>';
							        echo '<option>tranche(s)</option>';
						        }
						        else if ($line['uniteQte']=="mL") {
						        	echo '<option>g</option>';
						        	echo '<option selected="selected">'.$line['uniteQte'].'</option>'; 
							        echo '<option>cuillère(s)</option>';
							        echo '<option>tranche(s)</option>';
						        }
						        else if($line['uniteQte']=="cuillère(s)") {
						        	echo '<option>g</option>';
						        	echo '<option>mL</option>';
						        	echo '<option selected="selected">'.$line['uniteQte'].'</option>';
						        	echo '<option>tranche(s)</option>';
						        }
						        else {
							        echo '<option>g</option>';
							        echo '<option>mL</option>';
							        echo '<option>cuillère(s)</option>';
							        echo '<option selected="selected">'.$line['uniteQte'].'</option>'; 
						        }   	
							    echo '</SELECT>';
					        echo '</div>';
				        echo '</td>';
						array_push($ingPresents, $line['nom']);
						$ligne++;
				}

				echo '</tr>';
				echo '</table>';

			echo '</div>'; // fin <div class="actuels">
		echo '</div>'; // fin de <div class="un">

			// 1. on remplit un tab ViandesPoissonsnom à partir des noms des viandes et poissons de la BDD
		            $ViandesPoissonsnom=array();
		            $sql="SELECT * FROM ingredient WHERE type='Viande-Poisson' ORDER BY nom";
		            $q=$pdo->prepare($sql);
		            $q->execute();
		            while($line=$q->fetch()) {
		                array_push($ViandesPoissonsnom, $line['nom']);
		            }

		            // on fait de meme pour les autres types d'ing de la BDD
		            // légumes
		            $Legumesnom=array();
		            $sql="SELECT * FROM ingredient WHERE type='Légume' ORDER BY nom";
		            $q=$pdo->prepare($sql);
		            $q->execute();
		            while($line=$q->fetch()) {
		                array_push($Legumesnom, $line['nom']);
		            }

		            //féculents
		            $Feculentnom=array();
		            $sql="SELECT * FROM ingredient WHERE type='Féculent' ORDER BY nom";
		            $q=$pdo->prepare($sql);
		            $q->execute();
		            while($line=$q->fetch()) {
		                array_push($Feculentnom, $line['nom']);
		            }

		            //laitage
		            $Laitiernom=array();
		            $sql="SELECT * FROM ingredient WHERE type='Laitier' ORDER BY nom";
		            $q=$pdo->prepare($sql);
		            $q->execute();
		            while($line=$q->fetch()) {
		                array_push($Laitiernom, $line['nom']);
		            }

		            //divers
		            $Diversnom=array();
		            $sql="SELECT * FROM ingredient WHERE type='Divers' ORDER BY nom";
		            $q=$pdo->prepare($sql);
		            $q->execute();
		            while($line=$q->fetch()) {
		                array_push($Diversnom, $line['nom']);
		            }

			// autres viandes pas presents
		echo '<div class="deux">';
			echo '<h3>Autres ingrédients</h3>';
			echo '<hr size=1 width=100% color=#1C1C1C>';
			echo '<h4>Viandes et poissons</h4>';
			echo '<table>';
			echo '<tr>';

			$AutresViandesPoissons=array_diff($ViandesPoissonsnom, $ingPresents);
			$ligne=0;
			foreach ($AutresViandesPoissons as $key => $value) {
				if($ligne%3==0) {
					echo '</tr>';
					echo '<tr>';
				}
				$sql="SELECT * FROM ingredient WHERE nom=?";          
		            $q=$pdo->prepare($sql);
		            $q->execute(array($value));
				while($line=$q->fetch()) {
					echo '<td id="contour'.$line['id'].'">';
					  	echo '<div><input type="checkbox" class="check__admin" name="others[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
					// sert pour la table estDans
					$id=$line['id'];
				}
				echo '<label class="nom__ing">'.$value.'</label></div>';
					        echo '<div id="qteAfficheeIng'.$id.'" style="display:none;" class="divQte">';
						        echo '<label for="qteIng">Quantité</label>';
						        echo '<br>';
						        echo '<input type="number" id="qteIng" name="qteIng[]" min="1" max="3000">';
						        echo '<SELECT name="uniteQte[]">';
						        	echo '<option>Unite</option>';
							        echo '<option>g</option>';
							        echo '<option>tranche(s)</option>';
							    echo '</SELECT>';
					        echo '</div>';
				    echo '</td>';
				    $ligne++;	        
			}

			echo '</tr>';
			echo '</table>';

			echo '<br>';

			// autres legumes pas presents
			echo '<h4>Légumes</h4>';
			echo '<table>';
			echo '<tr>';

			$AutresLegumes=array_diff($Legumesnom, $ingPresents);
			$ligne=0;
			foreach ($AutresLegumes as $key => $value) {
				if($ligne%3==0) {
					echo '</tr>';
					echo '<tr>';
				}
				$sql="SELECT * FROM ingredient WHERE nom=?";          
		            $q=$pdo->prepare($sql);
		            $q->execute(array($value));
				while($line=$q->fetch()) {
					echo '<td id="contour'.$line['id'].'">';
					  	echo '<div><input type="checkbox" class="check__admin" name="others[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
					// sert pour la table estDans
					$id=$line['id'];
				}
				echo '<label class="nom__ing">'.$value.'</label></div>';
					        echo '<div id="qteAfficheeIng'.$id.'" style="display:none;" class="divQte">';
						        echo '<label for="qteIng">Quantité</label>';
						        echo '<br>';
						        echo '<input type="number" id="qteIng" name="qteIng[]" min="1" max="3000">';
						        echo '<SELECT name="uniteQte[]">';
						        	echo '<option>Unite</option>';
							        echo '<option>g</option>';
							    echo '</SELECT>';
					        echo '</div>';
				    echo '</td>';
				    $ligne++;	        
			}

			echo '</tr>';
			echo '</table>';
			
			echo '<br>';

			// autres féculents pas presents

			echo '<h4>Féculents</h4>';
			echo '<table>';
			echo '<tr>';

			$ligne=0;
			$AutresFeculents=array_diff($Feculentnom, $ingPresents);

			foreach ($AutresFeculents as $key => $value) {
				if($ligne%3==0) {
					echo '</tr>';
					echo '<tr>';
				}
				$sql="SELECT * FROM ingredient WHERE nom=?";          
		            $q=$pdo->prepare($sql);
		            $q->execute(array($value));
				while($line=$q->fetch()) {
					echo '<td id="contour'.$line['id'].'">';
					  	echo '<div><input type="checkbox" class="check__admin" name="others[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
					// sert pour la table estDans
					$id=$line['id'];
				}
				echo '<label class="nom__ing">'.$value.'</label></div>';
					        echo '<div id="qteAfficheeIng'.$id.'" style="display:none;" class="divQte">';
						        echo '<label for="qteIng">Quantité</label>';
						        echo '<br>';
						        echo '<input type="number" id="qteIng" name="qteIng[]" min="1" max="3000">';
						        echo '<SELECT name="uniteQte[]">';
						        	echo '<option>Unite</option>';
							        echo '<option>g</option>';
							    echo '</SELECT>';
					        echo '</div>';
				    echo '</td>';
				    $ligne++;	        
			}

			echo '</tr>';
			echo '</table>';
			
			echo '<br>';

			// autres laitages pas presents
			echo '<h4>Laitages</h4>';
			echo '<table>';
			echo '<tr>';

			$ligne=0;
			$AutresLaitier=array_diff($Laitiernom, $ingPresents);

			foreach ($AutresLaitier as $key => $value) {
				if($ligne%3==0) {
					echo '</tr>';
					echo '<tr>';
				}
				$sql="SELECT * FROM ingredient WHERE nom=?";          
		            $q=$pdo->prepare($sql);
		            $q->execute(array($value));
				while($line=$q->fetch()) {
					echo '<td id="contour'.$line['id'].'">';
					  	echo '<div><input type="checkbox" class="check__admin" name="others[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
					// sert pour la table estDans
					$id=$line['id'];
				}
				echo '<label class="nom__ing">'.$value.'</label></div>';
					        echo '<div id="qteAfficheeIng'.$id.'" style="display:none;" class="divQte">';
						        echo '<label for="qteIng">Quantité</label>';
						        echo '<br>';
						        echo '<input type="number" id="qteIng" name="qteIng[]" min="1" max="3000">';
						        echo '<SELECT name="uniteQte[]">';
						        	echo '<option>Unite</option>';
							        echo '<option>g</option>';
							        echo '<option>mL</option>';
							        echo '<option>cuillère(s)</option>';
							    echo '</SELECT>';
					        echo '</div>';
				    echo '</td>';
				    $ligne++;	        
			}

			echo '</tr>';
			echo '</table>';

			echo '<br>';

			// autres divers pas presents
			echo '<h4>Divers</h4>';
			echo '<table>';
			echo '<tr>';

			$ligne=0;
			$AutresDivers=array_diff($Diversnom, $ingPresents);

			foreach ($AutresDivers as $key => $value) {
				if($ligne%3==0) {
					echo '</tr>';
					echo '<tr>';
				}
				$sql="SELECT * FROM ingredient WHERE nom=?";          
		            $q=$pdo->prepare($sql);
		            $q->execute(array($value));
				while($line=$q->fetch()) {
					echo '<td id="contour'.$line['id'].'">';
					  	echo '<div><input type="checkbox" class="check__admin" name="others[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
					// sert pour la table estDans
					$id=$line['id'];
				}
				echo '<label class="nom__ing">'.$value.'</label></div>';
					        echo '<div id="qteAfficheeIng'.$id.'" style="display:none;" class="divQte">';
						        echo '<label for="qteIng">Quantité</label>';
						        echo '<br>';
						        echo '<input type="number" id="qteIng" name="qteIng[]" min="1" max="3000">';
						        echo '<SELECT name="uniteQte[]">';
						        	echo '<option>Unite</option>';
							        echo '<option>g</option>';
							        echo '<option>mL</option>';
							        echo '<option>cuillère(s)</option>';
							        echo '<option>tranche(s)</option>';
							    echo '</SELECT>';
					        echo '</div>';
				    echo '</td>';
				    $ligne++;	        
			}

			echo '</tr>';
			echo '</table>';
		echo '</div>'; // fin de <div class="deux">

			// liste des étapes, on affiche toutes celles qui ne sont pas vides dans la BDD
			$i=1;
			$sql2 = 'SELECT * FROM recette WHERE id=?';
		        $q2=$pdo->prepare($sql2);
		        $q2->execute(array($_GET['id']));
		        $line2=$q2->fetch();
		echo '<div class="trois">';
		    echo '<h3>Étapes</h3>';
		    echo '<hr size=1 width=100% color=#1C1C1C>';
			while(!empty($line2['etape'.$i]) AND $i<10) {
				echo '<div class="etp" id="etape'.$i.'" style="display:block; position:relative;">';
				echo '<span class="etape__title">Etape '.$i.'</span>';
				echo '<textarea style=\'display:block;\' id=\'etape'.$i.'\' name=\'etape'.$i.'\'>'.$line2['etape'.$i].'</textarea>';
				echo '<button id="bouton__supp'.$i.'" class="supprimer__etape" value="'.$i.'" onclick="supprimerEtape(this.value);">-</button>';
				$i++;
				echo '</div>';
			}

			// affichage en display none des autres pour pouvoir les display block. On commence à $i, enfin $i+1 comme on sort de la boucle while
			for($j=$i;$j<=10;$j++) {
						echo '<div class="etp" id="etape'.$j.'" style="display:none; position:relative;">
						<span class="etape__title" id="nom__etape'.$j.'">Etape '.$j.'</span> 
						<button id="bouton__supp'.$j.'" class="supprimer__etape" value="'.$j.'" onclick="supprimerEtape(this.value);">-</button>
						<br>
						<textarea id="etape'.$j.'__contenu" name="etape'.$j.'"></textarea>
					</div>';
			}

			$i--; // pour pas avoir $i+1 en sortie de boucle
			echo '<input type="hidden" value="'.$i.'" name="nbrEtapes" id="nbrEtapes">';

			// bouton d'ajout d'etapes comme pour creation
			echo '<input type="button" onclick="ajouterEtapeModif();" value="+" id="bouton__ajouter" class="bouton__plus">';
	

		echo '</div>'; // fin de <div class="trois">
	echo '</div>'; // fin de <div class="form__content">

		echo '<input type="submit" value="Modifier la recette" name="demandeModif">';
		echo '<a href="index.php?action=Admin_acceuil" class="annuler">Annuler</a>';
			} // fin du if ligne 26

		?>

	</form>

</div>




