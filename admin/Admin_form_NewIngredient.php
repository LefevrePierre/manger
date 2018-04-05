<?php session_start();

include('config/head.php');

// pour savoir si co
if(!isset($_SESSION['login'])) {
    header("Location:index.php?action=admin");
}

?>

<div class="container__admin">
    <form method="post" action="index.php?action=Admin_trait_NewIngredient" enctype="multipart/form-data">
        <a href="index.php?action=Admin_accueil"><span class="triangle-admin"></span></a>
        <a href="index.php?action=Admin_accueil" class="retour">Retour</a>
        <h4>Nouvel ingrédient</h4>
        <hr size=1 width=100% color=#1C1C1C>
        <table class="ing"><tr>
                <td><label for="nom">Nom</label></td>
                <td><input type="text" name="newIngredient" id="nom" required></td></tr>
            <tr><td><label for="type">Type d'ingrédient</label></td>
                <td><SELECT name="type" class="liste__type" id="type">
                        <option>Viande-Poisson</option>
                        <option>Légume</option>
                        <option>Féculent</option>
                        <option>Laitier</option>
                        <option>Divers</option>
                    </SELECT></td></tr>
            <tr>
                <td><label for="image__list">Image</label></td>
                <td><input type="file" name="imgListe" id="image__list" required></td>
            </tr>
        </table>
        <input type="submit" name="demandeAjout" class="submit__ing">
        <a href="index.php?action=Admin_accueil" class="annuler annuler__ing">Annuler</a>
    </form>
</div>