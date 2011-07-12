<!DOCTYPE html>
<HTML>
<title>PSTING!!!</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<head>
</head>

<?php
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
if (!$con)  {  die('Could not connect: ' . mysql_error());  }
mysql_select_db("hacktus", $con);

mysql_query("UPDATE $_GET[\"tableToPostTo\"] SET LatLng = '$_GET[\"latlng\"]' 
WHERE `Key` = '$_GET[\"i\"]'");


if (!mysql_query($sql,$con))  {  die('Error: ' . mysql_error());  }

mysql_close($con)
?>




<br><br><br>
</HTML>


</body>
</html>

