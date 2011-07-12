<!DOCTYPE html>
<HTML xmlns="http://www.w3.org/1999/xhtml">
<title>Hactus - The Entrepreneur's Source</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
  html { height: 100% }
  body { height: 100%; background: url("http://www.fractalgames.com/img/desert_background.jpg") 50% 50% no-repeat;}
   TD{font-family: Arial; font-size: 12pt;}
  

div#navbar2 { height: 30px; width: 100%; border-top: solid #000 1px; border-bottom: solid #000 1px; background-color: #336699;}
div#navbar2 ul { margin: 0px; padding: 0px; font-family: Arial, Helvetica, sans-serif; font-size: small; color: #FFF; line-height: 30px; white-space: nowrap;}
div#navbar2 li { list-style-type: none; display: inline;}
div#navbar2 li a { text-decoration: none; padding: 7px 10px; color: #FFF;}
div#navbar2 lia:link { color: #FFF:}
div#navbar2 lia:visited { color: #CCC;}
div#navbar2 lia:hover { font-weight: bold; color: #FFF; background-color: #3366FF; }

td.rounded {
background-image:url("http://www.fractalgames.com/img/tablebox.png");
width:468px;
height:103px;/*whatever size u need for the ends*/
margin:5px 5px 5px 5px;
}

#box-table-a{font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;width:40%;text-align:left;border-collapse:collapse;margin:8px;}#box-table-a th{font-size:18px;font-weight:normal;background:#b9c9fe;border-top:1px solid #aabcfe;border-bottom:1px solid #fff;color:#039;padding:8px;}#box-table-a td{background:#e8edff;border-bottom:1px solid #fff;color:#669;border-top:1px solid transparent;padding:4px;}#box-table-a tr:hover td{background:#d0dafd;color:#339;}

</style>



<head>




<!-- Google Analytics -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20709274-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!-- /Google Analytics -->


</head>

<body bgcolor=CCCCAA>


<center>
<img src="http://www.fractalgames.com/img/hactus_big.png"><br>


<!-- Email Form. Must include insert.php to process the form -->
<br><br><br><br><br><br><br><br><br><br><br><br>
<font size=5 face=arial color=blue> "The Cheat Sheet for Entrepreneurs"
<br><br>
<center>
<table><td class="rounded"> 
<font size=4.9 color=DDDDDD>
<center>
Enter your email to be notified when Hactus is ready!<br><br>

<form action="/php/insert.php" method="POST" cols=40>

<input type="text" name="email" />
<input type="submit" />

</form>

</td></tr></table>





    
<!-- HTML for feeds goes here, got rid of Divs to get tables to look/be aligned right -->





<?php
$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("hacktus", $con);

$sql="INSERT INTO Contacts (Email)
VALUES
('$_POST[email]')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
// echo "Thank you for your interest! You will be notified when Hactus is released.";

mysql_close($con)
?>










<br><br><br>
</HTML>


</body>
</html>

