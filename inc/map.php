<!DOCTYPE html>
<!--Model-->
<html>
<head>
	<title>Map</title>
	<link href="../css/googlemaps-styles.css" rel="stylesheet" type="text/css">
	<style type="text/css">

	html, body, #map {
		width:100%;
		height: 100%;
		margin: 0;
	}
	</style>
</head>
<body>
	<div id="map"></div>
	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBc-gr3XtQHVmYvEFmD5FYm9vXhmBFGfyU&sensor=false">
    </script>
    <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
    <script type="text/javascript">
		var map;
		var bounds;
		var geocoder;
		var center;
		var infobox;
		function initialize() {
	        var mapOptions = {
	         	center: new google.maps.LatLng(43.0607, -89.3992),
	         	zoom: 8,
	         	mapTypeId: google.maps.MapTypeId.ROADMAP
	        };
	        map = new google.maps.Map(document.getElementById("map"),
	            mapOptions);
	        geocoder = new google.maps.Geocoder();
	        bounds = new google.maps.LatLngBounds();
	    }
	    function addMarkerToMap(location, addressBody, addressHeader, addressFooter){
	    	var image = "../img/banana5.gif";
	    	var marker = new google.maps.Marker({map: map, position: location, icon:image}
	    		);
	    	bounds.extend(location);
	    	map.fitBounds(bounds);
	    	//map.setZoom(12);
	    	//add code to define content of infowindow
	    	

	    	var content = 	'<div id = "content" >'+
	    						'<div id="bodyContent">'+
	    							'<h1>'+addressHeader+'</h1>'+
	    							'<p>Address:'+addressBody+'</p>'+
	    							'<p>'+addressFooter+'</p>'+
	    						'</div>'+
	    					'</div>'
	    	//var infoWindow = new google.maps.InfoWindow({ content : content});

	    	var infobox = new InfoBox({
	    		content: content,
	    		//content: document.getElementById("infobox"),
	    		
	    		disableAutoPan: false,
	    		maxWidth: 150,
	    		pixelOffset: new google.maps.Size(-140, 0 ),
	    		zIndex: null,
	    		boxStyle: {
	    			background:"url('http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/examples/tipbox.gif') no-repeat",
            		opacity: 1,
            		width: "280px"
	    		},
	    		closeBoxMargin: "12px 4px 2px 2px",
	    		closeBoxURL: "Http://www.google.com/intl/en_us/mapfiles/close.gif",
	    		infoBoxClearance: new google.maps.Size(1,1)
	    	});

	    	google.maps.event.addListener(marker, "click", function(){
	    		//infoWindow.open(map, marker);
    			
	    		infobox.open(map, this);

	    		map.panTo(location);
	    	});
	    	
	    }
      	initialize();

      	$(".address", parent.window.document).each(function(){
      		var $addressBody = $(this).children().eq(0);
      		var $addressHeader = $(this).children().eq(1);
      		var $addressFooter = $(this).children().eq(2);
      		//var $address2 = $address.find(">:first-child");
      		geocoder.geocode({address: $addressBody.text()}, function(results, status){
      			if (status == google.maps.GeocoderStatus.OK) {
      				addMarkerToMap(
      					results[0].geometry.location,
	      				$addressBody.html(),
	      				$addressHeader.html(),
	      				$addressFooter.html());
      			};
      		});
      	});
      	/*
      	if ($('.address').length > 0) {
	      	$("ul/li/address", parent.window.document).each(function(){
	      		var $address = $(this);
	      		geocoder.geocode({address: $address.text()}, function(results, status){
	      			if (status == google.maps.GeocoderStatus.OK) addMarkerToMap(results[0].geometry.location, $address.html());

	      		});
	      	})
      	};
      	*/
      	google.maps.event.addDomListener(map, "idle", function() {
      		center = map.getCenter();
      	});

      	$(window).resize(function(){
      		map.setCenter(center);
      	});
    </script>
    <!--
    <div class="infobox-wrapper">
    	<div id="infobox">
    		The contents of your info box. It's very easy to create and customize.
    		<?php
    			echo address;
    		?>
    	</div>
    </div>		
	-->
</body>
</html>