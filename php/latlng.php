<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> <HTML>
<title>hactus - the Cheat Sheet for Entrepreneurs</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<head>
<link rel="stylesheet" type="text/css" href="hactus.css" />
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script> -->
<!-- My attempt at custom toggle checkbox with Jquery. It works!! Yay -->
<script type="text/javascript" src="http://www.fractalgames.com/bin/tabcontent.js"></script>
<script type="text/javascript" src="http://www.fractalgames.com/bin/jquery.js"></script>

<!-- Google maps javascript stuff -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&amp;libraries=places"></script> 
<script>	// Search Logic

var str = "text-345-3535"
var arr = str.split(/-/g).slice(1);
Try it out: http://jsfiddle.net/BZgUt/

This will give you an array with the last two number sets.

If you want them in separate variables add this.

var first = arr[0];
var second = arr[1];

</script>

<script>
	// Let's make some arrays for the PHP to dump into so we can deal with them "locally".
	var latArray = new Array ( );

	var lngArray = new Array ( );

	var addressArray = new Array ( );
	
	function initialize() {
		geocoder = new google.maps.Geocoder(); // Should not need to geocode anything here
		geocoder.geocode( { 'address': address}, function(results, status) {
      	if (status == google.maps.GeocoderStatus.OK) {
        latLng = results[0].geometry.location);
        });
	}
		   
</script>

// sTEPS:
// Get address from $_POST
// Get LatLng from GeoCoder
// Split LatLng into Lat and Lng
// Insert Lat and Lng back into table







// *********************************************** PHP// *********************************************** PHP// *********************************************** PHP
<?php 

		$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
		if (!$con)  {  die('Could not connect: ' . mysql_error());  }
		mysql_select_db("hacktus", $con);				

		$table   	= htmlspecialchars(trim($_POST['table']));

		$sql="SELECT * FROM $table";
			$result = mysql_query($sql);
	
			//Iterate all rows in query results. Each row will be an event
			$i = 0;
			while($row = mysql_fetch_array($result))
			{
				// This will populate the local arrays with MySQL data for Hackerspaces..
				// "[0] == Hackerspaces"
				mysql_query("UPDATE $table SET Lat = 
				WHERE $result = $result");
				$address[$i] = $row['Address'];
				$i++;
			} 
			if (!mysql_query($sql,$con))  {  die('Error: ' . mysql_error());  }

//			or die(mysql_error());  
		// GEOCODING MAGIC. 

		$appid = "hactus";
		$geourl = "http://local.yahooapis.com/MapsService/V1/geocode?appid=$appid&location=" . 
			$Address_number . 
			$City .
			$State .
			"&output=php";
		// 520+3rd+Street+San+Francisco+CA&output=php";


		// Create cUrl object to grab XML content using $geourl
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $geourl);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($c);
		curl_close($c);
		$data = unserialize($output);
		
		echo "lat was  " .	$data["ResultSet"]["Result"]["Latitude"];
		echo "lon was  " .	$data["ResultSet"]["Result"]["Longitude"];

        // *********************************** 
		// BEGIN MySQL
		// Connect to MySQL using values passed thru url when this php file is called
		


		}   	 
    	// END MySQL
        // *********************************** 

        // Notes:
		// Unix timestamp needs to be divided by 1000 to lop off the last three 0s (why Meetup needs its time in MS is beyond me), then converted to a readable format


        
?>