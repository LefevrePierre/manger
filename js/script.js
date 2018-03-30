
$(document).pjax('[data-pjax] a, a[data-pjax]', '#pjax-container');
$(document).pjax('[data-pjax-toggle] a, a[data-pjax-toggle]', '#pjax-container',{push:false});

$(document).on('submit', 'form[data-pjax]', function(event) {
    $.pjax.submit(event, '#pjax-container')
});


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

// bouton ajouter l'image qui change de couleur si image changee
function notifUpload() {
	document.getElementById('modif__img').className="changeCouleur";
}

// permet d'afficher la div qte pour l'ing selectionne
function afficheQte(ingClique) {
	if (document.getElementById('qteAfficheeIng'+ingClique).style.display=="block") {
		document.getElementById('qteAfficheeIng'+ingClique).style.display="none";
		document.getElementById('contour'+ingClique).style.border="none";
	}
	else {
		document.getElementById('qteAfficheeIng'+ingClique).style.display="block";
		document.getElementById('contour'+ingClique).style.border="0.5px solid #e2e0e0";
	}		
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

//Etats initiales :
    $('.nav-manger:nth-child(2) .triangle').css('top','45px');
    $('.nav-manger:nth-child(3) .triangle').css('top','45px');
    $('#page-ingredients').css('font-weight','bold'); //normal de la categorie ingredients swiper
    $('.nav-manger:nth-child(1) .triangle').css('transition','all 500ms');
    $('.nav-manger:nth-child(2) .triangle').css('transition','all 500ms');
    $('.nav-manger:nth-child(3) .triangle').css('transition','all 500ms');


    mySwiper.on('slideChange', function() {
		if(mySwiper.activeIndex==0) {
			$('footer').fadeIn("fast", function() {
   				 // Apparition
  			});
  			//bold et normal categorie
  			$('#page-ingredients').css('font-weight','bold'); //normal de la categorie ingredients swiper
 			$('#maliste').css('font-weight','300'); //bold de la categorie maliste swiper
 			$('#recettes').css('font-weight','300'); //bold de la categorie recette swiper

            $('.nav-manger:nth-child(1) .triangle').css('top','25px');
		    $('.nav-manger:nth-child(2) .triangle').css('top','45px');
		    $('.nav-manger:nth-child(3) .triangle').css('top','45px');
		}

		if(mySwiper.activeIndex==1) {
			$('footer').fadeOut("fast", function() {
    			// Disparition
 			});
 			//bold et normal categorie
 			$('#page-ingredients').css('font-weight','300'); //normal de la categorie ingredients swiper
 			$('#maliste').css('font-weight','bold'); //bold de la categorie maliste swiper
 			$('#recettes').css('font-weight','300'); //bold de la categorie recette swiper

            $('.nav-manger:nth-child(2) .triangle').css('top','25px');
            $('.nav-manger:nth-child(1) .triangle').css('top','45px');
            $('.nav-manger:nth-child(3) .triangle').css('top','45px');


 			$('.ingredient-panier').fadeOut("fast",function(){
 				// Disparition
 			});
		}
		
		if(mySwiper.activeIndex==2) {
			//bold et normal categorie
  			$('#page-ingredients').css('font-weight','300'); //normal de la categorie ingredients swiper
 			$('#maliste').css('font-weight','300'); //bold de la categorie maliste swiper
 			$('#recettes').css('font-weight','bold'); //bold de la categorie recette swiper

            $('.nav-manger:nth-child(3) .triangle').css('top','25px');
            $('.nav-manger:nth-child(2) .triangle').css('top','45px');
            $('.nav-manger:nth-child(1) .triangle').css('top','45px');
		}
	});


// message ajout et suppression
$('.ingredient-panier').delay(1100).fadeOut(400);//disparition de l'ajout en fadeout de 400ms après 1s

$('.ingredient-panier-supp').delay(1100).fadeOut(400);//disparition de la supp en fadeout de 400ms après 1s




});


$(document).ready(function($){
    $( window ).scroll(function() {
//etape
        var scy=$(window).scrollTop();
        var visible = $('.ingredients-recette').visible(); // Set the visible status into the span.
        console.log(visible);
        console.log(scy);
        if(scy > 800){
            $('.ingredients-recette').addClass('ingredients-fixed');
        }else if(scy < 654){
            $('.ingredients-recette').removeClass('ingredients-fixed');

        }else {

        }
    });

});