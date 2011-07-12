<?php
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');if (!$con)  {  die('Could not connect: ' . mysql_error());  }
mysql_select_db("hacktus", $con);


	$sql="SELECT * FROM CoworkingSpaces";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			echo "<tr>";
			echo "<td><a href='". $row['Name_URL'] ."'>" . $row['Name'] . "</a></td>";
			/*REFerence for date formatting: http://php.net/manual/en/function.date.php */
			echo "<td>" . $row['Phone'] . "</td>"; 
			//  echo "<td>" . date( 'h:i A', strtotime($row['Date'])) . "</td>"; 
			echo "<td><a href='". $row['Address_URL'] ."'>"  . $row['Address'] . "</a></td>";
			echo "</tr>";
		
			// Let's populate the hackerspace array with the addresses.
			// someArray[1] == Coworking
			echo "<script>	addressArray[1].push(\"" 		. $row['Address'] 			. "\"); </script>";
			echo "<script>	nameArray[1].push(\"" 			. $row['Name'] 				. "\"); </script>";
			echo "<script>	nameUrlArray[1].push(\"" 		. $row['Name_URL'] 			. "\"); </script>";
			echo "<script>	descriptionArray[1].push(\"" 	. $row['Description'] 		. "\"); </script>";	
			echo "<script>	phoneNumberArray[1].push(\"" 	. $row['Phone'] 			. "\"); </script>";
			echo "<script>	costArray[1].push(\"" 			. $row['Cost'] 				. "\"); </script>";
			echo "<script>	latArray[1].push(\"" 			. $row['Lat']	 			. "\"); </script>";
			echo "<script>	lngArray[1].push(\"" 			. $row['Lng']	 			. "\"); </script>";			
		}	
	mysql_close($con);
?>
