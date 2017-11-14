<?php

require_once("../backend/connection.php");
global $conn;

$query = $conn->prepare("SELECT maat FROM maten");
$query->execute();
$resultaat = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($resultaat);