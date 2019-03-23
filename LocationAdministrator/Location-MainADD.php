<?php include "phpscript/security.php";?>
<?php include_once "connections/dbconnect.php";?>
<?php include_once "connections/dbconfig.php";?>
<?php

	session_start();
	if (isset($_SESSION['administrator'])&&($_SESSION['userpass'])){}
	else
	{
		header("Location:index.php");
	}
	include_once 'connections/dbconnect.php';
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
	if(isset($_POST['btnsave']))
	{

		$Latitude = $_POST['Latitude'];
		$Longitude = $_POST['Longitude'];
		$Zoom = $_POST['Zoom'];
		
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO location(Latitude, Longitude, Zoom) VALUES(:ulatitude, :ulongitude , :uzoom)');
			$stmt->bindParam(':ulatitude',$Latitude);
			$stmt->bindParam(':ulongitude',$Longitude);
			$stmt->bindParam(':uzoom',$Zoom);

			
			if($stmt->execute())
			{
				$successMSG = "new record succesfully inserted ...";
				header("refresh:3;Location-MainADD.php");
			}
			else
			{
				$errMSG = "error while inserting....";
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
    <link href="css/metro-icons.css" rel="stylesheet">
    <link href="css/metro-responsive.css" rel="stylesheet">
    <link href="css/metro-schemes.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    
    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/metro.js"></script>
    <script src="js/docs.js"></script>
    <script src="js/prettify/run_prettify.js"></script>
    <script src="js/ga.js"></script>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script type="text/javascript" >
		$(".float").bind( "keyup", function(e)
		{
     	var ch=$(this).val(); 
    	var digit; 
    	for(var i=0 ; i<ch.length ; i++)
    	{
        	digit = ch.charAt(i)
        	if(digit >="0" && digit <="9") { }
			else if(digit!=".")
			{ $(this).val($(this).val().replace(digit,"")); }
		} 
		});

</script>
</head>

<body>
<div class="panel">
	<div class="panel-header"><font color="#767676">Main Location</font><b> ADD</b></div>
    <form method="post" enctype="multipart/form-data" class="form-horizontal">
           
    <div class="panel-mainhalfL">
   		<div class="cell"><font color="#767676">Latitude Add</font>
   		<div class="input-control text full-size">
  		<input type="text" class="float" name="Latitude" placeholder="Latitude Add" required>
   		</div>
    	</div>  
   	</div>
  	
    <div class="panel-mainhalfR">
   		<div class="cell"><font color="#767676">Longtitude Add</font>
   		<div class="input-control text full-size">
  		<input type="text" class="float" name="Longitude" placeholder="Longitude Add" required>
   		</div>
    	</div>  
    </div>
    
    <div class="panel-mainhalfL">
   		<div class="cell"><font color="#767676">Location Zoom</font>
   		<div class="input-control text full-size">
  		<input type="number" name="Zoom" placeholder="Zoom Range" required>
   		</div>
    	</div>  
   	</div>
    
    <div class="panel-bottom">
         	<input type="submit" name="btnsave" value="SAVE" class="btn" />
           	<input type="button" value="CLOSE" onclick="window_close();" title="close" class="btn">
            <script>
				function window_close()
				{
					window.close()
					window.opener.location.reload();
				}
			</script>
    </div>
    <div class="panel-status">
    	<? if(isset($errMSG)) { ?>
		<? echo $errMSG; ?>
    	<? } else if(isset($successMSG)) { ?>
		<? echo $successMSG; ?>
    	<? } ?>   
    </div>
    </form>
</div>
</body>
</html>