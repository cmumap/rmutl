<?php
// if(!mysql_connect("localhost","root","")) { die('oops connection problem ! --> '.mysql_error()); }
// if(!mysql_select_db("geolocate")) { die('oops database selection problem ! --> '.mysql_error()); }
?>
<?php
	$con = mysqli_connect("localhost", "root", "", "demo") or die("Error " . mysqli_error($con));
	mysqli_set_charset($con,"utf8");
?>