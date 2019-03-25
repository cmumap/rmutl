<?php
session_start();
echo "swal('Logout!', 'You clicked the button!', 'success');";
unset($_SESSION["administrator"]);
unset($_SESSION["username"]);
unset($_SESSION["userpass"]);

?>
<?php

	$url = "../logout.php";
	if(isset($_GET["session_expired"]))
	{
		$url .= "?session_expired=" . $_GET["session_expired"];
	}
	header("Location:$url");
?>
<?php
	echo "<meta http-equiv='refresh' content='1;url=index.php'>";
?>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

