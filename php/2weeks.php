<?php  
  
	// This file will "clean"  a table by deleting any row with a ['Date'] farther out than 2 weeks from today.
	// It also deletes any dates in the past.
	
	// Get the tablename to clean
	$tableName  = htmlspecialchars(trim($_POST['tableName']));

	$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
	if (!$con)  {  die('Could not connect: ' . mysql_error());  }
	
	mysql_select_db("hacktus", $con);

 
	$sql="SELECT * FROM $tableName"; //Create a Query to select all rows in the table Events
	$result = mysql_query($sql);
	$i=0;
	while($row = mysql_fetch_array($result)) //Iterate all rows in query results. Each row will be an event
	{
		// Delete the $row  IF...
		if  ( (strtotime($row['Date']) >= time() + 2 * 7 * 24 * 60 * 60)  // If the event is more than 2 weeks in the future
			|| (strtotime($row['Date']) < time()) )						// OR If the event is in the past
		{
			$Date = $row['Date'];
			$deleteDate="DELETE FROM Events
			WHERE Date = '$Date'";
			if (!mysql_query($deleteDate,$con))  {  die('Error: ' . mysql_error());  }
			echo "...deleted row where date was " . $row['Date'];
		}
	}
	mysql_close($con);
?>  