<?php
	$con = mysql_connect('fractalgamescom.ipagemysql.com', 'fractalgamescom', 'energy420');
	if (!$con)  {  die('Could not connect: ' . mysql_error());  }
	mysql_select_db("hacktus", $con);
	
//	$tableName   = htmlspecialchars(trim($_POST['tableName']));
	
	$sql="DELETE FROM $_POST[tableName]";

	
	if (!mysql_query($sql,$con))  {  die('Error: ' . mysql_error());  }
	mysql_close($con);
	
	// random backup of hactus.com emails
	
	/*
	<br>9 brandon@startupbus.com<br>19 re_phil@web.de<br>21 litwak1@gmail.com<br>25 anatoly@geyfman.net<br>67 606@com.com<br>71 
kev@inburke.com<br>73 alexle@marrily.com<br>89 a@A.a<br>107 carl@carlsue.com<br>134 z.xuwen@gmail.com<br>137 
shirleylinc@gmail.com<br>147 thinkbiz03@gmail.com<br>172 john<br>174 kaykim@kaykim.org<br>175 john.v.schmitt@gmail<br>176 
john.v.schmitt@gmail<br>179 john.v.schmitt@gmail.com<br>182 kecordero@gmail.com<br>196 Andy.Lammers@gmail.com<br>199 
jeannemariani@gmail.com<br>213 Joseariel1@gmail.com<br>216 ctheunseen@gmail.com<br>218 que2ny@gmail.com<br>228 
paranoiase@gmail.com<br>241 jazzviolin93@hotmail.com<br>250 diego@blog364.com<br>252 danxr@aol.com<br>255 jaigouk@gmail.com<br>263 
jay.on.nanaimo@gmail.com<br>278 jeein.kim@me.com<br>291 Nedrra@BrighterFutureChallenge.com<br>299 cloudjsp@gmail.com<br>305 
aberthelot@gmail.com<br>307 thorsten.claus@gmail.com<br>308 robert.lee@mba.berkeley.edu<br>314 noah.kim@ppling.com<br>317 
cogsys@gmail.com<br>326 markus@thebroth.com
*/
?>

