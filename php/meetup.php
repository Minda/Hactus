
<?php 
/*

[ About this document ]

This calls the meetup API and does a search based on $searchTerm you passed in. Then it populates the $tableName with the results.

What meetup search terms should we enlist? We will do this externally and call this php file for each new search term (best way? who cares? PHP LULZ)
It turns out you CAN'T do multpile search terms in a single API call, because if meetup returns even *one* null search result, the entire JSON_DECODE 
string fails (JSON DECODE will return null.) So, to solve this I simply call this file once for each search term (slower and more API calls. Thansk json_decode. 
Ahh... I need a better MYSQL setup.

Some search terms I like to pass in (for reference):
startups, startup, entrepreneur, entrepreneurs, entrepreneurship, incubator, investor, pitch, hacker, hackers, founder, founders, cofounder, co-founder, tech, technology, networking

Note: No Geocoding is necessary for Events because meetup API provides lat lng.
*
*/

		// [ Step 0 ]: Get the relevant variables for search and tables
		// Set variables from items passed thru URL
		$searchTerm   	= htmlspecialchars(trim($_POST['searchTerm']));
		$zip	      	= htmlspecialchars(trim($_POST['zip']));  		
		$radius      	= htmlspecialchars(trim($_POST['radius']));  
	    $tableName      = htmlspecialchars(trim($_POST['tableName']));  
		$source			= htmlspecialchars(trim($_POST['source'])); 
		
		// Manually reset the variables for now
		// $searchTerm 	= "startups";
		$zip 			= 94404;
		$radius 		= 35;
	 	$tableName      = "Events";
	 	
		$key			= "01a6b1d2c7a6d4633705771682f5325"; // Hardcoded - do not pass with JS (insecure)
		$source 		= "Meetup";


		// BEGIN cURL
		// [  Step 1  ]: First, we do a search on the meetup API according to some values we passed to PHP
        // create curl resource 
        $ch = curl_init(); 
        
        // set url. This is the API call.
        curl_setopt($ch, CURLOPT_URL,
	        "https://api.meetup.com/2/open_events.json?"
				. "key=" . $key
				. "&sign=true"
				. "&topic=" . $searchTerm
				. "&zip=" . $zip
				. "&radius=" . $radius
				. "&time=0,1m"
   	     );
        
//        echo "searchTerm was " . $searchTerm;
        
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);   
        
        // Duplicated comment -- Why we only search for one term at a time
        // If the json_decode begins returning NULL, it could be because 
        // you searched for &topic=topic1,topic2,....topicN, and topicX was == null, so it destroys the entire JSON array. 
        // Lovely. This means you can forget about searching for multiple terms in a single API call for Meetup... instead,
        // Make the API call each time for each individual topic, so if any search term returns null, it doesn't drop the other results.
        // Gotta love json_decode's fragility. Thanks to whoever wrote that POS.
        
        // Converts the JSON output into a PHP-readable Array
        $data = json_decode($output, true);


		// echo "data was " . $data . " ........" ;
		// echo "data LENGTH was " . count($data["results"]);
		// echo "output was " . $output . " ........" ;
		
		// END cURL 




		// BEGIN MySQL
		// [  Step 2  ]: After getting those results, let's post them to MySQL

		// Connect to MySQL		
		$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
		if (!$con)  {  die('Could not connect: ' . mysql_error());  }
	
		mysql_select_db("hacktus", $con);
		
		// Since we are populating from "Meetup", let's clear any Meetup events before populating them again (to prevent duplication and get rid of events that have passed or were deleted.) 
		// Update: This may be unnecessary because of INSERT IGNORE, but I'm leaving it in for now.
		$sql="DELETE FROM Events
		WHERE Source = ('Meetup') and SearchTerm = ('$searchTerm')";
		if (!mysql_query($sql,$con))  {  die('Error: ' . mysql_error());  }
		
		// The cool fun part!
		// Iterates through the array, pulling $i results each time,
		for ($i = 0; $i<count($data["results"]); $i++) 
		{
			$Name = $data[results][$i][name];
				$Name = str_replace('\'', '', $Name);		 // sometimes ' character makes big errors. Why only sometimes? ... php ..damn u

			$Name_URL = $data[results][$i][event_url];
			$Date = $data[results][$i][time]/1000; // Meetup API gives date in Unix time with miliseconds ... go figure. Divide by 1000 to get seconds.
				// $Date = date("Y-m-d H:i:s", $timestamp);

			$Address1 = $data[results][$i][venue][address_1];
			$CityState = $data[results][$i][venue][city] . ' ' . $data[results][$i][venue][state];
			$LatLng = $data[results][$i][venue][lat] . ',' 	. $data[results][$i][venue][lon];						
			$Location_URL = 'http://maps.google.com/maps?q=' . $data[results][$i][venue][lat] . "," . $data[results][$i][venue][lon];
			$VenueName = $data[results][$i][venue][name];
				$VenueName = str_replace('\'', '', $VenueName);		 // sometimes ' character makes big errors. Why only sometimes? ... php ..damn u	

			$Description_long = $data[results][$i][description]; 
				// Descriptions are often too long so let's truncate the string:
				// $Description = substr ( $Description_long , 0 , 499 );
				// Not working. Let's set description manually for now.
				$Description = 'test';

			$Cost = '0';
			$UniqueID = $data[results][$i][id]; 
			
			
			// Trim inputs
			// We might need to tri=m some of the values, but I'm not doing this for now.
			// echo "searchTerm was " . $searchTerm . "|| ";
			// $VenueName = trim($VenueName,"\x22\x27");
			// $Name = trim($Name,"\x22\x27");
			// $Location_URL = trim($Location_URL,"\x22\x27");
			
			
			// Some of the dates are too far in the future, so we'll have to check for those and only populate events for the next two weeks.
			// Not currently working / I created another php file to strip all events not falling within 2 weeks (since Meetup is just one source anyway, no reason to include this code here.
			/*
			$today = date(U);
			echo "todays dateTime was ";
				echo $today;
				echo " events dateTime was ";
				echo $Date;
				echo " diff was " . $Date - $today . "<br>|||||   ";
			if ($Date - $today < 2 * 7 * 24 * 60 * 60) // = Two weeks in seconds
			*/
		
			// Make the INSERT IGNORE into the MySQL for all this data at once, one $i row at a time:
			// IGNORE should make the query skip duplicate entries
				$sql=
				"INSERT IGNORE INTO 
					$tableName 
					(
						Name, 
						Name_URL,
						Date,
						Address,
						CityState,
						LatLng,
						Location_URL,
						VenueName,
						Description,
						Cost,
						Source,
						SearchTerm,
						UniqueID
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
						'$source',
						'$searchTerm',
						'$UniqueID'
					)
				";

				if (!mysql_query($sql,$con))  {  die('Error: ' . mysql_error());  }

//  	      		echo $data["results"][$i]["name"] . " posted!<br>";
			}
			
    	// END MySQL
    	mysql_close($con);

        // Notes:

?>     // Notes:

?>