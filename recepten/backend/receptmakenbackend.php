<pre>
<?php

require_once("connection.php");
require_once("functies.php");


///////////////////////////////// VARIABLEN ASSIGNEN ///////////////////////////

global $conn;

$receptNaamTest = $_POST['receptNaam'];
$receptOmschrijving = $_POST['receptOmschrijving'];
$receptInstructies = $_POST['receptInstructies'];
$ingredientenPostArray = $_POST['ingredient'];
$hoeveelheidPostArray = $_POST['hoeveelheid'];
$maatPostArray = $_POST['maat'];
$keukengereiPostArray = $_POST['keukengerei'];


/////////////////////////////////// BACKEND CHECKS /////////////////////////////////


//extra sessions check
sessionCheck();


// controleren of alles is ingevuld
switch (!empty($var)) {
	case $receptNaamTest:
		header('Location: ?page=receptmaken&&bericht=geenReceptNaam');
		exit();
	case $receptOmschrijving:
		header('Location: ?page=receptmaken&bericht=geenReceptOmschrijving');
		exit();
	case $receptInstructies:
		header('Location: ?page=receptmaken&bericht=geenReceptInstructies');
		exit();
	case $ingredientenPostArray:
		header('Location: ?page=receptmaken&bericht=geenIngredienten');
		exit();
	case $hoeveelheidPostArray:
		header('Location: ?page=receptmaken&bericht=geenIngredienten');
		exit();
	case $maatPostArray :
		header('Location: ?page=receptmaken&bericht=geenIngredienten');
		exit();
	// keukengerei mag leeg zijn!
}


// Twee keer zelfde ingredient ingevoerd?
if (count($ingredientenPostArray) !== count(array_unique($ingredientenPostArray))) {
	header('Location: ?page=receptmaken&bericht=zelfdeIngredient');
	exit();
}

// Twee keer zelfde keukengerei ingevoerd? -> oplossing.
$keukengereiPostArray = array_unique($keukengereiPostArray);


// RECEPTNAAM controleren of de receptnaam al bestaat.

$query = $conn->prepare("SELECT naam FROM recepten WHERE naam = :receptNaam");
$query->execute(array(
	':receptNaam' => $receptNaamTest
));

if ($query->rowCount() != 0) {
	header('Location: ?page=receptmaken&bericht=bestaat');
	exit();
} else {
	$receptNaamGoed = $receptNaamTest;
}


///////////////////////////////////// RECEPT TOEVOEGEN /////////////////////////////////////////////


$queryy = $conn->prepare("INSERT INTO recepten(naam, omschrijving, instructie) VALUES(:receptNaam, :receptOmschrijving, :receptInstructies)");
$queryy->execute(array(
	':receptNaam' => ucfirst($receptNaamGoed),
	':receptOmschrijving' => $receptOmschrijving,
	':receptInstructies' => $receptInstructies
));


// INGREDIENT
////////////////////////////// ARRAY MAKEN MET ALLE INGREDIENTEN (zodat niet elke keer database connectie nodig is om te chekken) /////////////////

$query = $conn->prepare("SELECT naam FROM ingredienten");
$query->execute();

$ingredientenDatabaseArray = $query->fetchAll(PDO::FETCH_COLUMN);

// alles lowercase voor vergelijking
$ingredientenDatabaseArray = array_map('strtolower', $ingredientenDatabaseArray);


////////////////////////////////////// NIEUWE INGREDIENTEN TOEVOEGEN ////////////////////////////

foreach ($ingredientenPostArray as $ingredient) {
	if (!in_array(strtolower($ingredient), $ingredientenDatabaseArray)) {

		//PREPARED STATEMENT - ANTI SQL INJECTION
		$queryy = $conn->prepare("INSERT INTO ingredienten(naam) VALUES(:ingredientNaam)");

		//QUERY UITVOEREN
		$queryy->execute(array(
			':ingredientNaam' => ucfirst(strtolower($ingredient))
		));
	}
}


////////////////////////////////// RECEPT ID /////////////////////////////////


$query = $conn->prepare("SELECT id FROM recepten WHERE naam = :receptNaam");
$query->execute(array(
	':receptNaam' => $receptNaamGoed
));

$receptID = $query->fetchColumn();


////////////////////////////// MAAT ID ///////////////////////////////////


$query = $conn->prepare("SELECT id, maat FROM maten");
$query->execute();

$matenIdDatabaseArray = $query->fetchAll(PDO::FETCH_NUM);


print_r($matenIdDatabaseArray);


$maatIDArray = [];

foreach ($maatPostArray as $maat) {
	foreach ($matenIdDatabaseArray as $matenArray)
		if (in_array($maat, $matenArray)) {
			array_push($maatIDArray, $matenArray[0]);
		}
}


//// INGREDIENTEN NAAM + ID array maken ////

$query = $conn->prepare("SELECT id, naam FROM ingredienten");
$query->execute();

$ingredientenIdDatabaseArray = $query->fetchAll(PDO::FETCH_NUM);

$i = 0;
foreach ($ingredientenPostArray as $ingredient) {
	foreach ($ingredientenIdDatabaseArray as $ingredientArray)
		if (in_array(strtolower($ingredient), ($ingredientArray = array_map('strtolower', $ingredientArray)))) {

//PREPARED STATEMENT - ANTI SQL INJECTION
			$queryy = $conn->prepare("INSERT INTO recept_ingredient(recept_id, ingredient_id, hoeveelheid, maat_id) VALUES(:receptID, :ingredientID, :hoeveelheid, :maatID)");
			//QUERY UITVOEREN
			$queryy->execute(array(
				":receptID" => $receptID,
				":ingredientID" => $ingredientArray[0],
				":hoeveelheid" => $hoeveelheidPostArray[$i],
				":maatID" => $maatIDArray[$i]
			));

			$i += 1;

		}
}


///KEUKENGEREI
///
////////////////////////////// ARRAY MAKEN MET ALLE KEUKENGEREI (zodat niet elke keer database connectie nodig is om te chekken) /////////////////


if (!empty($keukengereiPostArray)) {
	$query = $conn->prepare("SELECT keukengerei_naam FROM keukengerei");
	$query->execute();

	$keukengereiDatabaseArray = $query->fetchAll(PDO::FETCH_COLUMN);

	// alles lowercase voor vergelijking
	$keukengereiDatabaseArray = array_map('strtolower', $keukengereiDatabaseArray);


	////////////////////////////////// NIEUWE KEKENGEREI TOEVOEGEN ////////////////////////////////////

	foreach ($keukengereiPostArray as $keukengerei) {
		if (!in_array(strtolower($keukengerei), $keukengereiDatabaseArray)) {
			$queryy = $conn->prepare("INSERT INTO keukengerei(keukengerei_naam) VALUES(:keukengereiNaam)");
			$queryy->execute(array(
				':keukengereiNaam' => ucfirst(strtolower($keukengerei))
			));
		}
	}
}


//// KEUKENGEREI NAAM + ID array  ////

$query = $conn->prepare("SELECT id, keukengerei_naam FROM keukengerei");
$query->execute();

$keukengereiIdDatabaseArray = $query->fetchAll(PDO::FETCH_NUM);


/////////////////////// KEUKENGEREI AAN RECEPT KOPPELEN /////////////////////////////////

$i = 0;
foreach ($keukengereiPostArray as $keukengerei) {
	foreach ($keukengereiIdDatabaseArray as $keukengereiArray)
		if (in_array(strtolower($keukengerei), ($keukengereiArray = array_map('strtolower', $keukengereiArray)))) {

//PREPARED STATEMENT - ANTI SQL INJECTION
			$queryy = $conn->prepare("INSERT INTO recept_keukengerei(recept_id, keukengerei_id) VALUES(:receptID, :keukengereiID)");
			//QUERY UITVOEREN
			$queryy->execute(array(
				":receptID" => $receptID,
				":keukengereiID" => $keukengereiArray[0],
			));

			$i += 1;

		}
}


header('Location: ?page=receptmaken&bericht=receptGemaakt')

?>
</pre>
