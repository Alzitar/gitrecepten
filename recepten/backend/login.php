<?php

require_once("connection.php");
global $conn;

if (isset($_POST['submit'])) {


	//	Variablen voor inloggen
	$email = $_POST['email'];
	$wachtwoord = $_POST['wachtwoord'];

	$query = $conn->prepare("SELECT wachtwoord FROM gebruikers WHERE email = :email");
	$query->execute(array(
		':email' => $email,
	));
	$databaseWachtwoord = $query->fetchColumn();
	$goedWachtwoord = password_verify($wachtwoord, $databaseWachtwoord);

	if (!$goedWachtwoord) {
				header("Location: ?page=login&bericht=combinatieww");
		exit();
	} else {
		$query = $conn->prepare("SELECT email FROM gebruikers WHERE email = :email AND rechten = :rechten ");
		$query->execute(array(
			':email' => $email,
			'rechten' => 1
		));
		if ($query->rowCount() == 0) {
			header("Location: ?page=login&bericht=geenrechten");
			exit();
		} else {
			session_start();
			$_SESSION["rechten"] = "ja";
			header('Location: ?page=receptmaken');
		}
	}
}

?>