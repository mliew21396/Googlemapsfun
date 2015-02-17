<?php

include("config.php");

//Model
	try {
		$db = new PDO("mysql:host=localhost;dbname=Dbname;port=3306","Username","Password");
		//$db = new PDO("mysql:host=localhost;dbname=u921722718_banks;port=3306","u921722718_admin","westwood");
		//$db = new PDO("mysql:host=localhost;dbname=u921722718_banks;port=3306","root","root");
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