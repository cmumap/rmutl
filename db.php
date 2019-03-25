<?php
// Opens a connection to a MySQL server.
$connection=mysqli_connect ("localhost", 'root', '','demo');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
} //test

mysqli_set_charset($connection,"utf8");

mysqli_close($connection);

// Sets the active MySQL database.
/*$db_selected = mysqli_select_db($connection,'accounts');
if (!$db_selected) {
    die ('Can\'t use db : ' . mysqli_error($connection));
}*/