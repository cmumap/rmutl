<?php
// if(!mysql_connect("127.0.0.1","root","")) { die('oops connection problem ! --> '.mysql_error()); }
// if(!mysql_select_db("geolocate")) { die('oops database selection problem ! --> '.mysql_error()); }
?>
<?php
	$con = mysqli_connect("127.0.0.1", "root", "", "demo") or die("Error " . mysqli_error($con));
?>