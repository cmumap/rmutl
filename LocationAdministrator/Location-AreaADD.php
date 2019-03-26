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
	
		$des = $_POST['locatedes'];
		$Latitude = $_POST['locateLatitude'];
		$Longitude = $_POST['locateLongitude'];
		$type = $_POST['locatetype'];
		$url = $_POST['locateurl'];
		
		// $imgFile = $_FILES['locateicon']['name'];
		// $tmp_dir = $_FILES['locateicon']['tmp_name'];
		// $imgSize = $_FILES['locateicon']['size'];
				
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO locations (lat, lng, description, type, url) VALUES(:p1, :p2, :p3, :p4, :p5)');
			$stmt->bindParam(':p1',$Latitude);
			$stmt->bindParam(':p2',$Longitude);
			$stmt->bindParam(':p3',$des);
			$stmt->bindParam(':p4',$type);
			$stmt->bindParam(':p5',$url);
			
			if($stmt->execute())
			{
				$successMSG = "new record succesfully inserted ...";
				header("refresh:3;Location-AreaADD.php");
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
<form action="" method="POST">
<div class="panel">
	<div class="panel-header"><font color="#767676">Location Area</font><b> EDIT</b></div>
           
        <div class="panel-main">   
            <div class="cell"><font color="#767676">Description</font>
            <div class="input-control text full-size">
            <input type="text" name="locatedes">
            </div>
            </div> 
        </div>
        
        <!-- <div class="panel-mainhalfR">
            <div class="cell"><font color="#767676">Title</font>
            <div class="input-control text full-size">
            <input type="text" name="locatetitle" value="<? echo $locate_title; ?>">
            </div>
            </div> 
        </div> -->
     
     <!-- <div class="panel-main">            
        <div class="cell"><font color="#767676">Description</font>
        <div class="input-control textarea full-size">
        <input type="text" name="locatedes" value="<? echo $description; ?>">
        </div>
        </div>
    </div> -->

    <div class="panel-mainhalfL">
   		<div class="cell"><font color="#767676">Latitude Add</font>
   		<div class="input-control text full-size">
  		<input type="text" class="float" name="locateLatitude">
   		</div>
    	</div>  
   	</div>
  	
    <div class="panel-mainhalfL">
   		<div class="cell"><font color="#767676">Longtitude Add</font>
   		<div class="input-control text full-size">
  		<input type="text" class="float" name="locateLongitude">
   		</div>
    	</div>  
    </div>
    
    <div class="panel-mainhalfL">
   		<div class="cell"><font color="#767676">Location Type</font>
   		<div class="input-control text full-size">
			   <select name="locatetype" id="mheeselect">
					<option value="ธนาคาร"> ธนาคาร </option>
					<option value="โรงอาหาร">โรงอาหาร</option>
					<option value="ตู้ ATM">ตู้ ATM</option>
					<option value="ป้ายรถม่วง">ป้ายรถม่วง</option>
					<option value="ร้านกาแฟ">ร้านกาแฟ</option>

			   
			   </select>
   		</div>
    	</div>  
   	</div>
    
    <div class="panel-mainhalfL">
   		<div class="cell"><font color="#767676">URL</font>
   		<div class="input-control text full-size">
  		<input type="text" name="locateurl" value="<? echo $url; ?>">
   		</div>
    	</div>  
   	</div>

    <!-- <div class="panel-mainhalfL">           
       	<div class="cell">
       	<label><font color="#767676">PIN ICON</font> <font color="#8E4748">***Square scale only. Ex. 24 x 24px & Don't spacing for file name upload.</font></label>
    	<div class="input-control file full-size" data-role="input">
       	<input type="file" name="locateicon" accept="image/*">
     	<button class="button"><span class="mif-folder"></span></button>
       	</div>
     	</div>  
    </div> -->

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