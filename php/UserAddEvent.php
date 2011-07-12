
<?php 

	$Name = 		htmlspecialchars(trim($_POST['Name']));
	$Name_URL = 	htmlspecialchars(trim($_POST['Name_URL']));
	$Date = 		htmlspecialchars(trim($_POST['Date']));
	$Address1 =	 	htmlspecialchars(trim($_POST['Address1']));
	$CityState = 	htmlspecialchars(trim($_POST['City'])) . ", CA";
	$VenueName = 	htmlspecialchars(trim($_POST['Address1']));
	$Description =  htmlspecialchars(trim($_POST['Description']));
	
	// Hardcode some values for EZ-testing.
	$Address1 = "16 Glenwood";
	$City = "Hercules";
	
	// We'll need to cURL the Yahoo maps API to get LatLng
	// ************************************		
	// BEGIN cURL
	$appid = "hactus";
	$geourl = "http://local.yahooapis.com/MapsService/V1/geocode?appid=$appid"
	. "&location=" . $Address1 . "+" . $City . "+" . $State
	. "&output=php";

	// Create cUrl object to grab XML content using $geourl
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $geourl);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($c);
	curl_close($c);
	$data = unserialize($output);
	
	// Finally, set the Latitude, Longitude, LatLng, and Location URL
	$Lat = $data["ResultSet"]["Result"]["Latitude"];
	$Lng = $data["ResultSet"]["Result"]["Longitude"];
	$LatLng = $Lat . " " . $Lng;
	$Location_URL = 'http://maps.google.com/maps?q=' . $Lat . $Lng;
	// END cURL 
    // *********************************** 
    

    // *********************************** 
	// BEGIN MySQL
	// Connect to MySQL using values passed thru url when this php file is called
	$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
	if (!$con)  {  die('Could not connect: ' . mysql_error());  }

	mysql_select_db("hacktus", $con);		
			
	// Descriptions are often too long so let's truncate the string:
	// $Description = substr ( $Description_long , 0 , 499 );
	// Not working. Let's set description manually for now.
	$Description = 'test';
	$Cost = '0';
	$sql=
		"INSERT INTO 
			Events 
			(
				Name, 
				Name_URL,
				Date,
				Address1
				CityState,
				LatLng,
				Location_URL,
				VenueName,
				Description,
				Cost,
				Source
			)
			VALUES	
			(					
				'$Name', 
				'$Name_URL',
				FROM_UNIXTIME('$Date'),
				'$Address1',
				'$CityState',
				'$LatLng',
				'$Location_URL',
				'$VenueName',
				'$Description',
				'$Cost',
				'User'
			)
		";
		if (!mysql_query($sql,$con))  {  die('Error: ' . mysql_error());  }
      	echo "User entered stuff ( " . $data["results"][$i]["name"] . " was posted to MySQL table " . $tableName . " ...";
	}   	 */
   	// END MySQL
    // ***********************************        

        // Notes:
        // I <3 Coding
		// Unix timestamp needs to be divided by 1000 to lop off the last three 0s (why Meetup needs its time in MS is beyond me), then converted to a readable format


        
?>