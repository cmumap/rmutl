<?
	foreach ($_GET as $key => $value) 
	{
		$_GET[$key]=addslashes(strip_tags(trim($value)));
	}
	if ($_GET['id'] !='') { $_GET['id']=(int) $_GET['id']; }
	extract($_GET);
?>
<?php include "phpscript/security.php";?>
<?php include_once "Connections/dbconnect.php";?>
<?php include_once "Connections/dbconfig.php";?>
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
<?php
	error_reporting( ~E_NOTICE );
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT name, user, email, password FROM officeradmin WHERE user_id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
	?>
    	<script>
	function window_close()
				{
					window.close()
					window.opener.location.reload();
				}
	</script>
    <?
	}	
	if(isset($_POST['btn_save_updates']))
	{
		$name = $_POST['name'];
		$user = $_POST['user'];
		$mail = $_POST['email'];
		$pass = $_POST['password'];
						
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE officeradmin SET name=:uname, user=:uuser, email=:uemail, password=:upass WHERE user_id=:uid');
					
			$stmt->bindParam(':uname',$name);
			$stmt->bindParam(':uuser',$user);
			$stmt->bindParam(':uemail',$mail);
			$stmt->bindParam(':upass',$pass);
			$stmt->bindParam(':uid',$id);
								
			if($stmt->execute())
			{
			?>
          	<script>
			alert('Successfully Updated ...');
			//window.close()
			window.opener.location.reload();
			</script>
            <?php
			}
			else
			{
				$errMSG = "Sorry Data Could Not Updated !";
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
	<div class="panel-header">WebOfficer <b>USER EDIT</b></div>
    <div class="panel-main">
    <form method="post" enctype="multipart/form-data" class="form-horizontal">
        	<!-- Name -->
           	<div class="cell">
           	<label><font color="#767676">Name</font></label>
            <div class="input-control text full-size">
            <input type="text" name="name" type="text" value="<? echo $name; ?>">
            </div>
            </div> 
           <!-- Username -->
           <div class="cell">
           <label><font color="#767676">Username</font></label>
            <div class="input-control text full-size">
            <input type="text" name="user" type="text" value="<? echo $user ?>">
            </div>
            </div>  
            <!-- E-mail -->
             <div class="cell">
           <label><font color="#767676">E-Mail</font></label>
            <div class="input-control text full-size">
            <input type="text" name="email" type="text"value="<? echo $email ?>">
            </div>
            </div>  
            <!-- password -->
           <div class="cell">
           <label><font color="#767676">Password</font></label>
            <div class="input-control text full-size">
            <input type="text" name="password" type="text" 
            value="<? echo $password ?>" disabled>
            </div>
            </div>  
              
    </div>
    <div class="panel-bottom">
			<input type="submit" name="btn_save_updates" value="SAVE" class="btn" />
           	<input type="button" value="CLOSE" onclick="window_close();" title="close" class="btn">
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
</body>
</html>