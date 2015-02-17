<!-- Google Maps Project -->
<!--View-->
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale = 1.0, user-scalable = no">
	<title>Google Maps API Project</title>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="css/bootstrap-theme.css" rel="stylesheet" type="text/css">	
	<link href="css/googlemaps-styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 
	require("inc/control.php");
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
			<h1>Search Madison, WI</h1>
			<form method="get" >
				<input type="text" class="boxes" name="s" 
				onFocus="this.value =''" placeholder="Enter Zip Code"
				value ="<?php if(isset($locations)) {
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
				<input type="submit" class="btn btn-primary btn-med subbut" value="Submit">
			</form>
			<p class="home_descrip">This site searches all banks and credit unions in the Madison Wi greater area.</p>
		</div>
	</div>
	<!--Search Address Results div-->
	
	<!--<div id="searchresults">-->
	<div class="infobox-wrapper">
		<div id="infobox">
			<?php
				if($search_term != "") {
					if (!empty($near_locations)) {
						echo'<ul>';
						foreach ($near_locations as $near_location) {
							?><li>
		        				<address class="address">
		        					<?php echo "<div class=\"bodyAddress\">"?> 
			        					<?php echo $near_location["Address"]?>, 
			        					<?php echo $near_location["City"]?>, 
			        					<?php echo $near_location["State"]?> 
			        					<?php echo $near_location["Zip"]?>
		        					<?php echo "</div>"?>, 
		        					<?php echo "<div class=\"headerAddress\">"?>
			        					<?php echo $near_location["Bank"] ?>
			        					<br>
			        					<?php echo $near_location["Title"]?>
		        					<?php echo "</div>"?>, 
		        					<?php echo "<div class=\"footerAddress\">"?>
			        					<?php echo "Distance Away: " . round($near_location["Distance"],2) . " miles"?>	        					
			        					<br><br>
			        					<?php echo "Checking Rate: " . $near_location["Checking"*100] . "%"?>
			        					<br><br>
			        					<?php echo "Saving Rate: " . $near_location["Saving"*100] . "%"?>
		        					<?php echo "</div>"?>, 
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
	</div>	
	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript">	
		$("#locations").each(function(i) {
			$(this).prepend('<iframe id="map" src="inc/map.php" seamless="seamless" scrolling="no"></iframe>');
			console.log(i);
		});
		$(".static_map").remove();
	</script>
</body>	
</html>