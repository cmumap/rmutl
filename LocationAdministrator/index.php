<?php include "phpscript/security.php";?>
<?php
	session_start();
	if(isset($_SESSION['administrator'])!="")
	{
		header("Location: Location-Area.php");
	}

	include_once 'connections/dbconnect.php';
	include("phpscript/timeout.php");

if (isset($_POST['login'])) {
	
	$user = mysqli_real_escape_string($con, $_POST['user']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$result = mysqli_query($con, "SELECT * FROM officeradmin WHERE user = '" . $user. "' and password = '" . md5($password) . "'");
	$row = mysqli_fetch_array($result);
	if($row['password']==md5($password))
	{
		$_SESSION['administrator'] = $row['user_id'];
		$_SESSION['username'] = $row['name'];
		$_SESSION['userpass'] = $row['password'];
		$_SESSION['loggedin_time'] = time();
		header("Location: Location-Area.php");
	} else {
		$errormsg = "Incorrect User and Password or Account Disallow on system.";
	}
	
	if(isset($_SESSION["administrator"]))
	{
		if(!isLoginSessionExpired())
		{
		header("Location: Location-Area.php");
		} 
		else
		{
		header("Location:logout.php?session_expired=1");
		}
	}
	if(isset($_GET["session_expired"]))
	{
		$message = "Login Session is Expired. Please Login Again";
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GIS-TAXMAP </title>

<link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
<link rel="stylesheet" href="css/index.css">

</head>
<body>
<body>
<body class="align">
	<div class="site__container">
    <div class="grid__container">
    	<p class="text--style">
        <font color="#FFFFFF" size="+2"><b>GIS TAX MAP</b></font> <b><font color="#999999" size="+2">Web Officer</font></b>
        <br>
        <br>
        </p>
      	<form action="index.php" method="post" name="checkForm" id="checkForm" class="form form--login">
        <div class="form__field">
        <label class="fontawesome-user" for="login__username"><span class="hidden">Username</span></label>
        <input id="login__username" type="text" class="form__input" placeholder="Username" name="user" required autocomplete="off"/>
        </div>
        <div class="form__field">
        <label class="fontawesome-lock" for="login__password"><span class="hidden">Password</span></label>
        <input id="login__password" type="password" class="form__input" placeholder="Password" name="password" required autocomplete="off"/>
        </div>
        <div class="form__field">
        <input type="submit" name="login" value="log in">
        </div>
        <?php if (isset($errormsg)) { echo $errormsg; } ?>
        <?php if (isset($message)) { echo $message; } ?>
      	</form>
      	<p class="text--style">
        <br>
        <font color="#FFFFFF">Copyright © 2018  by Guitar Story. All rights reserved.</font>
        </p>
    </div>
	</div>

</body>
</html>