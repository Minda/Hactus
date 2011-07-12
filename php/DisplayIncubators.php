<?php
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');if (!$con)  {  die('Could not connect: ' . mysql_error());  }
mysql_select_db("hacktus", $con);


	$sql="SELECT * FROM Incubators";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			// This will display the incubators' info on a table:
			echo "<tr>";
			echo "<td><a href='". $row['Name_URL'] ."'>" . $row['Name'] . "</a></td>";
			/*REFerence for date formatting: http://php.net/manual/en/function.date.php */
			echo "<td>" . $row['Phone'] . "</td>"; 
			//  echo "<td>" . date( 'h:i A', strtotime($row['Date'])) . "</td>"; 
			echo "<td><a href='". $row['Address_URL'] ."'>"  . $row['Address'] . "</a></td>";
			echo "</tr>";
		
		
		
			// This will populate the local arrays with MySQL data for Incubators..
			// "[2] == Incubators
			echo "<script>	addressArray[2].push(\"" 		. $row['Address'] 			. "\"); </script>";
			echo "<script>	nameArray[2].push(\"" 			. $row['Name'] 				. "\"); </script>";
			echo "<script>	nameUrlArray[2].push(\"" 		. $row['Name_URL'] 			. "\"); </script>";
			echo "<script>	descriptionArray[2].push(\"" 	. $row['Description'] 		. "\"); </script>";	
			echo "<script>	phoneNumberArray[2].push(\"" 	. $row['Phone'] 			. "\"); </script>"; 
			echo "<script>	latArray[2].push(\"" 			. $row['Lat'] 				. "\"); </script>";
			echo "<script>	lngArray[2].push(\"" 			. $row['Lng'] 				. "\"); </script>"; 	
			
			
		}	
	mysql_close($con);
?>


