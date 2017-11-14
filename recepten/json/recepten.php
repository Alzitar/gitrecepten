<?php
require_once("../backend/connection.php");
global $conn;



if (isset($_GET['type'], $_GET['value'])) {

	$type = strtolower(trim($_GET['type']));
	$value = trim($_GET['value']);

	$output = ['bestaat' => false];

	if (in_array($type, ['naam'])) {

		$query = $conn->prepare("
			SELECT COUNT(*) AS count
			FROM recepten
			WHERE naam = :value
		");
			$query->execute(['value' => $value]);

		$output['exists'] = $query->fetchObject()->count ? true : false;

		echo json_encode($output);
	}

}


