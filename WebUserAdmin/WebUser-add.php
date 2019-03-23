<?php
	// foreach ($_GET as $key => $value) 
	// {
	// 	$_GET[$key]=addslashes(strip_tags(trim($value)));
	// }
	// if ($_GET['id'] !='') { $_GET['id']=(int) $_GET['id']; }
	// extract($_GET);
?>
<?php include "phpscript/security.php";?>
<?php include_once "Connections/dbconnect.php";?>
<?php
	session_start();
	if (isset($_SESSION['administrator'])&&($_SESSION['userpass'])){}
	else
	{
		header("Location:index.php");
	}
	$error = false;
?>
<?php
	include("phpscript/timeout.php");
	if (isset($_SESSION['administrator'])&&($_SESSION['userpass']))
	{
		if(isLoginSessionExpired())
		{
		header("Location:logout.php?session_expired=1");
		}
	}
?>
            <?php if (isset($_POST['signup'])) 
			{
				$name = mysqli_real_escape_string($con, $_POST['name']);
				$user = mysqli_real_escape_string($con, $_POST['user']);
				$email = mysqli_real_escape_string($con, $_POST['email']);
				$password = mysqli_real_escape_string($con, $_POST['password']);
				$cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
	
				if(!filter_var($email,FILTER_VALIDATE_EMAIL))
				{
					$error = true;
					$email_error = "Please Enter Valid Email ID";
				}
				if(strlen($password) < 10)
				{
					$error = true;
					$password_error = "Password must be minimum of 10 characters";
				}
				if($password != $cpassword)
				{
					$error = true;
					$cpassword_error = "Password and Confirm Password doesn't match";
				}
				if (!$error)
				{
					if(mysqli_query($con, "INSERT INTO officeradmin(name,user,email,password) VALUES('" . $name . "','" . $user . "','" . $email . "', '" . md5($password) . "')")) 
					{
					$successmsg = "Successfully Registered!";
					} 
					else 
					{
					$errormsg = "Error in registering...Please try again later!";
					}
				}
			}
			?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Accounting</title>
	
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">  
	<link href="css/from.css" rel="stylesheet" type="text/css">
    <link href="css/metro.css" rel="stylesheet">
    
</head>

<body>
<div class="panel">
	<div class="panel-header">WebOfficer <b>USER ADD</b></div>
    <div class="panel-main">
    <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
        	<div class="cell">
        	<label><font color="#767676">Input Name</font></label>
     		<div class="input-control select full-size">
       		<input type="text" name="name" required>
       		</div>
        	</div>
           
           <div class="cell">
           <label><font color="#767676">Username</font></label>
            <div class="input-control text full-size">
            <input type="text" name="user" required>
            </div>
            </div>  
            
             <div class="cell">
           <label><font color="#767676">E-Mail</font></label>
            <div class="input-control text full-size">
            <input type="email" name="email"  required value="<?php if($error) echo $email; ?>">
            </div>
            <?php if (isset($email_error)) echo $email_error; ?>
            </div>  
            
           <div class="cell">
           <label><font color="#C7A8A8">Password</font></label>
            <div class="input-control text full-size">
            <input type="password" name="password"  required>
            </div>
            <font color="#FF3333"><?php if (isset($password_error)) echo $password_error; ?></font>
            </div>  
            
           <div class="cell">
           <label><font color="#C7A8A8">Password Again</label></label>
            <div class="input-control text full-size">
             <input type="password" name="cpassword"  required>
            </div>
            <font color="#FF3333"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></font>
            </div>  
              
    </div>
    <div class="panel-bottom">
         	<button class="btn" name="signup">ADD</button>
           	<button class="btn" onclick="window_close();">CLOSE</button>
            <script>
				function window_close()
				{
					window.close()
					window.opener.location.reload();
				}
			</script>
    </div>
    </form>
</div>
    <div class="panel-status">
    <?php if (isset($successmsg)) { echo $successmsg; } ?>
    <?php if (isset($errormsg)) { echo $errormsg; } ?>
    </div>
</body>
</html>