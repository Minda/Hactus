<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> <HTML>
<title>Hactus Console</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<head>
<link rel="stylesheet" type="text/css" href="console.css" />


<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script> -->
<!-- My attempt at custom toggle checkbox with Jquery. It works!! Yay -->
<script type="text/javascript" src="http://www.fractalgames.com/bin/tabcontent.js"></script>
<script type="text/javascript" src="http://www.fractalgames.com/bin/jquery.js"></script>
<script src="http://www.fractalgames.com/bin/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script> 
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  

    
    <script>
//	var searchTermArray = new Array("startup", "incubator", "investor", "pitch", "hacker", "hackers", "founder", "founders", "cofounder", "co-founder", "tech", "technology", "networking", "entrepreneur", "ios");
    var searchTermArray = new Array("technology", "ios", "founders", "startups", "startup");
//     var searchTermArray = new Array("hiking");
	var meetup = "meetup";
//	var keywords = "";
    var latLng = "123,456";
    var splitLatLng;
    
    
    function WaitForSeconds(millis) 	{	var date = new Date();	var curDate = null;
		do { curDate = new Date(); } 		while(curDate-date < millis);
	}


	
    
	function GetLatLng(rowKey, location) {

    	$.ajax({
            type: "POST",  
            url: "/php/Geocoder.php",  
            data: "tableName=" + "Incubators"
            	+ "&rowKey=" + rowKey 
            	+ "&location=" + location,
            success: function(data){  
                alert('Success! Got LatLng..... latLng was:'+data);
                latLng = data;
               	splitLatLng = latLng.split(",");
            }
        });
        
		alert ('rowkey was '+rowKey+' location was '+location);
        // Give the above function time to complete.
	}
	
	function SetLatLngIncubators(rowKey) {
        	
    	$.ajax({
            type: "POST",  
            url: "/php/UpdateRow.php",  
            data: "tableName="+ "Incubators"
            	+ "&rowKey=" + rowKey 
            	+ "&lat=" + splitLatLng[0]
            	+ "&lng=" + splitLatLng[1],
            success: function(data){  
                alert('Success! Updated Lat Lng in Table Incubators..... '+data);
//				window.location.reload();                
            }  
        });        
        
          
	}	
	

	
	
	
	
	
	
	    
	    
	function AddRowIncubators(form) {
		// First we need to change the date format.
//		alert('date was '+form.Deadline.value);
//		dateFormat(form.Deadline.value, "dddd, mmmm dS, yyyy, h:MM:ss TT");
// Saturday, June 9th, 2007, 5:46:21 PM
		// Or do we? I can't convert to Unix Epoch time here, so why bother? I'll just pass the date to php and convert it there! 
		
    	$.ajax({
            type: "POST",  
            url: "/php/AddRowIncubators.php",  
            data: "tableName="+ "Incubators" 
            	+"&name="+ form.Name.value 
            	+"&deadline="+ form.Deadline.value
            	+"&demoDay="+ form.DemoDay.value
            	+"&address="+ form.Address.value
            	+"&cityState="+ form.CityState.value
            	+"&terms="+ form.Terms.value
            	+"&cost="+ form.Cost.value,
            success: function(data){  
                alert('AddRowIncubators success: data was '+data);
                
                // On success, immediately redraw the div so the user can see the new values they just entered.
                var oldData = document.getElementById('incubators-body').innerHTML;
                document.getElementById('incubators-body').innerHTML = oldData
                		+"<tr class=d1>"
                			+"<td>"+form.Name.value+"</td>"
                			+"<td>"+form.Deadline.value+"</td>"
                			+"<td>"+form.DemoDay.value+"</td>"
                			+"<td>"+form.Address.value+"</td>"
                			+"<td>"+form.CityState.value+"</td>"
                			+"<td>"+form.Terms.value+"</td>"
                			+"<td>"+form.Cost.value+"</td>"
                		+"</tr>";
            }  
        });  
	}	
	
    
    function DeleteRow(tableName, rowKey) {
		$.ajax({  
            type: "POST",  
            url: "/php/DeleteRow.php",  
//			url:"php/2weeks.php", // Used to disable DeleteRow for debugging/testing
            data: "tableName="+ tableName 
            	+"&rowKey="+ rowKey,
            success: function(data){  
                alert('Deleted! Php output was ... '+data);
				//ShowHide("incubators-body", "tr", "td", "btn-g", "Show");	
				ShowHide("row"+rowKey, "tr", "td", "none","none");
//                window.location.reload();
            }  
        });  
	
    }
    
    
    
    function ShowHide(divId, tr, td, swapText, newText) {
    	alert ('ShowHide called with the following args: divID: '+divId+', tr: '+tr+', td:'+td+', swapText:'+swapText+', newText:'+newText);
		var curDiv = document.getElementById(divId);
		alert ('curDiv was ' +curDiv);
		var trsToHide = curDiv.getElementsByTagName(tr);
		//alert ('trstohide was ' +trsToHide);
		var tdsToHide = curDiv.getElementsByTagName(td);
		for (var i=0; i<tdsToHide.length; i++) {
			//alert ('tds to hide i was ' + tdsToHide[i]);
			if (tdsToHide[i].style.display == 'none') {
				tdsToHide[i].style.display = 'table-cell';
				if (trsToHide[i] != undefined) 
					trsToHide[i].style.display = 'table-row';
			}
			else {
				tdsToHide[i].style.display = 'none';
				if (trsToHide[i] != undefined) 
					trsToHide[i].style.display = 'none';			
			}
		}

		
	}
    
	function Ajax(tableName, row, columnName, dataToPost) {
    	$.ajax({  
            type: "POST",  
            url: "/php/ajax.php",  
            data: "tableName="+ tableName +"&row="+ row +"&columnName="+ columnName + "&dataToPost="+ dataToPost,  
            success: function(){  
                $('form#submit').hide(function(){$('div.success').fadeIn();});  
            }  
        });  
	}
	
	
	
	// Call the EventBrite API thru its own PHP file.
  	function AddEventbriteEvents() {
		var keywords = "";
    	for (var i=0; i<searchTermArray.length; i++) 
    	{
		    $.ajax({  
   	         type: "POST",
   	    	    dataType: "text",
				data: 	"tableName=Events" + "&searchTerm=" + searchTermArray[i], 
   	    	 	url: "/php/eventbrite.php",  
   	    	 	success: function(data, textStatus, jqXHR){  
			    	// window.location.reload();
					alert('AddEventBrite success: data was '+data);
   	        	}     
   	     	});
    	}  
	}

	// Call the Meetup API thru its own PHP file.
  	function AddMeetupEvents() {
	  	var keywords = "";
    	for (var i=0; i<searchTermArray.length; i++) 
    	{
   
	    	$.ajax({  
	    		
	    		//alert('for loop in PopulateTable called '+i);
    	        type: "POST",
        	    dataType: "text",
				data: 	"tableName=Events" + "&searchTerm=" + searchTermArray[i], 
           	 	url: "/php/meetup.php",  
           	 	success: function(data, textStatus, jqXHR){  
			    	// window.location.reload();
					alert('AddMeetup success: Returned data was '+data);
            	}     
        	});
    	}
   
	}

  	function CleanTable(form) {
    	$.ajax({  
        	type: "POST",  
			dataType: "text",
			data: "tableName=" + form.tableName.value,
            url: "/php/CleanTable.php",  
            success: function(data, textStatus, jqXHR){  
                alert(data);
            }  
        });
	}  	
	
	function TwoWeeks() {
    	$.ajax({  
        	type: "POST",  
			dataType: "text",
			data: "tableName=" + "Events",
            url: "/php/2weeks.php",  
            success: function(data, textStatus, jqXHR){  
                alert(data);
            }  
        });
	}
	

		

//Get or set the showAnim option, after init.
//getter
	var showAnim = $( ".selector" ).datepicker( "option", "showAnim" );
//setter

function Initialize() {
	document.getElementById('searchTerms').innerHTML += searchTermArray;
//	PopulateTable(meetup);
}
    var toggle = [];// Embarrassing... but I can't figure out how to check toggleClass without toggling it. Week 2 with JQuery! /excuse soliloquy
	for (var i=0; i<10; i++) { toggle[i] = 1; } // A quick for loop to populate my array of toggles. I hate myself

   
    $(document).ready(function(){
    	$("#datepicker").datepicker(); // REF: http://docs.jquery.com/UI/Datepicker
    	$( ".selector" ).datepicker({ showAnim: 'fold' });
    	$('btn-a#button').click(function(){		
	    	$(this).toggleClass("down"); toggle[1] *= -1;
	   		if (toggle[1] == 1) { 
	   			$( "#datepicker" ).show();
	   		} 
	   		else {
	   			$( "#datepicker" ).hide();
	   		}
	    });
                                                                                                     
 	}); // end $document.ready

    
    $(document).ready(function(){    
    		// The Show/Hide button for Events tab.
    	$('btn-f#button').click(function(){ 
    		$(this).toggleClass("down"); toggle[6] *= -1;
	   		if (toggle[6] == -1) 			return ShowHide("events-body", "tr", "td", "btn-f", "Show");	
	   		else				   			return ShowHide("events-body", "tr", "td", "btn-f", "Hide");	 
		});
    	
    	// The Show/Hide button for Incubators tab.
    	$('btn-g#button').click(function(){ 
    		$(this).toggleClass("down"); toggle[7] *= -1;
	   		if (toggle[7] == -1) 			return ShowHide("incubators-body", "tr", "td", "btn-g", "Show");	
	   		else				   			return ShowHide("incubators-body", "tr", "td", "btn-g", "Hide");
		});
                                                                                                     
 	});
    
    
    
    
    
    
	</script>

<!--END JQuery. -->

<!-- Google maps javascript stuff -->

<!-- END Google maps javascript stuff -->
</head>

<body bgcolor=FBB755 onload="Initialize()">
<center>
	<img src="http://www.fractalgames.com/img/hactus.png">
</center>
<div id="navbar2" style="float:left; height:500px">
	<br>
	<br><br>
   	    Search terms: <div id='searchTerms'></div>
	<form>
		<br>
   	   	Populate Events with the Meetup API:
   		<input type="button" value="Meetup" class ="button" onClick="AddMeetupEvents()"> 
	</form>		
	
	<form>
		<br>
	 	Populate Events with the Eventbrite API:    
   		<input type="button" value="Eventbrite" class ="button" onClick="AddEventbriteEvents()"> 
	</form>	
		
	<form>
		<br>
	 	Clear all Events with dates farther out than two weeks:    
   		<input type="button" value="Clear" class ="button" onClick="TwoWeeks()"> 
	</form>		

	<form>
		<br>
	 	Update Lat Lng in the Incubators table:    
   		<input type="button" value="Update" class ="button" onClick="UpdateLatLngIncubators()"> 
	</form>		
				
	<br><br>
	<btn-a id="button" title="button">  Hackerspaces </btn-a>

	
</div>
<br><br>


<table id="event-feed" summary="Incubators and Programs Feed" width=90%> 
	<thead> 
		<tr>        
			<td colspan="9" class="titlebar"><center><b><font size=6>
				Incubators & Programs
				<font size=3>		
				<btn-g id="button" title="button">  
					<span id="btn-g">   
						Hide
					</span>
				</btn-g>			
				<font size=6>
				<!-- old non Jquery button>
				
				<input type="button" value="Show/Hide" class ="button" onClick="ShowHide('d0');">  
				<!---->
			</td>    
		</tr><font size=5>
		<tr> 
		
		<tr> 
			<th scope="col" align="center" width=20%>Name</th> 
			<th scope="col" width=15%>Deadline</th> 
			<th scope="col" width=15%>Demo Day</th> 
			<th scope="col" align="center" width=25%>Location</th> 
			<th scope="col" align="center" width=20%>Terms</th> 
			<th scope="col" align="center" width=5%>Cost</th> 
			<th scope="col" align="center" width=25%>Lat</th> 
			<th scope="col" align="center" width=25%>Lng</th> 
			<th scope="col" align="center" width=25%>Action?</th> 
		</tr> 
	</thead> 
	<tbody id="incubators-body"> <font size=3>

	<?php //Connect to your mysql server
		$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');if (!$con)  {  die('Could not connect: ' . mysql_error());  }
		mysql_select_db("hacktus", $con);
		$sql="SELECT * FROM Incubators ORDER BY Deadline ASC"; //Create a Query to select all rows in the table Events
		$result = mysql_query($sql);
		$i=0;
		while($row = mysql_fetch_array($result)) //Iterate all rows in query results. Each row will be an event
		{
			// Display a new HTML row with each new $row
			
			echo "<tr class=\"d".($i & 1)."\"id=row" . $row['key'] . ">";
				echo "<td><a href='". $row['Name_URL'] . "' target=\"_blank\">"  . $row['Name'] . "</a></td>";
				echo "<td>" . date( 'D d M Y', strtotime($row['Deadline'])) . "</td>";   // dates: http://php.net/manual/en/function.date.php
				echo "<td>" . date( 'D d M Y', strtotime($row['DemoDay'])) . "</td>";

				// If address is missing, put "unknown" and link to the page
				// if (strlen($row['Address'] > 2))
					echo "<td><a href='" . $row['Location_URL'] . "' target=\"_blank\">"  . $row['Address'] . ", " . $row['CityState'] . "</a></td>";
	 			// else echo "<td><a href='". $row['Name_URL'] ."'> unknown </a></td>";
	 			echo "<td>" . $row['Terms'] . "</td>";

				// If cost is missing, put "Free"
				if (strlen($row['Cost'] > 1))
					echo "<td>"  . $row['Cost'] . "</td>";
	 			else echo "<td>Free</td>";
				echo "<td>" . $row['Lat'] . "</td>";
				echo "<td>" . $row['Lng'] . "</td>";
				echo "<td>"
						. "<input type=\"button\" 
								value=\"Delete\" 
								class =\"button\" 
								onClick=DeleteRow(\"Incubators\"," . $row['key'] . ") 
								style=\"width:130px\">";
				$address = $row[Address] . " " . $row['CityState'];
				$address = str_ireplace(",","",$address);
				$address = str_ireplace(" ","+",$address);
				echo $address;
				echo "<input type=\"button\" 
								value=\"GetLatLng\" 
								class =\"button\" 
								onClick=GetLatLng(" . $row['key'] . ",\"" . $address . "\") 
								style=\"width:50px\">";
				echo "<input type=\"button\" 
								value=\"SetLatLng\" 
								class =\"button\" 
								onClick=SetLatLngIncubators(" . $row['key'] . ") 
								style=\"width:50px\">";

/*
				echo "<input type=\"button\"
								value=\"LatLng\" 
								class =\"button\" 
								onClick=UpdateLatLngIncubators(" . $row['key'] . ", " . $address . ") style=\"width:130px\">";*/
				  echo "</td>";
			echo "</tr>";
			$i++;
 			//Populate the javascript event arrays
 			
 			// Not done yet
 			

		}

	mysql_close($con);
	?>

	</tbody>
	<tr>
		<td colspan=9>
		<br>
			<center>Know of an Incubator or Program we've missed? Please enter it below:</center>
		</td>
	</tr>

	<tr>
		<form>
			<td>
				<input type="text" name="Name" value="Name" onClick="this.select();" style="width:90%"> 
			</td>
			<td>
				<div class="demo"> 
					<input type="text" id="datepicker" name="Deadline" value="Deadline" style="width:90%">
				</div> 
			</td>
			<td>
				<div class="demo"> 
					<input type="text" id="datepicker2" name="DemoDay" value="Demo Day" style="width:90%">
				</div> 			
			</td>

			<td>
				<input type="text" name="Address" value="Street Address" onClick="this.select();" style="width:90%">
				<input type="text" name="CityState" value="City, State" onClick="this.select();" style="width:90%"> 
			</td>
			<td>
				<input type="text" name="Terms" value="Terms" onClick="this.select();" style="width:90%"> 
			</td>
			<td>
				<input type="text" name="Cost" value="Cost" onClick="this.select();" style="width:90%"> 

			</td>

	</tr>
	<tr>
		<td colspan=9>
			<center>
				<input type="button" value="Submit" class ="button" onClick='AddRowIncubators(this.form);' style="width:130px"> 
		</td>
		</form>		
	</tr>
	
</table> 
<!-- HTML for feeds goes here, got rid of Divs to get tables to look/be aligned right -->
<table id="event-feed" summary="Employee Pay Sheet" style="width:90%"> 
	<thead> <tr>        <td colspan="5" class="titlebar"><center><b><font size=6>Upcoming Events Feed</td>    </tr><font size=5>
		<tr class="d02"> 
			<th scope="col" align="center">Event</th> 
			<th scope="col" width="150px">Date</th> 
			<th scope="col">Time</th> 
			<th scope="col" align="center">Location</th> 
			<th scope="col" align="center">Source</th> 
		</tr> 
</thead> <tbody> <font size=3>

<!--  ******* PHP ******* -->
<?php //Connect to your mysql server
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');if (!$con)  {  die('Could not connect: ' . mysql_error());  }
mysql_select_db("hacktus", $con);
$sql="SELECT * FROM Events ORDER BY Date ASC"; //Create a Query to select all rows in the table Events
$result = mysql_query($sql);
$i=0;
while($row = mysql_fetch_array($result)) //Iterate all rows in query results. Each row will be an event
  {
	echo "<tr class=\"d".($i & 1)."\">";
  echo "<td><a href='". $row['Name_URL'] . "' target=\"_blank\">"  . $row['Name'] . "</a></td>";
  echo "<td>" . date( 'D d M Y', strtotime($row['Date'])) . "</td>";   /*REFerence for date formatting: http://php.net/manual/en/function.date.php */
  echo "<td>" . date( 'h:i A', strtotime($row['Date'])) . "</td>"; 
  if (strlen($row['Address'] > 2))
  	echo "<td><a href='" . $row['Location_URL'] . "' target=\"_blank\">"  . $row['Address'] . "<br>" . $row['CityState'] . "</a></td>";
  else echo "<td><a href='". $row['Name_URL'] ."'> See event page </a></td>";
//  <a href="http://www.quackit.com/html/html_help.cfm" target="_blank">HTML Help</a>
  echo "<td>" . $row['Source'] . "</td>";
  echo "</tr>";
  $i++;
  //Populate the javascript event arrays
  }

mysql_close($con);
?>
<!-- Form entry for UserAddEvent.php-->
<tr>
<!-- New calendar popup? -->
<!--
<div id=\"totals\" style=\"behavior:totals\">
			<div style=\"flow:horizontal;white-space:nowrap;overflow:hidden;padding-bottom: 2px\">
			  <widget name=\"close\" target=\"totals\" style=\"margin-top:0px\">r</widget><span style=\"width:100%%;padding-left:8px\">Totals</span>
			</div>
			<div style=\"flow:horizontal;white-space:nowrap;overflow:hidden\">
			   Begin:&nbsp;<input type=\"date\" name=\"calendar\" id=\"begindate\">&nbsp;<input type=\"masked\" mask=\"## : ## : ##\" value=\"000000\" id=\"begintime\">
			   End:&nbsp;<input type=\"date\" name=\"calendar\" id=\"enddate\">&nbsp;<input type=\"masked\" mask=\"## : ## : ##\" value=\"000000\" id=\"endtime\">
			   &nbsp;
			   <div class=\"textbutton\" style=\"behavior:button;margin-top:0px;margin-left:0px;margin-right:100%%;\" name=\"Go\" value=\"go\">&nbsp;Go&nbsp;</div>&nbsp;
			   <div id=\"loading-totals\" style=\"width:min-intrinsic\">
				<img style=\"vertical-align: middle\" src=\"http://www.fractalgames.com/img/indicator.gif\"/>
			  </div>
			</div>
			 <table name=\"view\" style=\"padding-top:1px;padding-bottom:1px; width:*\" fixedrows=1 cellspacing=\"0\" cellpadding=\"0\">
				<tr><th class=\"first tableCellHeader\" style=\"width:10em;text-align:center\" sort=\"desc\">Volume</th><th class=\"tableCellHeader\" style=\"width:7em;text-align:center\">VWAP</th><th class=\"tableCellHeader\" style=\"width:7em\">High</th><th class=\"tableCellHeader\" style=\"width:7em\">Low</th><th class=\"tableCellHeader\" style=\"width:100%%\"></th></tr>
				<tr ><td class=\"first cell\">.</td><td class=\"cell\"></td><td class=\"cell\"></td><td class=\"cell\"></td></td><td class=\"cell\"></td></tr>
			 </table>
		</div>
-->

	<!-- Old calendar
	<form> 
		<td>	
	   		<input type="text" name="Name" value="Event Name"> 
	   	</td>
	   	<td>
	   		<div id="datepicker">
	   		
	   		</div>
	   		
	   	</td>
   		<td>
   			<input type="text" name="Address1" value="Street Address"> 
	   	</td>
		<td>
   			<input type="text" name="City" value="City"> 
			</td>
		<td>
   			<input type="text" name="State" value="State"> 
		</td>
		<td>
   			<input type="text" name="Link" value="Link"> 
		</td>
		<td>
   			<input type="text" name="Venue" value="Venue Name"> 
		</td>
		<td>
   			<input type="text" name="Description" value="Description"> 
		</td>
		<td>
   			<input type="text" name="Cost" value="Cost"> 
		</td>
	</form>
	-->
</tr>

</tbody> 
</table> 

<table id="event-feed" summary="Employee Pay Sheet" style="margin: 8px 6% 0px 0px; width:90%;"> 
<thead> <tr>        <td colspan="5" class="titlebar"><center><b><font size=6>Upcoming Events Feed</td>    </tr><font size=5>
<tr> <th scope="col" align="center">Event</th> <th scope="col">Date</th> <th scope="col">Time</th> <th scope="col" align="center">Location</th> </tr> 
</thead> <tbody> <font size=3>


<?php //Connect to your mysql server
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');if (!$con)  {  die('Could not connect: ' . mysql_error());  }
mysql_select_db("hacktus", $con);
$sql="SELECT * FROM Events ORDER BY Date ASC"; //Create a Query to select all rows in the table Events
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) //Iterate all rows in query results. Each row will be an event
  {
  echo "<tr>";
  echo "<td><a href='". $row['Name_URL'] ."'>" . $row['Name'] . "</a></td>";
  echo "<td>" . date( 'D d M Y', strtotime($row['Date'])) . "</td>";   /*REFerence for date formatting: http://php.net/manual/en/function.date.php */
  echo "<td>" . date( 'h:i A', strtotime($row['Date'])) . "</td>"; 
  echo "<td><a href='". $row['Location_URL'] ."'>"  . $row['Location'] . "</a></td>";
  echo "</tr>";
  //Populate the javascript event arrays
/*	echo "<script>	eventAddressArray.push(\"" . $row['Address'] . "\"); </script>";
	echo "<script>	eventNameArray.push(\"" . $row['Name'] . "\"); </script>";
	echo "<script>	eventNameURLArray.push(\"" . $row['Name_URL'] . "\"); </script>";
	echo "<script>	eventDescriptionArray.push(\"" . $row['Description'] . "\"); </script>";	
	echo "<script>	eventPhoneArray.push(\"" . $row['Phone'] . "\"); </script>";
	*/
  }

mysql_close($con);
?>



</tbody> 
</table> 

<br>
<table id="incubator-feed" summary="Incubator Deadline Feed"> <!-- style="float: right; margin: 8px 6% 0px 0px; width:45%;"> -->
<thead> <tr>        <td colspan="6" class="titlebar"><center><b><font size=6>Upcoming Incubator Programs</td>    </tr><font size=5>
<tr> <th scope="col" align="center"  style="width:120px">Name</th> 
<th scope="col">Deadline</th> 
<th scope="col" style="width:170px">Location</th>
<th scope="col">Terms</th> 
<th scope="col">Cost</th> 
<th scope="col" style="width:120px">Demo Day</th>
</tr> 
</thead> <tbody> <font size=3>

<!--            PHP 
<!--
<!--					-->
<!--					-->


<!-- /**************************************/


// Push the Incubator addresses into a javascript array for incubator addresses. -->



<!-- /**************************************/
// Get the LatLng coordinates from GeoCoder and then push each of those into the Incubator LatLng in MySQL. -->

<?php //Connect to your mysql server
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');if (!$con)  {  die('Could not connect: ' . mysql_error());  }
mysql_select_db("hacktus", $con);
$sql="SELECT * FROM Incubators"; //Create a Query to select all rows in the table Events
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) //Iterate all rows in query results. Each row will be an event
  {
   //Populate the javascript event array
//		echo "<script>	eventPhoneArray.push(\"" . $row['Phone'] . "\"); </script>";
  }
// Create a query to select all rows in the table Hackerspaces
mysql_close($con);
?>





<?php
//Connect to your mysql server
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420'); if (!$con)  {  die('Could not connect: ' . mysql_error());  }
mysql_select_db("hacktus", $con);
$sql="SELECT * FROM IncubatorDeadlines";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td><a href='". $row['Name_URL'] ."'>" . $row['Name'] . "</a></td>";
  /*REFerence for date formatting: http://php.net/manual/en/function.date.php */
  echo "<td>" . date( 'd M', strtotime($row['Deadline'])) . "</td>"; 
  echo "<td>" . $row['Location'] . "</a></td>";
  echo "<td>" . $row['Terms'] . "</a></td>";
  echo "<td> $ " . $row['Cost'] . "</a></td>";
  echo "<td>" . date( 'd M h:i A', strtotime($row['DemoDay'])) . "</td>"; 
  echo "</tr>";
  // Let's populate the hackerspace array with the addresses.
//    echo "The location was". $row['Location'];	
//	echo "alert('eventLocationArray[0]');";
  }
mysql_close($con);
?>


</tbody> 
</table> 


<table id="Hackerspaces" summary="Coworking Spaces List" style="width:70%;"> 
<thead> <tr>        <td colspan="5" class="titlebar"><center><b><font size=6></center>Coworking Spaces<center></td>    </tr><font size=5>
<tr> <th scope="col" align="center">Name</th> <th scope="col">Phone</th> <th scope="col" align="center">Address</th> </tr> 
</thead> <tbody> <font size=3>

<!--            PHP 
<!--
<!--					-->
<!--					-->

<?php
//Connect to your mysql server
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("hacktus", $con);

//Create a Query to select all rows in the table Events
$sql="SELECT * FROM CoworkingSpaces";
$result = mysql_query($sql);

//Iterate all rows in query results. Each row will be an event
$i = 0;

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

/* 	echo "<script>	coworkingAddressArray.push(\"" . $row['Address'] . "\"); </script>";
	echo "<script>	coworkingNameArray.push(\"" . $row['Name'] . "\"); </script>";
	echo "<script>	coworkingNameURLArray.push(\"" . $row['Name_URL'] . "\"); </script>";
	echo "<script>	coworkingDescriptionArray.push(\"" . $row['Description'] . "\"); </script>";	
	echo "<script>	coworkingPhoneArray.push(\"" . $row['Phone'] . "\"); </script>";
	echo "<script>	coworkingCostArray.push(\"" . $row['Cost'] . "\"); </script>";
	*/
  }

mysql_close($con);
?>


</tbody> 
</table> 

<br><hr>
<!-- ************** BEGIN Tab Example ************** -->

<h3>Demo #1- Basic implementation</h3>
<center>
<ul id="countrytabs" class="shadetabs">
<li><a href="#" rel="country1" class="selected">Tab 1</a></li>
<li><a href="#" rel="country2">Tab 2</a></li>
<li><a href="#" rel="country3">Tab 3</a></li>
<li><a href="#" rel="country4">Tab 4</a></li>
<li><a href="http://www.dynamicdrive.com">Dynamic Drive</a></li>
</ul>

<div style="border:1px solid gray; width:450px; margin-bottom: 1em; padding: 10px">

<div id="country1" class="tabcontent">
<table id="event-feed" summary="Employee Pay Sheet" style="width:90%;"> 
	<thead> <tr>        <td class="titlebar"><center><b><font size=6>Upcoming Events Feed</td>    </tr><font size=5>
		<tr> <th scope="col" align="center">Event</th> 
		<th scope="col">Date</th> 
		<th scope="col">Time</th> 
		<th scope="col" align="center">Location</th> </tr> 
</thead> <tbody> <font size=3>

<!--  ******* PHP ******* -->
<?php
//Connect to your mysql server
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
if (!$con)  {  die('Could not connect: ' . mysql_error());  }
mysql_select_db("hacktus", $con);

//Create a Query to select all rows in the table Events
$sql="SELECT * FROM Events ORDER BY Date ASC";
$result = mysql_query($sql);

//Iterate all rows in query results. Each row will be an event
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td><a href='". $row['Name_URL'] ."'>" . $row['Name'] . "</a></td>";
  /*REFerence for date formatting: http://php.net/manual/en/function.date.php */
  echo "<td>" . date( 'D d M Y', strtotime($row['Date'])) . "</td>"; 
  echo "<td>" . date( 'h:i A', strtotime($row['Date'])) . "</td>"; 
  echo "<td><a href='". $row['Location_URL'] ."'>"  . $row['Location'] . "</a></td>";
  echo "</tr>";
  // Let's populate the javascript arrays with the database info.

//	echo "alert('eventLocationArray[0]');";
  }
?>



<?php
 // ***** Hackerspace SQL Binding ******
 //Connect to your mysql server
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
if (!$con)  {  die('Could not connect: ' . mysql_error());  }
mysql_select_db("hacktus", $con);
// Create a query to select all rows in the table Hackerspaces
$sql="SELECT * FROM Hackerspaces";
$result = mysql_query($sql);

//Iterate all rows in query results. Each row will be an event
while($row = mysql_fetch_array($result))
  {
	// This will populate the local arrays with MySQL data for Hackerspaces..
/* 	echo "<script>	hackerspaceAddressArray.push(\"" . $row['Address'] . "\"); </script>";
	echo "<script>	hackerspaceNameArray.push(\"" . $row['Name'] . "\"); </script>";
	echo "<script>	hackerspaceNameURLArray.push(\"" . $row['Name_URL'] . "\"); </script>";
	echo "<script>	hackerspaceDescriptionArray.push(\"" . $row['Description'] . "\"); </script>";	
	echo "<script>	hackerspacePhoneArray.push(\"" . $row['Phone'] . "\"); </script>";
	echo "<script> 	hackerspaceLatLngArray.push(\"" . $row['LatLng'] . "\"); </script>";*/
  } 
 


// Separate from the event feed, we will populate the Hackerspace, Co-op space addresses here:
/*
$sql="SELECT * FROM Mapstuff";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
	{
	}

*/
mysql_close($con);
?>


</tbody> 
</table> 




Tab content 1 here<br />Tab content 1 here<br />
</div>

<div id="country2" class="tabcontent">
<table id="Hackerspaces" summary="Coworking Spaces List" style="float: left; width:70%;"> 
<thead> <tr>        <td colspan="5" class="titlebar"><center><b><font size=6></center>Hackerspaces<center></td>    </tr><font size=5>
<tr> <th scope="col" align="center">Name</th> <th scope="col">Phone</th> <th scope="col" align="center">Address</th> </tr> 
</thead> <tbody> <font size=3>

<!--            PHP 
<!--
<!--					-->
<!--					-->

<?php
//Connect to your mysql server
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("hacktus", $con);

//Create a Query to select all rows in the table Events
$sql="SELECT * FROM CoworkingSpaces";
$result = mysql_query($sql);

//Iterate all rows in query results. Each row will be an event
$i = 0;

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

/* 	echo "<script>	coworkingAddressArray.push(\"" . $row['Address'] . "\"); </script>";
	echo "<script>	coworkingNameArray.push(\"" . $row['Name'] . "\"); </script>";
	echo "<script>	coworkingNameURLArray.push(\"" . $row['Name_URL'] . "\"); </script>";
	echo "<script>	coworkingDescriptionArray.push(\"" . $row['Description'] . "\"); </script>";	
	echo "<script>	coworkingPhoneArray.push(\"" . $row['Phone'] . "\"); </script>";*/
  }

mysql_close($con);
?>


</tbody> 
</table> 
Tab content 2 here<br />Tab content 2 here<br />
</div>

<div id="country3" class="tabcontent">
Tab content 3 here<br />Tab content 3 here<br />
</div>

<div id="country4" class="tabcontent">
Tab content 4 here<br />Tab content 4 here<br />
</div>

</div>

<script type="text/javascript">
/*
var countries=new ddtabcontent("countrytabs")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()
*/
</script>
</center>
<!-- ************** END Tab Example ************** -->



<br><br><br><br><br><br><br><br><br><br><br><br>


</body>
</HTML>
