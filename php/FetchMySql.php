<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> <HTML>
<title>hactus - the Cheat Sheet for Entrepreneurs</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<head>
<script type="text/javascript" src="http://www.fractalgames.com/bin/jquery.js"></script>
 
<script>	// Array logic
	
	var sqlArray = [];
	
	// Maybe I don't need many arrays, but just one array?
	// Idea: allow my #_GET statement to iterate through as many HTML &foo=bar as there are according to &i=14
	// This way, I can create an arbitrary number of multiple arrays and pass them back to the client, and I don't have to write the logic for each array and different table.
	// Or, should I just call the SQL separately for each array? Might be easier.
	// Also, I need to store this data locally on XML so I need a PHP > XML function, then in JAvascript I need to check if XML != null then use it instead of MySQL/PHP
	// ref: http://www.ryancoughlin.com/2008/11/04/use-jquery-to-submit-form/
	
	
	var coworkingmarkersArray = [];
	var coworkingAddressArray = [];
	var coworkingDescriptionArray = [];
	var coworkingNameArray = [];
	var coworkingNameURLArray = [];
	var coworkingPhoneArray = [];
	var coworkingCostArray = [];
	var coworkingLatLngArray = [];

	var incubatormarkersArray = [];
	var incubatorAddressArray = [];
	var incubatorDescriptionArray = [];
	var incubatorNameArray = [];
	var incubatorNameURLArray = [];
	var incubatorPhoneArray = [];
	var incubatorCostArray = [];
	var incubatorLatLngArray = [];

	var housemarkersArray = [];
	var houseAddressArray = [];
	var houseDescriptionArray = [];
	var houseNameArray = [];
	var houseNameURLArray = [];
	var housePhoneArray = [];
	var houseCostArray = [];
	var houseLatLngArray = [];

	var othermarkersArray = [];
	var otherAddressArray = [];
	var otherDescriptionArray = [];
	var otherNameArray = [];
	var otherNameURLArray = [];
	var otherPhoneArray = [];
	var otherCostArray = [];
	var otherLatLngArray = [];

	var eventmarkersArray = [];
	var eventAddressArray = [];
	var eventDescriptionArray = [];
	var eventNameArray = [];
	var eventNameURLArray = [];
	var eventPhoneArray = [];
	var eventCostArray = [];
	var eventLatLngArray = [];
	
	var infoWindowArray = [];
	
	// Some check arrays because sometimes, not all of the markers show up // Depricated - use mgr to handle all markers.
	var showMarkerCheckArray = [];
	var markerFunctionCheckArray = [];
	
	// Let's define some arrays that the PHP code will push data from MySQL into:
	var eventLocationArray = [];
	var eventTitleArray = [];
	var eventDescriptionArray = [];



	// A temporary address array to iterate thru while Minda sets up MYSQL which we will use in the future
	var map;
	var geocoder;
	var service;
	var infowindow;
	var sanMateo;
	var mgr;
	
  function initialize() {

    var latlng = new google.maps.LatLng(37.4736, -122.3317);
    geocoder = new google.maps.Geocoder();
	 sanMateo = new google.maps.LatLng(37.540585,-122.326813);
      map = new google.maps.Map(document.getElementById('map_canvas'), {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: sanMateo,
        zoom: 9,
        scrollwheel: false
      });
	PushArrayToCookie(incubatorLatLngArray);
//		mgr = new google.maps.MarkerManager(map); V2.0 only

  }
  
  function waitForMs(millis) 	{
	var date = new Date();
	var curDate = null;

	do { curDate = new Date(); } 
	while(curDate-date < millis);
} 
	
/******* Use to search google maps at runtime.
	function callback(results, status) {
	  if (status == google.maps.places.PlacesServiceStatus.OK) {
	    for (var i = 0; i < results.length; i++) {
          var place = results[i];
          createMarker(results[i]);

	    }
	  }
	}
	
	function callback_Details(results, status) {
	if (status == google.maps.places.PlacesServiceStatus.OK) {
	  	placeDetails = results.formatted_address;
	    for (var i = 0; i < results.length; i++) {
	    }
	  }
	}	


    function createMarker(place) {
      var placeLoc = place.geometry.location;
      var marker = new google.maps.Marker({ map: map,        position: new google.maps.LatLng(placeLoc.lat(), placeLoc.lng())      });
      google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent("<b>"+place.name+"</b> <br>"+placeDetails);
        infowindow.open(map, this);
      });
    }
    
    ****/ // Use to search google maps live. does NOT work for category search at this time so is pretty much useless. (works for name or type only, so can't search coworking spaces)

	function hideMarkers(markersArray) {
	  if (markersArray) {
    	for (i in markersArray) {
	     markersArray[i].setMap(null);
		// Need to use marker manager mgr to hide here.
    	}
	  }
	}

	function showMarkers (markersArray, addressArray, descriptionArray, nameArray, nameURLArray, phoneArray, costArray, colorNumber) {
		if (markersArray[0] != null) {
//			alert('showMarkers called, markersArray not null');	    				
			for (var i=0; i<markersArray.length; i++) {	
				markersArray[i].setMap(map);

				// Need to use marker manager mgr to show here.
			}
		}
	    else if (addressArray) {
//			alert('showMarkers called, addressArray not null');

	    	for (var i=0; i<addressArray.length; i++) {	
	    		Marker_function(markersArray, addressArray[i], descriptionArray[i], nameArray[i], nameURLArray[i], phoneArray[i], costArray[i], markerColors[colorNumber]);

	    	}
	    }
	}
	
    function Marker_function( markersArray, address, content_string, content_title, name_URL, phone_number, cost, image ) 	{
	// We should actually use this function to pull existing marker info from the MySQL "Markers" table
	/* NOT DONE */
	// The following should only be run ONCE to populate the MySQL "Markers" table
	  geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			markersArray.push(results[0].geometry.location);
			
		}
		else (debug("Geocoder failed because of "+status));
	  })


		// Make a new marker based on MySQL or geocoder LatLngs.
		
		var new_marker = new google.maps.Marker({position:markerLatLngArray[j], map:map,    title:content_title, icon:image  })
		markersArray.push(new_marker);
		
		var new_content_string =  '<div id="content">'+'<div id="siteNotice">'+'</div>'+'<h3 id="firstHeading" class="firstHeading">'+'<a href='+name_URL+' target="_blank">'+content_title+'</a>'+'</h3>'+address+'<p>'+content_string+'<p>'+phone_number+'</div>';
   	 	if (cost != undefined) 		    new_content_string += '<p> Cost: '+cost;
		var new_infowindow = new google.maps.InfoWindow({    content: new_content_string  });
		// Let's push each infowindow into an array so we can close them all when you open a new one
		infoWindowArray.push(new_infowindow);
		google.maps.event.addListener(	new_marker, 'click', function() { 
			// Here we'll iterate through the array and close all info windows.
			for (var i=0; i<infoWindowArray.length; i++) { infoWindowArray[i].close(); };
				new_infowindow.open(map,new_marker);    
			});
    }

	

   
</script>




<?php //Connect to your mysql server
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');if (!$con)  {  die('Could not connect: ' . mysql_error());  }
mysql_select_db("hacktus", $con);
$sql="SELECT * FROM Events"; //Create a Query to select all rows in the table Events
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) //Iterate all rows in query results. Each row will be an event
  {
  echo "<tr>";
  echo "<td><a href='". $row['Name_URL'] ."'>" . $row['Name'] . "</a></td>";
  echo "</tr>";
  //Populate the javascript event arrays
	echo "<script>	eventAddressArray.push(\"" . $row['Address'] . "\"); </script>";
  }

mysql_close($con);
?>