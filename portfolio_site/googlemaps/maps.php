<?php
/*
Returns full list of maps of usbank locations.

*/
function get_maps_all() {

	require(ROOT_PATH . "portfolio_site/googlemaps/database.php")

	try {
		$results = $db->query("SELECT address, branch, city, phone, state, title, zip FROM us_bank");
	} catch(Exception $e) {
		echo "Data could not be retrieved from the database.";
		exit;
	}

	$products = $results->fetchAll(PDO::FETCH_ASSOC);

	return $products;
}
/*
echo "<pre>";
var_dump($results->fetchAll(PDO::FETCH_ASSOC));
*/

function get_maps_single() {

	
}


echo "$products["title"]";
?>
<p>lkj</p>