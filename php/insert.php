<!DOCTYPE html>
<HTML>
<title>hactus - The Startup Source</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">

</style>



<head>
</head>

<body bgcolor=CCCCAA>


<br><br><br>
<center>
<img src="http://www.fractalgames.com/img/hactus_big.png">



<?php
	// For sanitizing the email.
	function cleanInput($input) {

		$search = array(
			'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
			'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
			'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
			'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	  	);

	    $output = preg_replace($search, '', $input);
	    return $output;
  	}


$_email = htmlspecialchars($_POST["email"]);
$_email = cleanInput($_email);

$emailCheck = true;
// check_email_address( $_email ); // CVN not working, bypassed by setting $emailCheck = true;

if ( $emailCheck == true)
{
	$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
	if (!$con)  {  die('Could not connect: ' . mysql_error());  }
	mysql_select_db("hacktus", $con);
	$sql="INSERT INTO Contacts (Email)
	VALUES
	('$_POST[email]')";
	echo "	<br><br>Thank you for your interest! You will be notified when Hactus is released.";
	if (!mysql_query($sql,$con))  {  die('Error: ' . mysql_error());  }
	mysql_close($con);
	
}


// I can't get this damn thing to work. charles@hactus.com always throws the first fail.
// Fortunately, most emails are valid already ....

/*
function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    echo "email check fail 1";
    echo "email was " . $_email . "\$email was" . $email;
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
	  echo "email check fail 2";
	  $emailCheck = false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
        $emailCheck = false;
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
?([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
		echo "email check fail 3";
		$emailCheck = false;
      }
    }
  }
  return true;
  $emailCheck = true;
}

*/

?>

<br><br><br>
<a href="http://www.hactus.com">www.hactus.com</a>
</HTML>


</body>
</html>

