<!-- Google Maps Project -->
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale = 1.0, user-scalable = no">
	<title>Google Maps API Project</title>
	<link href="../css/bootstrap-3.1.1-dist/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="../css/bootstrap-3.1.1-dist/css/bootstrap-theme.css" rel="stylesheet" type="text/css">	
	<link href="../css/my-styles.css" rel="stylesheet" type="text/css">
</head>
<?php
//grabs value from dropdown and places in $distance
if (!empty($_GET)) {
		$distance = filter_var($_GET['distance'], FILTER_SANITIZE_NUMBER_INT);
		echo $distance;
//grabs search_term string
$search_term = "";
if(isset($_GET["s"])) {
	$search_term = trim($_GET["s"]);
	if ($search_term!= "") {
		require_once("../inc/locations.php");
		$locations = get_locations_search($search_term);
	}
}

?>
<body>
	<!--Search Bar div-->
	<div>
		<h1>Search</h1>
		<form method="get" >
			<input type="text" name="s" value ="<?php echo htmlspecialchars($search_term);?>">
			<select name="distance">
				<option>1 mile away</option>
				<option>5 miles away</option>
				<option>10 miles away</option>
			</select>
			<input type="submit"value="Go">
		</form>
	</div>
	<!--Google Maps div-->
	<div id="locations">

		<p>Static/Dynamic Map</p>
		<p class="static_map">
			<img src="http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyBc-gr3XtQHVmYvEFmD5FYm9vXhmBFGfyU&size=400x300&sensor=false&markers=1216+Spring+Street,+Madison,+WI+53715" alt="1216 Spring Street, Madison, WI 53715 ">
		</p>
		<address>
			1216 Spring Street, Madison, WI 53715
		</address>
		<!--
		<address>
			3419 Cross Creek Circle, Wooster, OH 44691
		</address>
		<address>
			2970 North Sheridan Road, Chicago, IL 60657
		</address>
		-->
	<!--Search Address Results div-->
	
		<?php
			if($search_term != "") {
				if (!empty($locations)) {
					echo'<ul>';
					foreach ($locations as $location) {
						?><li>
	        				<p><?php echo $location["title"]; ?></p>
	        				<address>
	        					<?php echo $location["address"]?>, 
	        					<?php echo $location["city"]?>, 
	        					<?php echo $location["state"]?> 
	        					<?php echo $location["zip"]?>
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

	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript">
		
		$("#locations").each(function(i) {
			$(this).prepend('<iframe id="map" src="map.html" seamless="seamless" scrolling="no"></iframe>');
			console.log(i);
		});
		$(".static_map").remove();
	</script>
</body>	
</html>