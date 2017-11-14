<?php

require_once("connection.php");
global $conn;

if (isset($_POST['submit'])) {


	//	Variablen voor inloggen
	$email = $_POST['email'];
	$wachtwoord = $_POST['wachtwoord'];

	// Dit is niet veilig genoeg maar even ter demonstratie:
//	$wachtwoord = md5($wachtwoord);



	//  Zo kan je ook een prepared statement uitvoeren maar het is iets minder mooi:
	//	$query = $conn->prepare("SELECT email FROM gebruikers WHERE email = :email AND wachtwoord = :wachtwoord");
	//	$query->bindParam(':email', $email);
	//	$query->bindParam(':wachtwoord', $wachtwoord);
	//	$query->execute();


	$query = $conn->prepare("SELECT wachtwoord FROM gebruikers WHERE email = :email");
	$query->execute(array(
		':email' => $email,
	));
	$databaseWachtwoord = $query->fetchColumn();
	$goedWachtwoord = password_verify($wachtwoord, $databaseWachtwoord);

	if (!$goedWachtwoord) {
				header("Location: https://website.nl/recepten/?page=login&bericht=combinatieww");
		exit();
	} else {
		$query = $conn->prepare("SELECT email FROM gebruikers WHERE email = :email AND rechten = :rechten ");
		$query->execute(array(
			':email' => $email,
			'rechten' => 1
		));
		if ($query->rowCount() == 0) {
			header("Location: https://website.nl/recepten/?page=login&bericht=geenrechten");
			exit();
		} else {
			session_start();
			$_SESSION["rechten"] = "ja";
			header('Location: ?page=receptmaken');
		}
	}
}

?>