<?php
echo phpinfo();
/*
echo $today = date("F j, Y, g:i a")."<br>";                 
if(function_exists('date_default_timezone_set')) {
	echo "<br><br>inside function<br><br>";
		date_default_timezone_set('America/New_York');
}
echo "<br><br>";
echo $today = date("F j, Y, g:i a")."<br><br>";                 
include(dirname(__FILE__) . "/init.php");
echo "<br><br>custom time: ".$n = isc_mktime();
echo $today = date("F j, Y, g:i a")."<br>";                 
echo "time ".time()."<br>";
*/
mail("baskaran.b@clariontechnologies.co.in","Test","Content");
?>