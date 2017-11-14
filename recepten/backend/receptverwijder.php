<?php
require_once('functies.php');
require_once('connection.php');
global $conn;


$receptID = $_POST['action'];

sessionCheck();

$queryy = $conn->prepare("DELETE FROM recept_ingredient WHERE recept_id = :receptID");
$queryy->execute(array(
	':receptID' => $receptID
));

$queryy = $conn->prepare("DELETE FROM recept_keukengerei WHERE recept_id = :receptID");
$queryy->execute(array(
	':receptID' => $receptID
));

$queryy = $conn->prepare("DELETE FROM recepten WHERE id = :receptID");
$queryy->execute(array(
	':receptID' => $receptID
));


header('Location: https://website.nl/recepten/?page=index&bericht=receptverwijderd ');
