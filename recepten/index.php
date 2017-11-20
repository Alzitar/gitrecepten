<?php

if (isset($_GET['page'])) {

	$page = $_GET['page'];
	switch ($page):
		case "index":
			require_once("pages/index.php");
			break;
		case "recept":
			require_once("pages/recept.php");
			break;
		case "ingredienten":
			require_once("pages/ingredienten.php");
			break;
		case "ingredient":
			require_once("pages/ingredient.php");
			break;
		case "registratie":
			require_once("pages/registratie.php");
			break;
		case "login":
			require_once("pages/login.php");
			break;
		case "login_uitkomst":
			require_once("backend/login.php");
			break;
		case "receptmaken":
			require_once("pages/receptmaken.php");
			break;
		case "logout":
			require_once("backend/logout.php");
			break;
		default:
			echo "No such page";
	endswitch;
} else {
	header("Location: ?page=index");
}