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
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT event_title, event_des, event_link, event_Latitude, event_Longitude, event_icon FROM eventarea WHERE event_id =:uid');
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
    <?php
	}	
	if(isset($_POST['btn_save_updates']))
	{

		$title = $_POST['eventtitle'];
		$des = $_POST['eventdes'];
		$link = $_POST['eventlink'];
		$Latitude = $_POST['eventLatitude'];
		$Longitude = $_POST['eventLongitude'];	
		
		$imgFile = $_FILES['eventicon']['name'];
		$tmp_dir = $_FILES['eventicon']['tmp_name'];
		$imgSize = $_FILES['eventicon']['size'];
				
		if($imgFile)
		{
			$upload_dir = '../icon/';	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
			$valid_extensions = array('jpeg', 'jpg','png');
			date_default_timezone_set('Asia/Bangkok');
			$icon = "EventArea-".date('Ymd-His').".".$imgExt;
					
					if(in_array($imgExt, $valid_extensions))
					{			
						if($event_icon == null) { move_uploaded_file($tmp_dir,$upload_dir.$icon); }
						else if($event_icon != null)
						{
							unlink($upload_dir.$edit_row['event_icon']);
							move_uploaded_file($tmp_dir,$upload_dir.$icon);
						}
					}
					else { $errMSG = "Sorry, only JPG & JPEG files are allowed.";	}	
				}
				else { $icon = $edit_row['event_icon'];
			}	
		
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE eventarea SET event_title=:utitle, event_des=:udes, event_link=:ulink, event_Latitude=:ulatitude, event_Longitude=:ulongitude, event_icon=:uicon WHERE event_id=:uid');

			$stmt->bindParam(':utitle',$title);
			$stmt->bindParam(':udes',$des);
			$stmt->bindParam(':ulink',$link);
			$stmt->bindParam(':ulatitude',$Latitude);
			$stmt->bindParam(':ulongitude',$Longitude);
			$stmt->bindParam(':uicon',$icon);
			$stmt->bindParam(':uid',$id);

								
			if($stmt->execute())
			{
			?>
				<script>
                alert('Successfully Updated ...');
                window.close()
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
	<div class="panel-header"><font color="#767676">Event Area</font><b> EDIT</b></div>
    <form method="post" enctype="multipart/form-data" class="form-horizontal">
               
        <div class="panel-mainhalfL">   
            <div class="cell"><font color="#767676">Title</font>
            <div class="input-control text full-size">
            <input type="text" name="eventtitle" value="<?php echo $event_title; ?>">
            </div>
            </div> 
        </div>
            
          <div class="panel-mainhalfR">       
   		<div class="cell"><font color="#767676">External Link</font>
   		<div class="input-control text full-size">
  		<input type="text" name="eventlink" value="<?php echo $event_link; ?>">
   		</div>
    	</div>  
   	</div>
     
     <div class="panel-main">            
        <div class="cell"><font color="#767676">Description</font>
        <div class="input-control textarea full-size">
        <input type="text" name="eventdes" value="<?php echo $event_des; ?>">
        </div>
        </div>
    </div>

    <div class="panel-mainhalfL">
   		<div class="cell"><font color="#767676">Latitude Edit</font>
   		<div class="input-control text full-size">
  		<input type="text" class="float" name="eventLatitude" value="<?php echo $event_Latitude; ?>">
   		</div>
    	</div>  
   	</div>
  	
    <div class="panel-mainhalfR">
   		<div class="cell"><font color="#767676">Longtitude Edit</font>
   		<div class="input-control text full-size">
  		<input type="text" class="float" name="eventLongitude" value="<?php echo $event_Longitude; ?>">
   		</div>
    	</div>  
    </div>

    <div class="panel-mainhalfL">           
       	<div class="cell">
       	<label><font color="#767676">PIN ICON</font> <font color="#8E4748">***Square scale only. Ex. 24 x 24px</font></label>
    	<div class="input-control file full-size" data-role="input">
       	<input type="file" name="eventicon" accept="image/*">
     	<button class="button"><span class="mif-folder"></span></button>
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
    <div class="panel-status">
    	<?php if(isset($errMSG)) { ?>
		<?php echo $errMSG; ?>
    	<?php } else if(isset($successMSG)) { ?>
		<?php echo $successMSG; ?>
    	<?php } ?>   
    </div>
    </form>
</div>
</body>
</html>