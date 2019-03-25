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
		$province = $_POST['locateprovince'];
		$title = $_POST['locatetitle'];
		$des = $_POST['locatedes'];
		$Latitude = $_POST['locateLatitude'];
		$Longitude = $_POST['locateLongitude'];
		$zoom = $_POST['locatezoom'];
		$url = $_POST['locateurl'];
		
		$imgFile = $_FILES['locateicon']['name'];
		$tmp_dir = $_FILES['locateicon']['tmp_name'];
		$imgSize = $_FILES['locateicon']['size'];
				
 		if(empty($imgFile)){
			$errMSG = "You don't insert image.";
		}
		else
		{
			$upload_dir = '../icon/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg','png'); // valid extensions
		
			// rename uploading image
			date_default_timezone_set('Asia/Bangkok');
			$icon = "AraeLocate-".date('Ymd-His').".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions))
			{			
				// Check file size '5MB'
				if($imgSize < 10485760)	
				{
					move_uploaded_file($tmp_dir,$upload_dir.$icon);
				}
				else
				{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG files are allowed.";		
			}
		}
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO maplocate(locate_province, locate_title, locate_des, locate_Latitude, locate_Longitude, locate_zoom, locate_url, locate_icon) VALUES(:uprovince, :utitle, :udes, :ulatitude, :ulongitude, :uzoom, :uurl, :uicon)');
			$stmt->bindParam(':uprovince',$province);
			$stmt->bindParam(':utitle',$title);
			$stmt->bindParam(':udes',$des);
			$stmt->bindParam(':ulatitude',$Latitude);
			$stmt->bindParam(':ulongitude',$Longitude);
			$stmt->bindParam(':uzoom',$zoom);
			$stmt->bindParam(':uurl',$url);
			$stmt->bindParam(':uicon',$icon);
			
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
<div class="panel">
	<div class="panel-header"><font color="#767676">Location Area</font><b> ADD</b></div>
    <form method="post" enctype="multipart/form-data" class="form-horizontal">
           
        <div class="panel-mainhalfL">   
            <div class="cell"><font color="#767676">Event Name</font>
            <div class="input-control text full-size">
            <input type="text" name="locateprovince" placeholder="Event create" required>
            </div>
            </div> 
        </div>
        
        <div class="panel-mainhalfR">
            <div class="cell"><font color="#767676">Title</font>
            <div class="input-control text full-size">
            <input type="text" name="locatetitle" placeholder="Title" required>
            </div>
            </div> 
        </div>
     
     <div class="panel-main">            
        <div class="cell"><font color="#767676">Description</font>
        <div class="input-control textarea full-size">
        <input type="text" name="locatedes" placeholder="Description" required>
        </div>
        </div>
    </div>

    <div class="panel-mainhalfL">
   		<div class="cell"><font color="#767676">Latitude Add</font>
   		<div class="input-control text full-size">
  		<input type="text" class="float" name="locateLatitude" placeholder="Latitude" required>
   		</div>
    	</div>  
   	</div>
  	
    <div class="panel-mainhalfR">
   		<div class="cell"><font color="#767676">Longtitude Add</font>
   		<div class="input-control text full-size">
  		<input type="text" class="float" name="locateLongitude" placeholder="Longitude" required>
   		</div>
    	</div>  
    </div>
    
    <div class="panel-mainhalfL">
   		<div class="cell"><font color="#767676">Location Zoom</font>
   		<div class="input-control text full-size">
  		<input type="number" name="locatezoom" placeholder="Zoom" required>
   		</div>
    	</div>  
   	</div>
    
    <div class="panel-mainhalfR">
   		<div class="cell"><font color="#767676">URL</font>
   		<div class="input-control text full-size">
  		<input type="text" name="locateurl" placeholder="URL" required>
   		</div>
    	</div>  
   	</div>

    <div class="panel-mainhalfL">           
       	<div class="cell">
       	<label><font color="#767676">PIN ICON</font> <font color="#8E4748">***Square scale only. Ex. 24 x 24px & Don't spacing for file name upload.</font></label>
    	<div class="input-control file full-size" data-role="input">
       	<input type="file" name="locateicon" accept="image/*">
     	<button class="button"><span class="mif-folder"></span></button>
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