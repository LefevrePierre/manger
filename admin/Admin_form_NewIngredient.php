<?php session_start();

include('config/head.php');
	
// pour savoir si co
if(!isset($_SESSION['login'])) {
	header("Location:index.php?action=admin");
}

?>

<div class="container__admin">
<form method="post" action="index.php?action=Admin_trait_NewIngredient" enctype="multipart/form-data">
	<a href="index.php?action=Admin_acceuil"><span class="triangle"></span></a>
	<a href="index.php?action=Admin_acceuil" class="retour">Retour</a>
	<h3>Nouvel ingrédient</h3>
	<hr size=1 width=100% color=#1C1C1C>
	<table><tr>
	<td><label for="nom">Nom</label></td>
	<td><input type="text" name="newIngredient" id="nom"></td></tr>
	<tr><td><label for="type">Type d'ingrédient</label></td>
	<td><SELECT name="type" class="liste__type" id="type">
		<option>Viande-Poisson</option>
		<option>Légume</option>
		<option>Féculent</option>
		<option>Laitier</option>
		<option>Divers</option>
		?>
	</SELECT></td></tr>
	<tr>
	<td><label for="image__list">Image (liste)</label></td>
	<td><input type="file" name="imgListe" id="image__list"></td></tr>
	<tr>
	<td><label for="image__recette">Image (recette)</label></td>
	<td><input type="file" name="imgRecette" id="image__recette"></td></tr>
</table>
	<input type="submit" name="demandeAjout" class="submit__ing">
	<a href="index.php?action=Admin_acceuil" class="annuler annuler__ing">Annuler</a>
</form>
</div>