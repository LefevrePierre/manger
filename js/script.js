// ajout en AJAX marche, yes !
function ajouter(id) {
    $.ajax({
        type: "GET",
        url:'index.php',
        data : 'id=' + id + '&action=ajouter',
        success : function () {
            $('#MaListe').load('traitement/contenuListeAjax.php');
            $('#ingredient-panier').fadeIn(400); // pour afficher, obligé de fadeIn
            $('#ingredient-panier').load('traitement/nom.php?idAjoute='+id);
            $('#ingredient-panier').delay(1100).fadeOut(400);//disparition de l'ajout en fadeout de 400ms après 1s
            $('#ing'+id).text('✓');
            $('#ing'+id).css('color','white');
            $('#ing'+id).css('background-color','#76be77');
            $('#ing'+id).css('border','none');
            $('#ing'+id).css('pointer-events','none');
        },
        error : function () {
            $('body').load('index.php?action=error');
        }
    });
}

// suppr en AJAX
function supprimer(id) {
    $.ajax({
        type: "GET",
        url:'index.php',
        data : 'id=' + id + '&action=supprimer',
        success : function () {
            $('#MaListe').load('traitement/contenuListeAjax.php');
            $('#ingredient-panier-supp').fadeIn(400); // pour afficher, obligé de fadeIn
            $('#ingredient-panier-supp').load('traitement/nom.php?idSupp='+id);
            $('#ingredient-panier-supp').delay(1100).fadeOut(400);//disparition de l'ajout en fadeout de 400ms après 1s
            $('#ing'+id).text('+');
            $('#ing'+id).css('color','#787784');
            $('#ing'+id).css('background-color','white');
            $('#ing'+id).css('border','1px solid #787784');
            $('#ing'+id).css('pointer-events','auto');
        },
        error : function () {
            $('body').load('index.php?action=error');
        }
    });
}

// vider panier en AJAX
function viderPanier(nbrIngBDD) {
    $.ajax({
        url:'index.php?action=videPanier',
        success : function () {
            $('#MaListe').load('traitement/contenuListeAjax.php');
            for(i=1;i<nbrIngBDD;i++) {
                $('#ing'+i).text('+');
                $('#ing'+i).css('color','#787784');
                $('#ing'+i).css('background-color','white');
                $('#ing'+i).css('border','1px solid #787784');
                $('#ing'+i).css('pointer-events','auto');
            }
        },
        error : function () {
            $('body').load('index.php?action=error');
        }
    });
}

function afficherCategorie(numero) {
    var i;
    document.getElementById('categorie' + numero).style.display = "block";
    for (i = 1; i < numero; i++) {
        document.getElementById('categorie' + i).style.display = "none";
    }
    for (i = numero + 1; i <= 6; i++) {
        document.getElementById('categorie' + i).style.display = "none";
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

//Etats initiaux :
    $('.nav-manger:nth-child(2) .triangle').css('top','45px');
    $('.nav-manger:nth-child(3) .triangle').css('top','45px');
    $('#page-ingredients').css('font-weight','bold'); //normal de la categorie ingredients swiper
    $('.nav-manger:nth-child(1) .triangle').css('transition','all 500ms');
    $('.nav-manger:nth-child(2) .triangle').css('transition','all 500ms');
    $('.nav-manger:nth-child(3) .triangle').css('transition','all 500ms');


    $(document).ready(function(){
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

});


$(document).ready(function($){
    $( window ).scroll(function() {
        var scy=$(window).scrollTop();
        var visible = $('.ingredients-recette').visible(); // Set the visible status into the span.
        console.log(visible);
        console.log(scy);
        if(scy > 870){
            $('.ingredients-recette').addClass('ingredients-fixed');
        }else if(scy < 654){
            $('.ingredients-recette').removeClass('ingredients-fixed');

        }else {

        }
    });



    //script pour la recherche
    $('#search-input').hide();
    $('*').click(function () {
        if($('.categorie6:visible')){
            $('#search-input').show();
            $('#search-input').focus();
            console.log('socus');
        }else{
            $('#search-input').hide();
        }

    })

    $('#search-input').keyup(function () {
        var recherche = $(this).val();
        var data = 'motcle=' + recherche;

        if(recherche.length>0) {
            $.ajax({
                type : "GET",
                url : "traitement/search.php",
                data : data,
                success: function (server_response){
                    $('.searchResult-div').html(server_response).show();
                }
            });
        }

    });



    //script couleur footer
    $('.footer__icon:nth-child(1)').css('background','#76be77');
    $('.footer__icon:nth-child(1)').find('span').css('color','#ffffff');
    $('.footer__icon').click(function () {
        var celi = $(this)
        $('.footer__icon').not(celi).css('background','white');
        $('.footer__icon').not(celi).find('span').css('color','#b2b2b2');
        $(this).css('background','#76be77');
        $(this).find('span').css('color','#ffffff')

    })


    //modal recette
    $('.nbRecette').mouseenter(function () {
        $('.modal-recette').slideDown();
    })
    $('.nbRecette').mouseleave(function () {
        $('.modal-recette').slideUp();
    })





    //nombre personnes
    let np = 1;

    $('.btn-plus').click(function () {
        //quantité gestion
        $( ".quantite" ).each(function() {
            let recupQt = $(this).val();

            recupQt = recupQt*1 + (recupQt / np);
            $(this).val(recupQt);
            console.log("recupt = "+recupQt);
            console.log("np "+np);
        });

        np++;
        $('.disp-np').text(np);

    })
    $('.btn-moins').click(function () {
        if($('.disp-np').text()!=1) {
            //quantité gestion
            $(".quantite").each(function () {
                let recupQt = $(this).val();
                recupQt = recupQt * 1 - recupQt / np;
                $(this).val(recupQt);
                console.log(recupQt);
            });
            np--;
            $('.disp-np').text(np);
        }else{
            return
        }

    })







//test
    /* $('.footer__icon:nth-child(2)').click(function () {
         var cecat = $(this);
         $('*[id^="categorie"]').not(cecat).css('transform','rotateY(90deg)');
         $('#categorie2').css('transform','rotateY(0deg)');
     })
*/


});
