<?php


//////////////////////////////////// FUNCTIES DIE MET NAME QUERIES OP DE DATABASE UITVOEREN ///////////

require_once("connection.php");
global $conn;


/////////////////////// BERICHT FUNCTIE //////////////////////

function berichtBestaat()
{
	if (isset($_GET['bericht'])) {
		$bericht = $_GET['bericht'];
		switch ($bericht) {
			case "bestaat":
				echo "Foutmelding: De receptnaam die u heeft gebruikt bestaat al.";
				break;
			case "geenIngredienten":
				echo "Foutmelding: Je hebt geen ingredienten ingevuld.";
				break;
			case "geenReceptNaam":
				echo "Foutmelding: Je hebt geen recept naam ingevuld.";
				break;
			case "geenReceptOmschrijving":
				echo "Foutmelding: Je hebt geen recept omschrijving ingevuld.";
				break;
			case "geenReceptInstructies":
				echo "Foutmelding: Je hebt geen recept instructies ingevuld.";
				break;
			case "receptGemaakt":
				echo "Het recept is aangemaakt!";
				break;
			case "zelfdeIngredient":
				echo "Foutmelding: Je hebt twee keer hetzelfde ingredient toegevoegd.";
				break;
			case "registratie":
				echo "Gefeliciteer! Je account is aangemaakt, neem contact op met de beheerder om rechten te krijgen.";
				break;
			case "combinatieww":
				echo "De combinatie van dit email adres met wachtwoord bestaat niet, controleer of je het emailadres of wachtwoord goed hebt ingevoerd.";
				break;
			case "geenrechten":
				echo "Je account bestaat maar je hebt nog geen rechten, neem contact op met de beheerder";
				break;
			case "probeernogeenkeer":
				echo "Er is iets fout gegaan probeer het nog een keer";
				break;
			case "emailalgebruikt":
				echo "Foutmelding: Dit email adres is al in gebruik";
				break;
			case "ingelogd":
				echo "Je bent al ingelogd";
				break;
			case "receptverwijderd":
				echo "Het recept is verwijderd";
				break;
			default:
				echo "dunno what happend.";
				break;
		}
	}
}


///////////////// Sessie ///////////////////////
function sessionCheck()
{
	session_start();
	if (!isset($_SESSION['rechten'])) {
		header('Location: https://website.nl/recepten/?page=login');
		exit();
	}
}


function sessionCheckLogin()
{
	session_start();
	if (isset($_SESSION['rechten'])) {
		header('Location: https://website.nl/recepten/?page=index&bericht=ingelogd');
		exit();
	}
}


/*
Haal alle recepten op.
*/
function getRecepten()
{

	global $conn;
	$query = $conn->prepare('SELECT * FROM recepten');
	$query->execute();

	while ($row = $query->fetch(PDO::FETCH_OBJ)) {
		$id = $row->id;
		$receptnaam = $row->naam;

		session_start();
		if (!isset($_SESSION['rechten'])) {
			echo "<a href='?page=recept&id={$id}'>{$receptnaam}</a><br>";
		} else {
			echo "  <div><button class='receptVerwijderButton' type='button' value='$id'>-</button></a> <a href='?page=recept&id={$id}'>{$receptnaam}</a></div><br>";
		}
	}
}

/*
Haal de details van een recept op.
*/
function getRecept()
{

	global $conn;

	// HAAL HET RECEPT OP
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$query = $conn->prepare("SELECT * FROM recepten WHERE id = :receptID");
		$query->execute(array(
			':receptID' => $id,
		));


		while ($row = $query->fetch(PDO::FETCH_OBJ)) {
			$receptnaam = $row->naam;
			$omschrijving = $row->omschrijving;
			$instructie = $row->instructie;

			echo "<h2>$receptnaam</h2> <h3>Omschrijving:</h3> $omschrijving <br><h3>Instructies:</h3> $instructie<br>";


		}


		/*
		Inner joins om de ingredienten voor het recept met de hoeveelheden weer te geven.
		*/
		echo "<h3>Ingredienten: </h3>";

		$query = $conn->prepare("

			SELECT ingredienten.naam, ingredienten.id, maten.maat, maten.meervoud, recept_ingredient.hoeveelheid
			FROM recept_ingredient
			INNER JOIN recepten
			ON recept_ingredient.recept_id = recepten.id	
			INNER JOIN ingredienten
			ON recept_ingredient.ingredient_id = ingredienten.id
			INNER JOIN maten
			ON recept_ingredient.maat_id = maten.id
			WHERE recepten.id = :receptID;
			
		");
		$query->execute(array(
			':receptID' => $id,
		));


		while ($row = $query->fetch(PDO::FETCH_OBJ)) {
			$ingredienten_naam = $row->naam;
			$ingredienten_id = $row->id;

			$ingredienten_hoeveelheid = $row->hoeveelheid;


			// Meervoud of enkelvoud ingredienten
			if ($ingredienten_hoeveelheid > 1) {
				$ingredienten_maat = $row->meervoud;
			} else {
				$ingredienten_maat = $row->maat;
			}
			$ingredienten_naam = strtolower($ingredienten_naam);

			echo "<a href='?page=ingredient&id=$ingredienten_id'>$ingredienten_naam:</a> $ingredienten_hoeveelheid $ingredienten_maat <br>";

		}


		/*
		 Inner joins om al het keukengerei op te halen wat je nodig hebt voor het recept.
		 */
		echo "<h3>Keukengerei: </h3>";

		$query = $conn->prepare("

			SELECT keukengerei.keukengerei_naam
			FROM recept_keukengerei
			INNER JOIN recepten
			ON recept_keukengerei.recept_id = recepten.id
			INNER JOIN keukengerei
			ON recept_keukengerei.keukengerei_id = keukengerei.id
			WHERE recept_id = $id;
			
		");
		$query->execute(array(
			':receptID' => $id,
		));


		while ($row = $query->fetch(PDO::FETCH_OBJ)) {
			$keukengerei = $row->keukengerei_naam;

			echo "$keukengerei<br>";

		}
	}

}


/*
Haal alle ingredienten op.
*/
function getIngredienten()
{

	global $conn;

	//GET DATA FROM DATABASE
	$query = $conn->prepare("SELECT * FROM ingredienten");
	$query->execute();



	while ($row = $query->fetch(PDO::FETCH_OBJ)) {
		$naam = $row->naam;
		$id = $row->id;

		$query2 = $conn->prepare("SELECT ingredient_id FROM recept_ingredient WHERE ingredient_id = :ingredientID");
		$query2->execute(array(
			':ingredientID' => $id
		));

		if ($query2->rowCount() != 0) {
			$zitInRecept = "v";
		} else {
			$zitInRecept = "";
		}


		echo "<a href='?page=ingredient&id={$id}'>{$naam} {$zitInRecept}</a><br>";


	}
}


/*
Haal alle recepten op waar dit ingredient in voorkomt.
*/
function getIngredient()
{
	global $conn;

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		//GET DATA FROM DATABASE
		$query = $conn->prepare("

			SELECT recepten.naam, recepten.id
			FROM recept_ingredient
			INNER JOIN recepten
			ON recept_ingredient.recept_id = recepten.id	
			INNER JOIN ingredienten
			ON recept_ingredient.ingredient_id = ingredienten.id
			WHERE ingredienten.id = :ID;
		");
		$query->execute(array(
			':ID' => $id
		));


		while ($row = $query->fetch(PDO::FETCH_OBJ)) {
			$receptnaam = $row->naam;
			$receptid = $row->id;


			echo "<a href='?page=recept&id={$receptid}'>{$receptnaam}</a><br>";

		}
	}
}


?>