<?php
session_start();
unset($_SESSION["administrator"]);
unset($_SESSION["user"]);
unset($_SESSION["username"]);
unset($_SESSION["userpass"]);
?>
<?php
	$url = "index.php";
	if(isset($_GET["session_expired"]))
	{
		$url .= "?session_expired=" . $_GET["session_expired"];
	}
	header("Location:$url");
?>
<?php
	echo "<meta http-equiv='refresh' content='1;url=index.html'>";
?>