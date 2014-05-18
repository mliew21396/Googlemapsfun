<!-- Google Maps Project -->
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale = 1.0, user-scalable = no">
	<title>Google Maps API Project</title>
	<link href="../css/bootstrap-3.1.1-dist/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="../css/bootstrap-3.1.1-dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css">	
	<link href="../css/googlemaps-styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php

$locations = array();//initalize the locations array
$near_locations = array();//initalize the near_locations array
//grabs value from dropdown and places in $distance
?><p>test1<p><?php
if (!empty($_GET)) {
		$distance = filter_var($_GET['radius'], FILTER_SANITIZE_NUMBER_INT);
};		
//grabs search term zip and queries database for all locations associated distances
?><p>test2<p><?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$search_term = "";
echo $search_term."hi";
if(isset($_GET["s"]) && is_numeric($_GET["s"])) {
	echo $search_term."hi2";
	$search_term = trim($_GET["s"]);
	echo $search_term."hi3";
	if ($search_term!= "") {
		echo $search_term."hi4";
		require_once("../inc/locations.php");
		echo $search_term."hi5";
		$locations = get_locations_search($search_term);
		echo $search_term."hi6";
	}
}

//takes the locations array from the database and filters out not-nearby locations
?><p>test3<p><?php
for ($i=0; $i < count($locations) ; $i++) {
	if ($locations[$i]["Distance"] < $_GET['radius']) {
		//echo "This matches";
		$near_locations[] = $locations[$i];
	};
};
//sanitizing $_GET['radius'] to $dropdown
?><p>test4<p><?php
if (!empty($_GET['radius'])) {
	$dropdown = $_GET['radius'];
} else {
	$dropdown = 1;
};
?>
	<!--Google Maps div-->
	<div id="locations">
		<p class="static_map">
			<img src="http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyBc-gr3XtQHVmYvEFmD5FYm9vXhmBFGfyU&size=400x300&sensor=false&markers=1216+Spring+Street,+Madison,+WI+53715" alt="1216 Spring Street, Madison, WI 53715 ">
		</p>	
	</div>	
	<!--Search Bar div-->
	<div id="container">
		<div>
			<h1>Search</h1>
			<form method="get" >
				<input type="text" class="boxes" name="s" 
				onFocus="this.value =''" onblur="this.value ='Enter Zip Code'"
				value ="<?php if(isset($_GET['s'])) {
					echo htmlspecialchars($search_term);
				} else {
					echo "Enter Zip Code";
				};?>">
				<select name="radius" class="boxes">
					<option value="1"
						<?php if ($dropdown==1) {
							echo "selected='selected'";
						}?>>
						1 mile away</option>
					<option value="5"
						<?php if ($dropdown==5) {
							echo "selected='selected'";
						}?>>
						5 miles away</option>
					<option value="10"
						<?php if ($dropdown==10) {
							echo "selected='selected'";
						}?>>
						10 miles away</option>										
				</select>
				<input type="submit" class="btn btn-primary btn-med" value="Submit">
			</form>
		</div>
	</div>
	<!--Search Address Results div-->
	<div id="searchresults">	
		<?php
			if($search_term != "") {
				if (!empty($near_locations)) {
					echo'<ul>';
					foreach ($near_locations as $near_location) {
						?><li>
	        				<p><?php echo $near_location["Title"]; ?></p>
	        				<address class="address">
	        					<?php echo $near_location["Address"]?>, 
	        					<?php echo $near_location["City"]?>, 
	        					<?php echo $near_location["State"]?> 
	        					<?php echo $near_location["Zip"]?>
	        					<br>
	        					<?php echo "Distance Away: " . $near_location["Distance"] . " miles"?>	        					
	        				</address>
	    				</li><?php	
					}
					echo '</ul>';
				} else {
					?><p> No products were found matching that search term.</p><?php 
				}	
			}
		?>
	</div>	
	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript">	
		$("#locations").each(function(i) {
			$(this).prepend('<iframe id="map" src="map.html" seamless="seamless" scrolling="no"></iframe>');
			console.log(i);
		});
		$(".static_map").remove();
	</script>
</body>	
</html>