<?php session_start();
include('config/bd.php');
include('config/head.php');

// pour savoir si co
if(!isset($_SESSION['login'])) {
	header("Location:index.php?action=admin");
}

?>

<div class="container__admin">

	<form action="index.php?action=Admin_trait_NewRecette" method="post" enctype="multipart/form-data">

		<a href="index.php?action=Admin_acceuil"><span class="triangle"></span></a>
		<a href="index.php?action=Admin_acceuil" class="retour">Retour</a>

		<div class="form__content">
			<div class="un">
				<h3>Nouvelle recette</h3>
				
				<hr size=1 width=100% color=#1C1C1C>
				<table>

				<tr><td><label for="titre">Titre</label></td>
				<td><input type="text" placeholder="Titre..." id="titre" name="titre" required></td></tr>
				
				<tr><td><label for="tpsPrep">Préparation</label></td>
				<td><input type="text" placeholder="Temps (en min)" id="tpsPrep" name="tpsPrep" required></td></tr>
				
				<tr><td><label for="tpsCui">Cuisson</label></td>
				<td><input type="text" placeholder="Temps (en min)" id="tpsCui" name="tpsCui" required></td></tr>
				
				<tr><td><label for="diff">Difficulté</label></td>
				<td><SELECT name="diff" id="diff">
					<option>1</option>
					<option>2</option>
					<option>3</option>
				</SELECT></td></tr>
				
				<tr><td><label for="cout">Coût</label></td>
				<td><SELECT name="cout" id="cout">
					<option>1</option>
					<option>2</option>
					<option>3</option>
				</SELECT></td></tr>
				
				<tr><td><label for="ustensile">Ustensile(s)</label></td>
				<td><input type="text" placeholder="Casserole - Poele..." id="ustensile" name="ustensile" required></td></tr>
				
				<tr><td><label for="calorie">Calories</label></td>
				<td><input type="text" placeholder="Calories (en cal)" id="calorie" name="calorie" required></td></tr>
				
				<tr><td><label for="imgBg">Image</label></td>
				<td><input type="file" accept=".png, .jpg, .jpeg" name="imgBackground" id="imgBg"></td></tr>
				
				<tr><td><label for="video">Vidéo (lien)</label></td>
				<td><input type="text" placeholder="http://www.youtube.fr/watch?..." id="video" name="video" required></td></tr>
			</table>
			</div> <!-- fin de div class="un" -->
			
			<div class="deux">
				<h3>Ingrédients</h3>
				<hr size=1 width=100% color=#1C1C1C>
				<table>
				<tr>
				<?php
				echo '<h4> Viandes et poissons </h4>';
				$sql="SELECT * FROM ingredient WHERE type='Viande-Poisson'";
					$q=$pdo->prepare($sql);
				    $q->execute();
				    $ligne=0;
				    while($line=$q->fetch()) {
				    	if($ligne%3==0) {
							echo '</tr>';
							echo '<tr>';
						}
				        echo '<td id="contour'.$line['id'].'">';
					        echo '<div><input type="checkbox" class="check__admin" name="ing[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
					        echo '<label class="nom__ing">'.$line['nom'].'</label></div>';
					        echo '<div id="qteAfficheeIng'.$line['id'].'" style="display:none;" class="divQte">';
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

				echo '<h4> Légumes </h4>';
				echo '<table>';
				echo '<tr>';
				$sql="SELECT * FROM ingredient WHERE type='Légume'";
					$q=$pdo->prepare($sql);
				    $q->execute();
				    $ligne=0;
				     while($line=$q->fetch()) {
				    	if($ligne%3==0) {
							echo '</tr>';
							echo '<tr>';
						}
				        echo '<td id="contour'.$line['id'].'">';
					        echo '<div><input type="checkbox" class="check__admin" name="ing[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
					        echo '<label class="nom__ing">'.$line['nom'].'</label></div>';
					        echo '<div id="qteAfficheeIng'.$line['id'].'" style="display:none;" class="divQte">';
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

				echo '<h4> Féculents </h4>';
				echo '<table>';
				echo '<tr>';
				$sql="SELECT * FROM ingredient WHERE type='Féculent'";
					$q=$pdo->prepare($sql);
				    $q->execute();
				    $ligne=0;
				     while($line=$q->fetch()) {
				    	if($ligne%3==0) {
							echo '</tr>';
							echo '<tr>';
						}
				        echo '<td id="contour'.$line['id'].'">';
					        echo '<div><input type="checkbox" class="check__admin" name="ing[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
					        echo '<label class="nom__ing">'.$line['nom'].'</label></div>';
					        echo '<div id="qteAfficheeIng'.$line['id'].'" style="display:none;" class="divQte">';
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

				echo '<h4> Laitages </h4>';
				echo '<table>';
				echo '<tr>';
				$sql="SELECT * FROM ingredient WHERE type='Laitier'";
					$q=$pdo->prepare($sql);
				    $q->execute();
				    $ligne=0;
				     while($line=$q->fetch()) {
				    	if($ligne%3==0) {
							echo '</tr>';
							echo '<tr>';
						}
				        echo '<td id="contour'.$line['id'].'">';
					        echo '<div><input type="checkbox" class="check__admin" name="ing[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
					        echo '<label class="nom__ing">'.$line['nom'].'</label></div>';
					        echo '<div id="qteAfficheeIng'.$line['id'].'" style="display:none;" class="divQte">';
						        echo '<label for="qteIng">Quantité</label>';
						        echo '<br>';
						        echo '<input type="number" id="qteIng" name="qteIng[]" min="1" max="3000">';
						        echo '<SELECT name="uniteQte[]">';
						        	echo '<option>Unite</option>';
							        echo '<option>g</option>';
							        echo '<option>mL</option>';
							    echo '</SELECT>';
					        echo '</div>';
				        echo '</td>';
				        $ligne++;
				    }
				echo '</tr>';
				echo '</table>';

				echo '<h4> Divers </h4>';
				echo '<table>';
				echo '<tr>';
				$sql="SELECT * FROM ingredient WHERE type='Divers'";
					$q=$pdo->prepare($sql);
				    $q->execute();
				    $ligne=0;
				     while($line=$q->fetch()) {
				    	if($ligne%3==0) {
							echo '</tr>';
							echo '<tr>';
						}
				        echo '<td id="contour'.$line['id'].'">';
					        echo '<div><input type="checkbox" class="check__admin" name="ing[]" value="'.$line['id'].'" onclick="afficheQte('.$line['id'].');">';
					        echo '<label class="nom__ing">'.$line['nom'].'</label></div>';
					        echo '<div id="qteAfficheeIng'.$line['id'].'" style="display:none;" class="divQte">';
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
				?>

			</div> <!-- fin de div class="deux" -->
			<div class="trois">
			<h3>Étapes</h3>
				<hr size=1 width=100% color=#1C1C1C>
				<p id="commentaire">C'est vide pour le moment <br> Ajouter une étape !</p>
				<?php
					for($i=1;$i<=10;$i++) {
						echo '<div class="etp" id="etape'.$i.'" style="display:none; position:relative;">
						<span class="etape__title" id="nom__etape'.$i.'">Etape '.$i.'</span> 
						<button id="bouton__supp'.$i.'" class="supprimer__etape" value="'.$i.'" onclick="supprimerEtape(this.value);">-</button>
						<br>
						<textarea id="etape'.$i.'__contenu" name="etape'.$i.'"></textarea>
					</div>';
				}
				?>
				<input type="button" value="+" onclick="ajouterEtape();" class="bouton__plus" id="bouton__ajouter">
				<input type="hidden" value="" name="nbrEtapes" id="nbrEtapes">

			</div> <!-- fin de div class="trois" -->
		</div> <!-- fin de la div form__content -->

		<input type="submit" value="Ajouter la recette" name="demandeAjout">
		<a href="index.php?action=Admin_acceuil" class="annuler">Annuler</a>
		<br>

	</form>

</div>


