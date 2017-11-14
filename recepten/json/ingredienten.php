<?php
require_once("../backend/connection.php");
global $conn;

$query = $conn->prepare("SELECT naam FROM ingredienten");
$query->execute();
$resultaat = $query->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($resultaat);