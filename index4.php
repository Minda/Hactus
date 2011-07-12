<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<HTML>
<title>hactus - the Cheat Sheet for Entrepreneurs</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<head>
 
	<LINK href="hactus.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="http://www.fractalgames.com/bin/tabcontent.js"></script>
    <script type="text/javascript" src="http://www.fractalgames.com/bin/jquery.js"></script>
	<!-- unused editable    <script src="http://www.fractalgames.com/bin/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script> -->
	<!-- jQuery UI for Calendar -->   
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/i18n/jquery-ui-i18n.min.js" type="text/javascript"></script> 
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script> 
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js" type="text/javascript"></script> 
	<script src="http://jquery-ui.googlecode.com/svn/tags/latest/external/jquery.bgiframe-2.1.2.js" type="text/javascript"></script> 

	<!-- Jquery Calendar CSS -->
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>

	<!-- custom JS Date formatter -->
    <script type="text/javascript" src="http://www.fractalgames.com/bin/dateformat.js"></script>	

    <script>

	// Shows or hides ALL elements with tagId contained within any divId.
	function ShowHide(divId, tr, td, swapText, newText) {
		document.getElementById(swapText).innerHTML = newText;
		
		// for tagId1 
		var curDiv = document.getElementById(divId);
		var tdsToHide = curDiv.getElementsByTagName(td);
		var trsToHide = curDiv.getElementsByTagName(tr);
		for (var i=0; i<tdsToHide.length; i++) {
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
                			+"<td>"+form.Address.value+"<br>"
								   +form.CityState.value+"</td>"
                			+"<td>"+form.Terms.value+"</td>"
                			+"<td>"+form.Cost.value+"</td>"
                		+"</tr>";
            }  
        });  
	}	
	
	function DisplayCoworking() {
    	$.ajax({  
            type: "POST",  
            url: "/php/DisplayCoworking.php",  
            data: "tableName=dummy",
            success: function(data){
				document.getElementById('events').innerHTML += data;
//				document.write(data); //                alert('AddRow success: data was '+data);
            }  
        });  
	}
	
	
	
	
	//Doesn't work
	/*
	function DisplayEvents() {
    	$.ajax({  
            type: "POST",  
            url: "/php/DisplayEvents.php",  
            data: "tableName=dummy",
            success: function(data){
            	var oldStuff = document.getElementById('event-feed').innerHTML;
				document.getElementById('event-feed').innerHTML = data + oldStuff;
				// alert ('data was'+data);
//				document.write(data); //                alert('AddRow success: data was '+data);
            }  
        });  
	}	
	*/
	
	function DisplayIncubators() {
    	$.ajax({  
            type: "POST",  
            url: "/php/DisplayIncubators.php",  
            data: "tableName=dummy",
            success: function(data){
				document.getElementById('incubator-feed').innerHTML += data;
//				document.write(data); //                alert('AddRow success: data was '+data);
            }  
        });  
	}


	function DisplayHackerspaces() {
    	$.ajax({  
            type: "POST",  
            url: "/php/DisplayHackerspaces.php",  
            data: "tableName=dummy",
            success: function(data){
				// document.getElementById('incubator-feed').innerHTML += data;
//				document.write(data); //                alert('AddRow success: data was '+data);
				alert('DisplayHackerspaces success. data was ' +data);
				data;
            }  
        });  
	}	
	
	
	
		
	 // Simple WaitForMiliseconds function
	function waitForMs(millis) 	{	var date = new Date();	var curDate = null;
		do { curDate = new Date(); } 		while(curDate-date < millis);
	} 
	
    var toggle = [];// Embarrassing... but I can't figure out how to check toggleClass without toggling it. Week 2 with JQuery! /excuse soliloquy
	for (var i=0; i<10; i++) { toggle[i] = 1; } // A quick for loop to populate my array of toggles. I hate myself
 
 
	// JQuery

	// calendar
	$(function() {
		$( "#datepicker" ).datepicker();
		$( "#datepicker2" ).datepicker();
		$( "#datepicker3" ).datepicker();
	}); 
		
     $(document).ready(function(){    	
    	// The buttons below are the toggle overlay buttons for the map
		//    	function : showMarkers ( arrayNumber, colorNumber )
	    $('btn-a#button').click(function(){		
	    	$(this).toggleClass("down"); toggle[1] *= -1;
	   		if (toggle[1] == -1) 	   		return showMarkers(0,1);	
	   		else				   			return 	hideMarkers(0);
	    });
		
		$('btn-b#button').click(function(){     
	    	$(this).toggleClass("down"); toggle[2] *= -1;
	   		if (toggle[2] == -1) 	   		return showMarkers(1,2);	
	   		else				   			return hideMarkers(1);
    	});

		$('btn-c#button').click(function(){     
	    	$(this).toggleClass("down"); toggle[3] *= -1;
	   		if (toggle[3] == -1) 	   		return showMarkers(2,3);	
	   		else				   			return hideMarkers(2);
    	});
    	
		$('btn-d#button').click(function(){     
	    	$(this).toggleClass("down"); toggle[4] *= -1;
	   		if (toggle[4] == -1)			return showMarkers(3,4);	
	   		else				   			return hideMarkers(3);
    	});
    	    		
    	$('btn-e#button').click(function(){ 
    		$(this).toggleClass("down"); toggle[5] *= -1;
	   		if (toggle[5] == -1) 			return showMarkers(4,5);	
	   		else				   			return hideMarkers(4);	 
		});

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
                                                                                                     
 	}); //end $document.ready    
    
	</script>

<!--END JQuery. -->
  

	
	
	
<!-- Google maps javascript stuff -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&amp;libraries=places"></script> 
<script>	// Search Logic

	// Here we set up the markers to be used, picking from google's fun HTML marker creator.
	var markerColors = new Array(
	"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|5CCFDA|000000", // Teal
	"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|5CCFDA|000000", // Teal
	"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|4444FF|EEEEEE", // Blue
	"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|986EDE|000000", // Purple
	"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|DF7171|000000", // Red
	"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|32DA3E|000000"); // Green


	// Let's make some arrays for the PHP to dump into so we can deal with them locally and only make the php calls once.
	// Kinda looks messy because we repeate each Array for each type of location. I'm sure I can improve this.
	var latArray = new Array ( );
	var lngArray = new Array ( );		
	var markerArray = new Array ( );
	var infoWindowArray = new Array ( );
	var addressArray = new Array ( );
	var descriptionArray = new Array ( );
	var nameArray = new Array ( );
	var nameUrlArray = new Array ( );
	var costArray = new Array ( );
	var phoneNumberArray = new Array ( );

	// Nested arrays for each term are grouped as follows
	//	[0] == Hackerspaces
	// [1] == Coworking
	// [2] == Incubators
	// [3] == StartupHouses
	// [4] == Others
	// [5] == Events
	// E. G. nameArray[5][0] will return the name of the first event in the array.
	
	//populate each of the sub-arrays 
	for (var i=0; i<5; i++) {
		latArray[i] = new Array ( );
		lngArray[i] = new Array ( );
		markerArray[i] = new Array ( );
		infoWindowArray[i] = new Array ( );
		addressArray[i] = new Array ( );
		descriptionArray[i] = new Array ( );
		nameArray[i] = new Array ( );
		nameUrlArray[i] = new Array ( );
		costArray[i] = new Array ( );
		phoneNumberArray[i] = new Array ( );
	}

	// Google Maps init variables
	var map;
	var geocoder;
	var service;
	var infowindow;
	var sanMateo;
	var mgr;
	
	  function initialize() {
	  	
	  	
	  	// Go ahead and show all the hackerspaces.
	  	// Well, when I call a php file to populate teh arrays it doesn't work so I just added the php at the bottom of this doc ....
		//	  	DisplayHackerspaces();
		// geocoder = new google.maps.Geocoder(); // Should not need to geocode anything here
		sanMateo = new google.maps.LatLng(37.4736, -122.3317);
		map = new google.maps.Map(document.getElementById('map_canvas'), {
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: sanMateo,
			zoom: 9,
	        scrollwheel: false
			});
		}
  
		function hideMarkers(n) {
			if (markerArray[n][0] != undefined) {
				for (i in markerArray[n]) {	     markerArray[n][i].setMap(null);    	}
			}
		}

		// This is called every time the user clicks an overlay button to the "down" position
		function showMarkers (n, colorNumber) {
			// If the marker array already exists, don't waste time with Marker function and just use the existing array
			if (markerArray[n][0] != undefined) {
		    	for (var i=0; i<markerArray[n].length; i++) {	
					markerArray[n][i].setMap(map);
				}
			}
			// Otherwise, the FIRST time the user clicks an overlay button,
			// create the markers through the markerFunction(,..);
			else {		
		    	// alert ('showMarkers called, array was null, calling markerfunction');
		    	for (var i=0; i<latArray[n].length; i++) {
		    		markerFunction(
	    						latArray[n][i],
	    						lngArray[n][i],
	    						addressArray[n][i], 
	    						descriptionArray[n][i], 
	    						nameArray[n][i], 
	    						nameUrlArray[n][i], 
	    						phoneNumberArray[n][i], 
	    						costArray[n][i], 
		    					markerColors[colorNumber],
		    					n // 'n' keeps track of which array we're dealing with if we need to arr[n].push(something)
		    		);	
		    	}
		    }
		}
		
		// This is called the first time the user clicks an overlay button, to create the markers
	    function markerFunction( 
					lat,
					lng,
					infoAddress, 
					infoContent, 
					infoTitle, 
					infoTitleUrl, 
					infoPhoneNumber, 
					infoCost, 
					infoImage,
					n ) { 

			// Get the coordinates for where the marker will be based on the saved "lat lng" from database
			googleLatLng = new google.maps.LatLng(lat,lng);	

			// Then actually create a new marker that can be displayed on the map.
			var new_marker = new google.maps.Marker({
			position:googleLatLng, map:map, title:infoTitle, icon:infoImage  })	

			// Save that marker so we don't have to create new ones later.
			markerArray[n].push(new_marker);
			
			// Display the marker we just created on the map
			new_marker.setMap(map);
			
			// Populate the content for the infowindow bubble for the new marker
			var new_content_string =  '<div id="content">'+'<div id="siteNotice">'+'</div>'+'<h3 id="firstHeading" class="firstHeading">'
				+'<a href='+infoTitleUrl+' target="_blank">'
				+infoTitle+'</a>'+'</h3>'
				+infoAddress+'<p>'
				+infoContent+'<p>'
				+infoPhoneNumber+'</div>';
			
   			 	// Determine cost (if any) and add that to the infowindow
   		 	if (infoCost == undefined) 	infoCost = "Free";
   			infoContent += '<p> Cost: '+infoCost;
   		 	
   		 	// Create the event window and save it to the array for later
			var new_infoWindow = new google.maps.InfoWindow({    content: new_content_string  });
			infoWindowArray[n].push(new_infoWindow);
		
			// Create a listener to open the window when the marker is pressed, and also close any other marker windows
			google.maps.event.addListener(	new_marker, 'click', function() { 
				for (var i=0; i<infoWindowArray[n].length; i++) { 
					infoWindowArray[n][i].close(); 
					};
				new_infoWindow.open(map,new_marker);    
			});
	    }
	</script>
</head>






<body bgcolor=FBB755>
<body onload="initialize()">

<center>
<!-- ************************************************************************************************************ -->
<!-- ************************************************************************************************************ -->
<!-- ******                                                                                     ***** ***** ***** -->
<!-- ******                                       BEGIN VISIBLE HTML BODY                       ***** ***** ***** -->
<!-- ****** 




                                        ***** ***** *****                           ***** ***** ***** -->




 
 
 
<img src="http://www.fractalgames.com/img/hactus.png"></center>
<center>
	<div id="navbar2">
		<ul id="countrytabs" class="shadetabs"><center>
<!--
			Possibly a title bar goes here?
			<btn-a id="button" title="button">  Hackerspaces </btn-a>
			<btn-b id="button" title="button">  Coworking Spaces </btn-b>
			<btn-c id="button" title="button">  Incubators </btn-c>
			<btn-d id="button" title="button">  Startup Houses </btn-d>
			<btn-e id="button" title="button">  All Others </btn-e>
-->
		</ul>
	</div>
</center>
</div>
<!-- Map goes here, centered by a cheat with marigns, map will disappear if embedded in another div or table (sux) -->
<div id="map_canvas" class="map_canvas" style="width:95%; height:75%; margin-left:2.5%"></div>

<!-- Buttons to change the map; should be checkboxes not buttons so you can have multiples -->
<center>
	<div id="navbar2">
		<ul id="countrytabs" class="shadetabs"><center>
			<btn-a id="button" title="button">  Hackerspaces </btn-a>
			<btn-b id="button" title="button">  Coworking Spaces </btn-b>
			<btn-c id="button" title="button">  Incubators </btn-c>
			<btn-d id="button" title="button">  Startup Houses </btn-d>
			<btn-e id="button" title="button">  All Others </btn-e>
		</ul>
	</div>
</center>
<br>




<!-- Incubator Feed Table -- >
<!-- HTML for feeds goes here, got rid of Divs to get tables to look/be aligned right -->
<center>
<table id="events-feed" summary="Incubators and Programs Feed" width=90%> 
	<thead> 
		<tr>        
			<td colspan="6" class="titlebar"><center><b><font size=6>
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
			echo "<tr class=\"d".($i & 1)."\">";
				echo "<td><a href='". $row['Name_URL'] . "' target=\"_blank\">"  . $row['Name'] . "</a></td>";
				echo "<td>" . date( 'D d M Y', strtotime($row['Deadline'])) . "</td>";   // dates: http://php.net/manual/en/function.date.php
				echo "<td>" . date( 'D d M Y', strtotime($row['DemoDay'])) . "</td>";

				// If address is missing, put "unknown" and link to the page
				if (strlen($row['Address'] > 2))
					echo "<td><a href='" . $row['Location_URL'] . "' target=\"_blank\">"  . $row['Address'] . ", " . $row['CityState'] . "</a></td>";
	 			else echo "<td><a href='". $row['Name_URL'] ."'> unknown </a></td>";
	 			echo "<td>" . $row['Terms'] . "</td>";

				// If cost is missing, put "Free"
				if (strlen($row['Cost'] > 1))
					echo "<td>"  . $row['Cost'] . "</td>";
	 			else echo "<td>Free</td>";

			echo "</tr>";
			$i++;
 			//Populate the javascript event arrays
 			
 			// Not done yet
 			
 			
 			
 
		}

	mysql_close($con);
	?>
	</tbody>
	<tr>
		<td colspan=6>
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
		<td colspan=6>
			<center>
				<input type="button" value="Submit" class ="button" onClick='AddRowIncubators(this.form);' style="width:130px"> 
		</td>
		</form>
	</tr>
	
</table> 



<br>




<!-- Event Feed Table -- >
<!-- HTML for feeds goes here, got rid of Divs to get tables to look/be aligned right -->
<center>
<table id="events-feed" summary="Upcoming Events Feed" width=90%> 
	<thead> 
		<tr>        
			<td colspan="5" class="titlebar"><center><b><font size=6>
				Events
				<font size=3>		
				<btn-f id="button" title="button">
					<span id="btn-f">  
						Hide 
					</span>
				</btn-f>
				<font size=6>
				<!-- old non Jquery button>
				
				<input type="button" value="Show/Hide" class ="button" onClick="ShowHide('d0');">  
				<!---->
			</td>    
		</tr><font size=5>
		<tr> 
			<th scope="col" align="center" width=42%>Event</th> 
			<th scope="col" width=138px>Date</th> 
			<th scope="col">Time</th> 
			<th scope="col" align="center">Location</th> 
			<th scope="col" align="center">Source</th> 
		</tr> 
	</thead> 
	<tbody id="events-body"> <font size=3>
	<?php //Connect to your mysql server
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
 			//Populate the javascript event arrays
 			
 			// Not done?
 			
 			
 			
 
		}

	mysql_close($con);
	?>
	</tbody>
	<tr>
		<td colspan=5>
		<br>
			<center>Know of an event we're missing? Please enter it below:</center>
		</td>
	</tr>
	<tr>
		<form>
			<td>
				<input type="text" name="Name" value="Name" onClick="this.select();" style="width:90%"> 
			</td>
			<td>
				<div class="demo"> 
					<input type="text" id="datepicker3" name="Date" value="Date" style="width:90%">
				</div>
			</td>
			<td>
				<input type="text" name="Location" value="Location" onClick="this.select();" style="width:90%"> 
			</td>
			<td>
				<input type="text" name="Description" value="Description" onClick="this.select();" style="width:90%"> 
			</td>
			<td>
				<input type="button" value="Add" class ="button" onClick="PHP_Binding(meetup);" style="width:100%">
			</td>
		</form>
		

	</tr>
</table> 


<br>
<table id="incubator-feed" summary="Incubator Deadline Feed" style="width:90%;"> 
<thead> <tr>        <td colspan="6" class="titlebar"><center><b><font size=6>Incubators & Programs</td>    </tr><font size=5>

</tr> 
</thead> <tbody> <font size=3>

<script> 
// DisplayIncubators();
 </script>


</tbody> 
</table> 

<br><hr>



<br><br><br><br><br><br><br><br><br><br><br><br>
<!-- Populate Hackerspace arrays -- aka DisplayHackerspaces(); -->
<?php
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');if (!$con)  {  die('Could not connect: ' . mysql_error());  }
mysql_select_db("hacktus", $con);


	$sql="SELECT * FROM Hackerspaces";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			// This will display the hackerspace info on a table. This duplicates what you see on the map, showing it as a list instead. 
			// Need to put this inside tabs to clean up the look of the site.
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

</body>
</HTML>



</html>

