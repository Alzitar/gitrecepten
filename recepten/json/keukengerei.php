<?php

require_once("../backend/connection.php");
global $conn;

$query = $conn->prepare("SELECT keukengerei_naam FROM keukengerei");
$query->execute();
$resultaat = $query->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($resultaat);