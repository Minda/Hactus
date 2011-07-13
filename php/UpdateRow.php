
<?php
	
	
	// Get variables from JS

	$location = htmlspecialchars(trim($_POST['location']));
	$lat = htmlspecialchars(trim($_POST['lat']));
	$lng = htmlspecialchars(trim($_POST['lng']));
	$rowKey = htmlspecialchars(trim($_POST['rowKey']));
	//Connect to your mysql server
	$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
	if (!$con) die('Could not connect: ' . mysql_error());
  
	mysql_select_db("hacktus", $con);

	//Create a Query to select all rows in the table Events
	$query="UPDATE Incubators SET Lat = '$lat', Lng = '$lng'
			WHERE `key` = '$rowKey'";
	echo "UpdateRow called. Query was " . $query;
	if (!mysql_query($query,$con))    die('Error: ' . mysql_error());	
	mysql_close($con);
?>
   die('Error: ' . mysql_error());	
	mysql_close($con);
?>
