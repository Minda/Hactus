<?php
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');if (!$con)  {  die('Could not connect: ' . mysql_error());  }
mysql_select_db("hacktus", $con);


	$sql="SELECT * FROM Hackerspaces";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			// This will display the hackerspace info on a table:
			echo "<tr>";
			echo "<td><a href='". $row['Name_URL'] ."'>" . $row['Name'] . "</a></td>";
			/*REFerence for date formatting: http://php.net/manual/en/function.date.php */
			echo "<td>" . $row['Phone'] . "</td>"; 
			//  echo "<td>" . date( 'h:i A', strtotime($row['Date'])) . "</td>"; 
			echo "<td><a href='". $row['Address_URL'] ."'>"  . $row['Address'] . "</a></td>";
			echo "</tr>";
		
		
		
			// This will populate the local arrays with MySQL data for Hackerspaces..
			// "[0] == Hackerspaces"
			echo "<script>	addressArray[0].push(\"" 		. $row['Address'] 			. "\"); </script>";
			echo "<script>	nameArray[0].push(\"" 			. $row['Name'] 				. "\"); </script>";
			echo "<script>	nameUrlArray[0].push(\"" 		. $row['Name_URL'] 			. "\"); </script>";
			echo "<script>	descriptionArray[0].push(\"" 	. $row['Description'] 		. "\"); </script>";	
			echo "<script>	phoneNumberArray[0].push(\"" 	. $row['Phone'] 			. "\"); </script>"; 
			echo "<script>	latArray[0].push(\"" 			. $row['Lat'] 				. "\"); </script>";
			echo "<script>	lngArray[0].push(\"" 			. $row['Lng'] 				. "\"); </script>"; 	
			
			
		}	
	mysql_close($con);
?>


