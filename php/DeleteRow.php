
<?php 

    $tableName      = htmlspecialchars(trim($_POST['tableName']));  
	$rowKey			= htmlspecialchars(trim($_POST['rowKey'])); 
	echo "tablename and rowkey were .." . $tableName . ", " . $rowKey;
	// Connect to MySQL
	$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
	if (!$con)  {  die('Could not connect: ' . mysql_error());  }
	mysql_select_db("hacktus", $con);

	// First, make a backup.
	// Skip LULZ

	//	if (!mysql_query($query,$con))    die('Error: ' . mysql_error());	
	// NOT WORKING
	$result = mysql_query("SELECT Name FROM $tableName
	");

	while($row = mysql_fetch_array($result))
	{
		if ($row['Key'] == $rowKey)
			$Name = $row['Name'];
		
	}

	$sql="DELETE FROM $tableName
		WHERE `key` = '$rowKey'";
		if (!mysql_query($sql,$con))  {  die('Error: ' . mysql_error());  }
	echo "Something got deleted .... I wonder what it was? probably this: " . $Name;
    	// END MySQL
  	mysql_close($con);

        // Notes:

?>