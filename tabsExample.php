
<!DOCTYPE html> 
<html lang="en"> 
<head> 
	<meta charset="utf-8"> 
	
	<script type="text/javascript" src="http://www.fractalgames.com/bin/tablesorter/jquery-latest.js"></script> 
	
	<!--References for jquery tablesorter (functionality for sorting tables). See http://tablesorter.com for details. -->
	<LINK rel="stylesheet" href="http://www.fractalgames.com/bin/tablesorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
	<script type="text/javascript" src="http://www.fractalgames.com/bin/tablesorter/jquery.tablesorter.js"></script> 
	
	<title>jQuery UI Tabs - Default functionality</title> 
	<!-- CVN 13-July - Additional JQuery tabs stylehseets from http://jqueryui.com/demos/tabs/ -->
	<link rel="stylesheet" href="http://jqueryui.com/demos/demos.css"> 
	<link rel="stylesheet" href="http://jqueryui.com/themes/base/jquery.ui.all.css"> 
	
	<!-- CVN 13-July - Additional JQuery tabs scripts -->
	<script src="http://jqueryui.com/ui/jquery.ui.core.js"></script> 
	<script src="http://jqueryui.com/ui/jquery.ui.widget.js"></script> 
	<script src="http://jqueryui.com/ui/jquery.ui.tabs.js"></script> 
	<script> 
	
	$(function() {
		$( "#tabs" ).tabs();
	});
	
	$(document).ready(function(){    	
			$("#myTable").tablesorter(); //sort table when document is loaded

			$("table").tablesorter({ 
				// enable debug mode 
				debug: true 
			}); 
		});    

	</script> 
</head> 
<body> 
 
<div class="demo"> 
 
<div id="tabs"> 
	<ul> 
		<li><a href="#tabs-1">Events</a></li> 
		<li><a href="#tabs-2">Hacker Spaces</a></li> 
		<li><a href="#tabs-3">Co-working Spaces</a></li> 
		<li><a href="#tabs-4">Incubators</a></li> 
	</ul> 
<div id="tabs-1"> 
<div id="official">
<table id="events-feed" summary="Upcoming Events Feed" class="tablesorter"> 
	<thead> 
		<tr> 
			<th scope="col" align="center" width=42%>Event</th> 
			<th scope="col" width=138px>Date</th> 
			<th scope="col">Time</th> 
			<th scope="col" align="center">Location</th> 
			<th scope="col" align="center">Source</th> 
		</tr> 
	</thead> 
	<tbody> 
	<?php 
		$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');if (!$con)  {  die('Could not connect: ' . mysql_error());  }
		mysql_select_db("hacktus", $con);
		
		$sql="SELECT * FROM Events ORDER BY Date ASC"; //Create a Query to select all rows in the table Events
		$result = mysql_query($sql);
		
		$i=0;
		while($row = mysql_fetch_array($result)) //Iterate all rows in query results. Each row will be an event
		{
			// Display a new HTML row with each new $row
			echo "<tr class=\"d".($i & 1)."\">";
				echo "<td><a href='". $row['Name_URL'] . "' target=\"_blank\">"  . $row['Name'] . "</a></td>";
				echo "<td>" . date( 'D d M Y', strtotime($row['Date'])) . "</td>";   // dates: http://php.net/manual/en/function.date.php
				echo "<td>" . date( 'h:i A', strtotime($row['Date'])) . "</td>"; 
				if (strlen($row['Address'] > 2))
					echo "<td><a href='" . $row['Location_URL'] . "' target=\"_blank\">"  . $row['Address'] . ", " . $row['CityState'] . "</a></td>";
 				else echo "<td><a href='". $row['Name_URL'] ."'> See event page </a></td>";
				//  <a href="http://www.quackit.com/html/html_help.cfm" target="_blank">HTML Help</a>
				echo "<td>" . $row['Source'] . "</td>"; // Source may not be displayed to users?
			echo "</tr>";
			$i++;

 			//Populate the javascript event arrays [5]			
 			echo "<script>	addressArray[5].push(\"" 		. $row['Address'] 			. "\"); </script>";
			echo "<script>	nameArray[5].push(\"" 			. $row['Name'] 				. "\"); </script>";
			echo "<script>	nameUrlArray[5].push(\"" 		. $row['Name_URL'] 			. "\"); </script>";
			echo "<script>	descriptionArray[5].push(\"" 	. $row['Description'] 		. "\"); </script>";	
			echo "<script>	phoneNumberArray[5].push(\"" 	. $row['Phone'] 			. "\"); </script>";
			echo "<script>	latArray[5].push(\"" 			. $row['Lat'] 				. "\"); </script>";
			echo "<script>	lngArray[5].push(\"" 			. $row['Lng'] 				. "\"); </script>"; 	
			echo "<script>	costArray[5].push(\"" 			. $row['Cost'] 				. "\"); </script>";

		}

	mysql_close($con);
	?>
	</tbody>
</table> 
</div>
</div> 
<div id="tabs-2"> 
	<p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p> 
</div> 
<div id="tabs-3"> 
	<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p> 
	<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p> 
</div> 
</div> 
 
</div><!-- End demo --> 
 
 
 
 
 
<div class="demo-description"> 
<p>Click tabs to swap between content that is broken into logical sections.</p> 
</div><!-- End demo-description --> 
 
</body> 
</html> 