<?php session_start();

if(isset($_POST['login']) && isset($_POST['password'])) {

	$sql = "SELECT * FROM admin WHERE login=? AND password=PASSWORD(?)";
	$q=$pdo->prepare($sql);
	$q->execute(array($_POST['login'],$_POST['password']));

	$line = $q->fetch();

	if($line == false){
		header("Location:index.php?action=admin");
	}

	else {
		$_SESSION['login']=$line['login'];
		header("Location:index.php?action=Admin_acceuil");
	}
}

?>