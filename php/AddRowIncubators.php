<?php


	// First let's get the variables passed in from the Ajax call:
	// Note: Consider doing a For loop with an array of the values to take care of this and the sanitizing?

	$name = htmlspecialchars(trim($_POST['name']));
	$deadline = htmlspecialchars(trim($_POST['deadline']));
	$demoDay = htmlspecialchars(trim($_POST['demoDay']));
	$address = htmlspecialchars(trim($_POST['address']));
	$cityState = htmlspecialchars(trim($_POST['cityState']));
	$terms = htmlspecialchars(trim($_POST['terms']));
	$cost = htmlspecialchars(trim($_POST['cost']));



	// Createa a nice wrapper function Sanitize the inputs	
	function cleanInput($input) {

		$search = array(
			'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
			'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
			'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
			'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
			
	  	);

	    $output = preg_replace($search, '', $input);
	    $output = str_ireplace("DROP","",$output);
	    $output = str_ireplace("DELETE","",$output);
	    $output = str_ireplace("UPDATE","",$output);
	    return $output;
  	}
  	
  	// Sanitizing ...
 	$name = cleanInput($name);
	$deadline = cleanInput($deadline);
	$demoDay = cleanInput($demoDay);
	$address = cleanInput($address);
	$cityState = cleanInput($cityState);
	$terms = cleanInput($terms);
	$cost = cleanInput($cost);
	
	$deadline = 	strtotime($deadline);
	$source = 'User';
	$IP = $_SERVER['REMOTE_ADDR'];


	// Connect to the database
	$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
	if (!$con)  {  die('Could not connect: ' . mysql_error());  }
	mysql_select_db("hacktus", $con);
	
	$query=
	"INSERT INTO Incubators 
		(
			Name,
			Deadline,
			DemoDay,
			Address,
			CityState,
			Terms,
			Price,
			Source,
			IP
		)
		VALUES 
		(
			'$name',
			'$deadline', 
			'$demoDay',
			'$address', 
			'$cityState',
			'$terms',
			'$cost',
			'$source', 
			'$IP'
		)";
	
	echo ".....something happened! A row for " . $name . "was added to INCUBATORS, and deadline was " . $deadline;






	if (!mysql_query($query,$con))    die('Error: ' . mysql_error());				
	mysql_close($con);
?>