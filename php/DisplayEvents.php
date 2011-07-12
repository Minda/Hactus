<?php
	$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');if (!$con)  {  die('Could not connect: ' . mysql_error());  }
	mysql_select_db("hacktus", $con);
	$sql="SELECT * FROM Events";
		$result = mysql_query($sql);
		$i=0;
		while($row = mysql_fetch_array($result))
		{
			echo "<tr class=\"d".($i & 1)."\">";
			echo "<td><a href='". $row['Name_URL'] ."'>" . $row['Name'] . "</a></td>";
			echo "<td>" . date( 'D d M Y', strtotime($row['Date'])) . "</td>";   //REFerence for date formatting: http://php.net/manual/en/function.date.php
			echo "<td>" . date( 'h:i A', strtotime($row['Date'])) . "</td>"; 
			echo "<td><a href='". $row['Location_URL'] ."'>"  . $row['Location'] . "</a></td>";
			echo "<td>" . $row['Description'] . "</a></td>";
			echo "</tr>";
		
			// Let's populate the Event arrays.
			// someArray[5] == Events
			echo "<script>	addressArray[5].push(\"" 		. $row['Address'] 			. "\"); </script>";
			echo "<script>	nameArray[5].push(\"" 			. $row['Name'] 				. "\"); </script>";
			echo "<script>	nameUrlArray[5].push(\"" 		. $row['Name_URL'] 			. "\"); </script>";
			echo "<script>	descriptionArray[5].push(\"" 	. $row['Description'] 		. "\"); </script>";	
			echo "<script>	phoneNumberArray[5].push(\"" 	. $row['Phone'] 			. "\"); </script>";
			echo "<script>	costArray[5].push(\"" 			. $row['Cost'] 				. "\"); </script>";
			echo "<script>	latArray[5].push(\"" 			. $row['Lat']	 			. "\"); </script>";
			echo "<script>	lngArray[5].push(\"" 			. $row['Lng']	 			. "\"); </script>";			
			$i++;
		}	
		
		
	mysql_close($con);
?>

