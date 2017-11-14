<?php

try {
	$conn = new PDO('mysql:','','');
	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo "Database connection error.";
}

