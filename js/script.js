function afficherCategorie(numero) {
    var i;
    document.getElementById('categorie'+numero).style.display="block";
    for(i=1;i<numero;i++) {
        document.getElementById('categorie'+i).style.display="none";
    }
    for(i=numero+1;i<=5;i++) {
        document.getElementById('categorie'+i).style.display="none";
    }
}

dataQte=[];

function tabIngQte(nbrIngredients) {
    for(i=0;i<nbrIngredients;i++) {
        if(document.getElementById("qteIng"+i)!==null) {
            qte=document.getElementById("qteIng"+i).value*1;
            dataQte.push(qte);
        }
    }
}

function quantiteParPersonne() {
    for (i=0;i<dataQte.length;i++) {
        nbrPersonne=document.getElementById("nbrPersonne").value*1;
        resultat=dataQte[i]*nbrPersonne;
        document.getElementById("afficherQte"+i).innerHTML=resultat;
        document.getElementById("indication"+i).className="indication-displayed";
    }
}

// fonctions admin
// bouton ajouter l'image qui change de couleur si image changee
function notifUpload() {
    document.getElementById('modif__img').className="changeCouleur";
}

function afficherInputLien() {
    if($('#lien__video').is(":hidden")==true) {
        $('#lien__video').slideToggle("fast");
        document.getElementById('video').required=true;
    }
}

function desafficherInputLien() {
    if($('#lien__video').is(":hidden")==false) {
        $('#lien__video').slideToggle("fast");
        document.getElementById('video').value="";
        document.getElementById('video').placeholder="http://www.youtube.fr/watch?...";
        document.getElementById('video').required=false;
    }
}

// permet d'afficher la div qte pour l'ing selectionne
function afficheQte(ingClique) {
    $('#qteAfficheeIng'+ingClique).slideToggle("fast");
}

var nbrEtapesAffichees=1;

function ajouterEtape() {
    document.getElementById('commentaire').style.display="none";
    document.getElementById('nbrEtapes').value=document.getElementById('nbrEtapes').value*1+1;
    document.getElementById('etape'+nbrEtapesAffichees).style.display="block";
    nbrEtapesAffichees++;
    if(document.getElementById("etape"+nbrEtapesAffichees)===null) {
        document.getElementById("bouton__ajouter").style.display="none";
    }
}

function ajouterEtapeModif() {
    nbrEtapesAfficheesModif=(document.getElementById('nbrEtapes').value*1)+1;
    document.getElementById('nbrEtapes').value=document.getElementById('nbrEtapes').value*1+1;
    document.getElementById('etape'+nbrEtapesAfficheesModif).style.display="block";
    nbrEtapesAffichees++;
    if(document.getElementById("etape"+nbrEtapesAfficheesModif)===null) {
        document.getElementById("bouton__ajouter").style.display="none";
    }
}


var supprime=0;

function supprimerEtape(etapeAsupp) {
    if(confirm("Voulez-vous vraiment supprimer l\'étape "+etapeAsupp+" ?")==true) {
        document.getElementById("etape"+etapeAsupp).remove();
        document.getElementById('nbrEtapes').value=document.getElementById('nbrEtapes').value*1-1;
        etapeAsupp++;
        limite=10-supprime;
        for(i=etapeAsupp;i<=limite;i++) {
            let j=i-1;
            document.getElementById("bouton__supp"+i).value=j; // value pour parametre de la fonction
            document.getElementById("etape"+i).setAttribute("id", "etape"+j); // id div
            document.getElementById("nom__etape"+i).innerHTML="Etape "+j; // nom etape affiche
            document.getElementById("nom__etape"+i).setAttribute("id", "nom__etape"+j); // id du nom
            document.getElementById("bouton__supp"+i).setAttribute("id", "bouton__supp"+j); // id du bouton
            document.getElementById("etape"+i+"__contenu").setAttribute("name", "etape"+j); // name PHP
            document.getElementById("etape"+i+"__contenu").setAttribute("id", "etape"+j+"__contenu"); // id JS
        }
        supprime++; //compte le nombre détape(s) supprimee(s) pour pas de bug pour le for
        nbrEtapesAffichees--; // reduit le nombre détape
        if(document.getElementById("etape"+nbrEtapesAffichees)===null) {
            document.getElementById("bouton__ajouter").style.display="none";
        }
    }
}

function blocage() {
    if ((event.keyCode<48 || event.keyCode>57) && event.keyCode!=8)
    {
        event.returnValue = false;
    }
}

// au moins une étape pour ne pas avoir d'erreur dans INSERT de la BDD

function valider() {
    if(nbrEtapesAffichees==1) {
        alert('Votre recette ne compte aucune étape\nAjoutez-en au moins une pour continuer');
        document.getElementById('commentaire').style.display="none";
        document.getElementById('nbrEtapes').value=document.getElementById('nbrEtapes').value*1+1;
        document.getElementById('etape'+nbrEtapesAffichees).style.display="block";
        nbrEtapesAffichees++;
        return false;
    }

    else {
        return true;
    }
}

// permet de trier A-Z ou Z-A

function sort(critere) {
    $("#listeRecettes").load("traitement/Admin_sort.php", {value: critere});
}


//jquery

$(document).ready(function () {

    mySwiper.on('init',function() {
        if(mySwiper.activeIndex==0) {
            $('#page-ingredients').css('font-weight','bold'); //normal de la categorie ingredients swiper
        }
    });

    mySwiper.on('init', function() {
        if(mySwiper.activeIndex==1) {
            $('footer').css("display", "none");
        }
    });

    mySwiper.init();

    mySwiper.on('slideChange', function() {
        if(mySwiper.activeIndex==0) {
            $('footer').fadeIn("fast", function() {
                // Apparition
            });
            //bold et normal categorie
            $('#page-ingredients').css('font-weight','bold'); //normal de la categorie ingredients swiper
            $('#maliste').css('font-weight','300'); //bold de la categorie maliste swiper
            $('#recettes').css('font-weight','300'); //bold de la categorie recette swiper
        }

        if(mySwiper.activeIndex==1) {
            $('footer').fadeOut("fast", function() {
                // Disparition
            });
            //bold et normal categorie
            $('#page-ingredients').css('font-weight','300'); //normal de la categorie ingredients swiper
            $('#maliste').css('font-weight','bold'); //bold de la categorie maliste swiper
            $('#recettes').css('font-weight','300'); //bold de la categorie recette swiper

            $('.ingredient-panier').fadeOut("fast",function(){
                // Disparition
            });
        }

        if(mySwiper.activeIndex==2) {
            //bold et normal categorie
            $('#page-ingredients').css('font-weight','300'); //normal de la categorie ingredients swiper
            $('#maliste').css('font-weight','300'); //bold de la categorie maliste swiper
            $('#recettes').css('font-weight','bold'); //bold de la categorie recette swiper
        }
    });


// message ajout et suppression
    $('.ingredient-panier').delay(1100).fadeOut(400);//disparition de l'ajout en fadeout de 400ms après 1s

    $('.ingredient-panier-supp').delay(1100).fadeOut(400);//disparition de la supp en fadeout de 400ms après 1s


});

