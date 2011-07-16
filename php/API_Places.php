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
?>se"
		. "&key=" . $key;
		
	$placesAPIurl = "https://maps.googleapis.com/maps/api/place/search/json?location=37.547030,-122.314834&radius=500&types=food&name=harbour&sensor=false&key="+$key;

	// Create cUrl object to grab XML content using $placesAPIurl
	$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $placesAPIurl);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($c);
		curl_close($c);
		
	// Format the Curled output into an array that php can read
	$data = json_decode($output);
	echo 'Data was ........ ' +$data;
	echo 'output was ........ ' +$output;
	
	// Iterates through the array, pulling $i results each time,

	
	// MySQL
	// Now that we've got an array from Places API, connect to MySQL and post the results to $tableName.
	

	
	// Connect to the database
	$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
		if (!$con)  {  die('Could not connect: ' . mysql_error());  }
	
		mysql_select_db("hacktus", $con);
			




	// First, delete any old entries from Places API. **This might not be needed with INSERT IGNORE if there is a unique key**
	/*
	$sql="DELETE FROM $tableName
			WHERE Source = ('Places_API') and SearchTerm = ('$typeToSearch')"; // NOTE: Need to add 2 fields in MySQL for sources (typeToSearch and nameToSearch)
			if (!mysql_query($sql,$con))  {  die('Error: ' . mysql_error());  }
			*/
			
			
			
			


	// Post each result to the MySQL $tableName
		// Iterates through the array, pulling $i results each time,
		for ($i = 0; $i<count($data[results]); $i++) 
		{
			
			// This Echos the "unknown" results in the format  Name,Lat,Lng (all other results are already "known" because they're inputs or derivative of these 3)
			echo $data[results][$i][name] . "," .
			$data[results][$i][geometry][location][lat] . "," .
			$data[results][$i][geometry][location][lng];
		
		
		
			$Name = $data[results][$i][name];
				$Name = str_replace('\'', '', $Name);		 // sometimes ' character makes big errors. Why only sometimes? ... php ..damn u
			// Can we get Name URL from API?
			// $Name_URL = $data[events][$i][event][url];

			// Can we get Address from the API or from the LatLng?
			// $Address = $data[results][.....address]; 
			// $CityState = $data[events][$i][event][venue][city] . ' ' . $data[events][$i][event][venue][region];

			$Lat = $data[results][$i][geometry][location][lat];
			$Lng = $data[results][$i][geometry][location][lng];						
			$Location_URL = 'http://maps.google.com/maps?q=' . $data[results][$i][geometry][location][lat] . "," . $data[results][$i][geometry][location][lng];


			//Can we get description?
			$Description_long = $data[events][$i][event][description];
			$Description_long = str_replace('\'', '', $Description_long);		 // sometimes ' character makes big errors. Why only sometimes? ... php ..damn u
			// Descriptions are often too long so let's truncate the string:
			// $Description = substr ( $Description_long , 0 , 499 );
			// Not working. Let's set description manually for now.
			$Description = $Description_long;
			
			// Probably need to manually enter cost ... bugger.
			// $Cost = $data[events][$i][event][tickets][0][ticket][price];
			$source = "API_Places";
			
			// Can we get UniqueID from this API? What can we use for UniqueID? LatLng could work. 
			// $UniqueID = $data[results .... ?];
			
			// Make the INSERT into the MySQL for all this data at once, one $i row at a time:
			
			// So far, we really just have Name and Lat Lng ...  and the source and search terms.
				$sql=
				"INSERT IGNORE INTO 
					$tableName 
					(
						Name, 
						Lat,
						Lng,
						Location_URL,
						SearchTermName,						
						SearchTermType,
						Source
					)
					VALUES	
					(
						'$Name',
						'$Lat',
						'$Lng',
						'$Location_URL',
						'$nameToSearch',
						'$typeToSearch',
						'$source'
					)
				";

				if (!mysql_query($sql,$con))  {  die('Error: ' . mysql_error());  }

  	      		// echo $data[events][$i][event][name] . " posted!<br>";
			
		}   	 
    	// END MySQL
        // Notes:
        // This file is VERY incomplete. Are we getting all we can from the API? 
        
        mysql_close($con);
?>