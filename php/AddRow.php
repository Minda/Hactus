<?php


	// First let's get the variables passed in from the Ajax call:

	$beds = htmlspecialchars(trim($_POST['beds']));
	$address = htmlspecialchars(trim($_POST['address']));
	$rent = htmlspecialchars(trim($_POST['rent']));
	$link = htmlspecialchars(trim($_POST['link']));

	// Sanitize the inputs
	
	function cleanInput($input) {

		$search = array(
			'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
			'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
			'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
			'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	  	);

	    $output = preg_replace($search, '', $input);
	    return $output;
  	}
  	
  	$beds = cleanInput($beds);
	$address = cleanInput($address);
	$rent = cleanInput($rent);
	$link = cleanInput($link);  	


	// Connect to the database

	$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
	if (!$con)  {  die('Could not connect: ' . mysql_error());  }
	mysql_select_db("hackerhouse", $con);
	
	// $table = "HackerHouse";

	// $sql="SELECT * FROM WebformEntries";

		
//		$key = htmlspecialchars(trim($_POST['key']));
	
		// echo "alert(\'" . $post . "\')";
	$query="INSERT INTO Locations (Beds, Rent, Address, Link)
				VALUES ('$beds', '$rent', '$address', '$link')";
		if (!mysql_query($query,$con))    die('Error: ' . mysql_error());				
	mysql_close($con);
?>