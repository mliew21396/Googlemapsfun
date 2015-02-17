<?php
//controller -search
	$locations = array();//initalize the locations array
	$near_locations = array();//initalize the near_locations array
	//grabs value from dropdown and places in $distance
	if (!empty($_GET)) {
			$distance = filter_var($_GET['radius'], FILTER_SANITIZE_NUMBER_INT);
	};		
	//grabs search term zip and queries database for all locations associated distances
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$search_term = "";
	if(isset($_GET["s"]) && is_numeric($_GET["s"])) {
		$search_term = trim($_GET["s"]);
		if ($search_term!= "") {
			require_once("inc/locations.php");
			$locations = get_locations_search($search_term);
		}
	}

	//takes the locations array from the database and filters out not-nearby locations
	for ($i=0; $i < count($locations) ; $i++) {
		if ($locations[$i]["Distance"] < $_GET['radius']) {
			//echo "This matches";
			$near_locations[] = $locations[$i];
		};
	};

	//sanitizing $_GET['radius'] to $dropdown
	if (!empty($_GET['radius'])) {
		$dropdown = $_GET['radius'];
	} else {
		$dropdown = 1;
	};
