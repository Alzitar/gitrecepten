<?php

require_once("connection.php");
global $conn;


if (isset($_POST['submit'])) {

	//	Variablen van het registratie form assignen.
	$voornaam = $_POST['voornaam'];
	$achternaam = $_POST['achternaam'];
	$email = $_POST['email'];
	$wachtwoord = $_POST['wachtwoord'];


	$query = $conn->prepare("SELECT email FROM gebruikers WHERE email = :email");
	$query->execute(array(
		':email' => $email
	));

	if ($query->rowCount() != 0) {
		header("Location: https://website.nl/recepten/?page=registratie&bericht=emailalgebruikt");
		exit();
	} else {

		//ENCRYPT WACHTWOORD
		$wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
		/*$wachtwoord = md5($wachtwoord);*/

		//PREPARED STATEMENT - ANTI SQL INJECTTION
		$queryy = $conn->prepare("INSERT INTO gebruikers(voornaam, achternaam, email, wachtwoord) VALUES(:voornaam, :achternaam, :email, :wachtwoord)");

		//QUERY UITVOEREN
		$queryy->execute(array(
			':voornaam' => $voornaam,
			':achternaam' => $achternaam,
			':email' => $email,
			':wachtwoord' => $wachtwoord
		));

		header("Location: https://website.nl/recepten/?page=registratie&bericht=registratie");
	}
}

?>



