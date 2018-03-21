<!DOCTYPE html>
<html>
<head>
    <title>Qu'est ce qu'on mange | Connexion </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <link href="style/style.css" rel="stylesheet">
</head>
<body>
    <div class="form_connexion">
    	<form action="index.php?action=Admin_trait_connexion" method="post">
            <h3>Qu'est ce qu'on mange</h3>
            <hr size=1 width=100% color=#1C1C1C>
            <h4>Administration</h4>
            <br>
    		<label for="login">Identifiant</label>
            <br>
    		<input type="text" name="login" id="login" class="input_co" autofocus>
            <br>
            <br>
    		<label for="password">Mot de passe</label>
            <br>
    		<input type="password" name="password" id="password" class="input_co">
            <input type="submit" value="Se connecter" id="seconnecter">
    	</form>
    </div>

</body>