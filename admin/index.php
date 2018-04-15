<?php session_start();

// pour savoir si co

if(isset($_SESSION['login'])==false) {
    header("Location:index.php?action=admin");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Qu'est ce qu'on mange | Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <link href="style/admin.css" rel="stylesheet">
    <script src="js/script.js"></script>
</head>
<body>
<div class="container admin">
    <a href="index.php?action=Admin_trait_deconnexion" class="btn btn-success btn-md annuler" id="deco">Déconnexion</a>
    <div class="row">
        <br>
        <a href="index.php?action=Admin_view_NewRecette" class="btn btn-success btn-md"> + Nouvelle recette</a>
        <a href="index.php?action=Admin_form_NewIngredient" class="btn btn-success btn-md"> + Nouvel ingrédient</a>

        <?php
        // notif piur nouvel ing ajoute
        if(isset($_GET['new'])) {
            echo '<span class="notif__new__ing btn btn-md" id="notif">Vous avez ajouté : '.$_GET['new'].' !</span>';
        }
        ?>
        <br><h3>Liste des recettes</h3><br>
        <div class="trier">
            <span>Trier par</span>
            <SELECT id="tri" onchange="sort(this.value);">
                <option>A-Z</option>
                <option>Z-A</option>
                <option>Les + récentes</option>
                <option>Les - récentes</option>
            </SELECT>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Titre</th>
                <th>Préparation (en min)</th>
                <th>Cuisson (en min)</th>
                <th>Ingrédients</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="listeRecettes">
            <?php
            $sql1 = 'SELECT * FROM recette ORDER BY titre';
            $q1=$pdo->prepare($sql1);
            $q1->execute();
            while($lineInfo = $q1->fetch()) {
                echo '<tr>';
                echo '<td>'. $lineInfo['titre'] . '</td>';
                echo '<td>'. $lineInfo['tpsPrep'] . '</td>';
                echo '<td>'. $lineInfo['tpsCui'] . '</td>';
                echo '<td>';
                // les ingredients de la ieme recette
                $sql2= 'SELECT * FROM ingredient JOIN estDans on ingredient.id=idIngredient JOIN recette ON recette.id=idRecette WHERE recette.id=:numRecette';
                $q2=$pdo->prepare($sql2);
                $q2->execute(array(
                    ':numRecette'=>$lineInfo['id']
                ));
                while($lineIng = $q2->fetch()) {
                    echo '<span class="nom__ing__index">'.$lineIng['nom'].'<span><br>';
                }
                echo '</td>';
                echo '<td width=300>';
                echo '<a class="btn btn-primary" href="index.php?id='.$lineInfo['id'].'&action=Admin_view_Maj_Recette"><span class="glyphicon glyphicon-pencil"></span> Voir ou Modifier</a>';
                echo ' ';
                echo '<a class="btn btn-danger" onclick="confirmSupp();"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                echo '</td>';
                echo '</tr>';
                echo '<script type="text/javascript">
                                function confirmSupp() {
                                    if(confirm(\'Voulez-vous supprimer cette recette ?\')) {
                                        document.location.href="index.php?id='.$lineInfo['id'].'&action=Admin_supprimerRecette";
                                    }
                            }
                            </script>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('#notif').delay(1500).fadeOut(400);//disparition de la notif en fadeout de 400ms après 2s

    });
</script>
</body>

</html>
