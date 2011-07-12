<?php

	// Get the inputs from the URL
	$location = htmlspecialchars(trim($_POST['location']));
	$location = str_replace(" ","+",$location);
	// old location values
//	$location=520+3rd+Street+San+Francisco+CA
	/*** REMEMBER to use your own Application ID ***/
	$appid = "hactus";
	$geourl = "http://local.yahooapis.com/MapsService/V1/geocode?"
		. "appid=" . $appid 
		. "&location=" . $location
		. "&output=php";
	// Create cUrl object to grab XML content using $geourl
	$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $geourl);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($c);
		curl_close($c);
		$data = unserialize($output);
	echo $data["ResultSet"]["Result"]["Latitude"] . "," . $data["ResultSet"]["Result"]["Longitude"];
//	echo "lon was  " .	$data["ResultSet"]["Result"]["Longitude"];
?>




