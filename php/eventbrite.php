
<?php 
/*

[ About this document ]

Since the EventBrite API supports "OR" searches, we will pass the entire array into this PHP file and search all terms with just one call.

This calls the EventBrite API and does a search based on $searchTerms you passed in. Then it populates the $tableName with the results.

What do I want this PHP file to do?
It should:
1) Clear events that have already passed
	Done
2) Pack new events into the database up to a certain date
	not done - need to check date
3) Do NOT remove events that haven't happened yet that are gotten from the other sources (e.g. meetup)
	Done - use INSERT IGNORE

 What meetup search terms should we enlist? We will do this externally and call this php file for each new search term (best way? who cares? PHP LULZ)

startups, startup, entrepreneur, entrepreneurs, entrepreneurship, incubator, investor, pitch, hacker, hackers, founder, founders, cofounder, co-founder, tech, technology, networking

What table would we put this under?
$tableName
   
We also need to geocode each of these? NOPE -- LAT LNG IS GIVEN!!! BY API!! SWEET

*
*/

	// Make an array to hold the search terms. NOT working. Let's move this loop to console.php?
	// $searchArray = array("startups", "startup", "entrepreneur", "entrepreneurs", "entrepreneurship", "incubator", "investor", "pitch", "hacker", "hackers", "founder", "founders", "cofounder", "co-founder", "tech", "technology", "networking");

		// Step 0: Get the relevant variables for search and tables
		// Set variables from items passed thru URL
		$searchTerm   	= htmlspecialchars(trim($_POST['searchTerm']));
//		$zip	      	= htmlspecialchars(trim($_POST['zip']));  		
//		$radius      	= htmlspecialchars(trim($_POST['radius']));  
//	    $tableName      = htmlspecialchars(trim($_POST['tableName']));  
		$source			= htmlspecialchars(trim($_POST['source'])); 
		
		// Manually set the variables because we didn't pass any thru URL yet
		// $searchTerm 	= "startups";
		$zip 			= 94404;
		$radius 		= 35;
	 	$tableName      = "Events";
	 	$app_key		= "YjY4MjY2ZjhkZWJm";
		$user_key		= "12731858564462303871"; // Hardcoded - do not pass with JS
		$source 		= "EventBrite";


		// BEGIN cURL
		// [  Step 1  ]: First, we do a search on the meetup API according to some values we passed to PHP
        // create curl resource 
        $ch = curl_init(); 
        
        // set url. This is the API call. We'll use a Switch here to pick Eventbrite Meetup or another API.
        curl_setopt($ch, CURLOPT_URL,
        	"http://www.eventbrite.com/json/event_search?" 
			. "app_key=" . $app_key
			. "&user_key=" . $user_key
			. "&keywords=" . $searchTerm
			. "&within=" . $radius
			. "&postal_code=" . $zip
			. "&date=This+month" // Need to change this to "the next two weeks"
//			. "&tracking_link=HACTUS"
		);
		
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);   
        
        // Converts the JSON output into a PHP-readable Array
        $data = json_decode($output, true);

		echo 'eventbrite curl success, data was ' . $data;		
		echo "eventbrite curl success, output was " . $output;
		// END cURL 




	 	function tstamptotime($tstamp) {
			// converts ISODATE to unix date
    	    // 1984-09-01T14:21:31Z
			sscanf($tstamp,"%u-%u-%u %u:%u:%u",$year,$month,$day,
			$hour,$min,$sec);
			$newtstamp=mktime($hour,$min,$sec,$month,$day,$year);
			return $newtstamp;
	    }                   


		// BEGIN MySQL
		// [  Step 2  ]: After getting those results, let's post them to MySQL
		// Connect to MySQL using values passed thru url when this php file is called
		
		$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
		if (!$con)  {  die('Could not connect: ' . mysql_error());  }
	
		mysql_select_db("hacktus", $con);
		
		// Clear previous EventBrite sourced events with the same search term.
		$sql="DELETE FROM Events
		WHERE Source = ('Eventbrite') and SearchTerm = ('$searchTerm')";
		if (!mysql_query($sql,$con))  {  die('Error: ' . mysql_error());  }

		// Iterates through the array, pulling $i results each time,
		for ($i = 0; $i<count($data["events"]); $i++) 
		{
			$Name = $data[events][$i][event][title];
				$Name = str_replace('\'', '', $Name);		 // sometimes ' character makes big errors. Why only sometimes? ... php ..damn u

			$Name_URL = $data[events][$i][event][url];
			$Date = $data[events][$i][event][start_date]; // Given in  ISO 8601 format (e.g., ?2007-12-31 23:59:59?)
			$Date = tstamptotime($Date); // Conver to UNIX
//			$Date = date("Y-m-d H:i:s", $timestamp);
			$Address1 = $data[events][$i][event][venue][address];
			$Address2 = $data[events][$i][event][venue][address_2];
			$Address = $Address1 . " " . $Address2;
			$CityState = $data[events][$i][event][venue][city] . ' ' . $data[events][$i][event][venue][region];
			$LatLng = $data[events][$i][event][venue][latitude] . ',' 	. $data[events][$i][event][venue][longitude];						
			$Location_URL = 'http://maps.google.com/maps?q=' . $data[events][$i][event][venue][latitude] . "," . $data[events][$i][event][venue][longitude];
			$VenueName = $data[events][$i][event][venue][name];
				$VenueName = str_replace('\'', '', $VenueName);		 // sometimes ' character makes big errors. Why only sometimes? ... php ..damn u	
			$Description_long = $data[events][$i][event][description];
				$Description_long = str_replace('\'', '', $Description_long);		 // sometimes ' character makes big errors. Why only sometimes? ... php ..damn u
			// Descriptions are often too long so let's truncate the string:
			// $Description = substr ( $Description_long , 0 , 499 );
			// Not working. Let's set description manually for now.
			$Description = $Description_long;
			$Cost = $data[events][$i][event][tickets][0][price];
			$Source = 'Eventbrite';
			$UniqueID = $data[events][$i][event][id];
			
			
			// Strip any possible quotes out of these strings
			// echo "searchTerm was " . $searchTerm . "|| ";
			// $VenueName = trim($VenueName,"\x22\x27");
			// $Name = trim($Name,"\x22\x27");
			// $Location_URL = trim($Location_URL,"\x22\x27");
			
			
			// Some of the dates are too far in the future, so we'll have to strip those out. 
			$today = date(U);
			/*
			echo "todays dateTime was ";
				echo $today;
				echo " events dateTime was ";
				echo $Date;
				*/
				// echo " diff was " . $Date - $today . "<br>|||||   ";
			// if ($Date - $today < 2700000)
				


			
			// Make the INSERT into the MySQL for all this data at once, one $i row at a time:
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
						'$Address',
						'$CityState',
						'$LatLng',
						'$Location_URL',
						'$VenueName',
						'$Description',
						'$Cost',
						'$Source',
						'$searchTerm',
						'$UniqueID'
					)
				";

				if (!mysql_query($sql,$con))  {  die('Error: ' . mysql_error());  }

  	      		// echo $data[events][$i][event][name] . " posted!<br>";
			
		}   	 
    	// END MySQL
        // Notes:
        mysql_close($con);


?>/ END MySQL
        // Notes:
        mysql_close($con);


?>