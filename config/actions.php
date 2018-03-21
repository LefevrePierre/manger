<?php
// Voici la liste des actions possibles avec la page à charger associée

$listeDesActions = array(
	"accueil"=>"vues/accueil.php",
	"listeIngredients"=>"vues/ingredients.php",
	"listeCoches"=>"vues/liste.php",
    "ajouter"=>"traitement/ajouter.php",
    "supprimerDuPanier"=>"traitement/supprimer.php",
    "selectionRecette"=>"vues/selectionRecette.php",
    "afficherRecette"=>"vues/afficherRecette.php",
    // admin
    "admin"=>"admin/Admin_form_connexion.php",
    "Admin_trait_connexion"=>"traitement/Admin_trait_connexion.php",
    "Admin_trait_deconnexion"=>"traitement/Admin_trait_deconnexion.php",
    //page acceuil admin co
    "Admin_acceuil"=>"admin/index.php",
    // new recette
    "Admin_view_NewRecette"=>"admin/Admin_view_NewRecette.php",
    "Admin_trait_NewRecette"=>"traitement/Admin_trait_NewRecette.php",
    // recette existante
    "Admin_view_Maj_Recette"=>"admin/Admin_view_Maj_Recette.php",
    "Admin_trait__Maj_Recette"=>"traitement/Admin_trait__Maj_Recette.php",
    // supprimer recette
    "Admin_supprimerRecette"=>"traitement/Admin_supprimerRecette.php",
    // new ing
    "Admin_form_NewIngredient"=>"admin/Admin_form_NewIngredient.php",
    "Admin_trait_NewIngredient"=>"traitement/Admin_trait_NewIngredient.php",
    // 404.php
    "error"=>"vues/404.php"
);