<?php

include("config.php");

//Model
	try {
		$db = new PDO($Dsn,$Username,$Password);
		//$db = new PDO($Dsn,$Local_Username,$Local_Password$);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->exec("SET NAMES 'utf8'");
	} catch (Exception $e) {
		echo "Could not connect to the database.";
		exit;
	}

	try {
		$results = $db->query("SELECT title FROM us_bank ORDER BY zip ASC");
	} catch (Exception $e) {
		echo "Data could not be retrieved from the database.";
		exit;
	}

$locations = $results->fetchAll(PDO::FETCH_ASSOC);


?>