<?php
	// Get the inputs from the URL
	
	$location = "37.547030-122.314834"; // Hardcoded to San Mateo for now
	$radius = "60"; // Hardcoded for now (SF Bay Only
	
	// Hardcoded
	$key = AIzaSyA7h2gfsqbEKPY6fAhJ3lA4-QYR9bI9sFc //
	
	
	// old location values
//	$location=520+3rd+Street+San+Francisco+CA
	/*** REMEMBER to use your own Application ID ***/
	$appid = "hactus";
	// original URL:
	// https://maps.googleapis.com/maps/api/place/search/json?location=-33.8670522,151.1957362&radius=500&types=food&name=harbour&sensor=false&key=AIzaSyAiFpFd85eMtfbvmVNEYuNds5TEF9FjIPI
	$placesAPIurl = "https://maps.googleapis.com/maps/api/place/search/json?"
		. "location=" . $location
		. "&radius=" . $radius;
		. "&types=" . $searchTerm;
		. "&sensor=" . $false;
		. "&key=" . $key;
	// Create cUrl object to grab XML content using $placesAPIurl
	$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $placesAPIurl);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($c);
		curl_close($c);
		$data = unserialize($output);
	echo $data["ResultSet"]["Result"]["Latitude"] . "," . $data["ResultSet"]["Result"]["Longitude"];
//	echo "lon was  " .	$data["ResultSet"]["Result"]["Longitude"];
?>