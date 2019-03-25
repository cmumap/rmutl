<?php
	foreach ($_GET as $key => $value) 
	{
		$_GET[$key]=addslashes(strip_tags(trim($value)));
	}
	if ($_GET['id'] !='') { $_GET['id']=(int) $_GET['id']; }
	extract($_GET);
?>
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
	if(isset($_GET['view_id']) && !empty($_GET['view_id']))
	{
		$id = $_GET['view_id'];
		$stmt_view = $DB_con->prepare('SELECT locate_province, locate_title, locate_des, locate_Latitude, locate_Longitude, locate_zoom, locate_url, locate_icon FROM maplocate WHERE locate_url =:uid');
		$stmt_view->execute(array(':uid'=>$id));
		$view_row = $stmt_view->fetch(PDO::FETCH_ASSOC);
		extract($view_row);
	}
	else{}
?>
<!doctype html>
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
   	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">

	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
    <link href="css/administratorCSS.css" rel="stylesheet" type="text/css">
    <link href="css/jquery.dataTables.css" rel="stylesheet" type="text/css">
	<link href="css/shCore.css" rel="stylesheet" type="text/css">
	<link href="css/demo.css" rel="stylesheet" type="text/css">
    
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
    <script src="js/responsive-nav.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="js/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="js/demo.js"></script>
	<script src="js/jquery.menu-aim.js"></script>
	<script src="js/main.js"></script>
  
	<script type="text/javascript" language="javascript" class="init">
	$(document).ready(function() {$('#example').dataTable();} );
    </script>
       
	<script>
	  function CenterWindow(windowWidth, windowHeight, windowOuterHeight, url, wname, features) {
		var centerLeft = parseInt((window.screen.availWidth - windowWidth) / 2);
		var centerTop = parseInt(((window.screen.availHeight - windowHeight) / 2) - windowOuterHeight);
	 
		var misc_features;
		if (features) {
		  misc_features = ', ' + features;
		}
		else {
		  misc_features = ', status=no, location=no, scrollbars=yes, resizable=yes';
		}
		var windowFeatures = 'width=' + windowWidth + ',height=' + windowHeight + ',left=' + centerLeft + ',top=' + centerTop + misc_features;
		var win = window.open(url, wname, windowFeatures);
		win.focus();
		return win;
 	 }
	</script>
  	
<title>EXO CNX Travel Map by Yuii Napat</title>
</head>
<body>

 <!-- Header -->
<header class="cd-main-header"><?php include "include-header.php"; ?></header>

<main class="cd-main-content">
		
        <!-- Navigation -->
        <div class="cd-side-nav"><?php include "include-menu.php"; ?></div>

		<!-- Main Content -->
        <div class="content-wrapper">
        
        <!-- Header  -->
        <div id="panel-fullarea">
        <div class="panelfooter">
        <div class="panel-title"><font size="+2"><?php echo $locate_province; ?></font></div> 
        </div>
        </div>   
        
   		<!-- Data Table  -->
        <div id="panel-fullarea">
   	    <div class="panelfull">
        <div class="panel-fullheader">
        <div class="panel-icon">
        <a onClick="CenterWindow(1024,768,10,'Location-EventAreaADD.php?up_id=<?php echo $id; ?>',''); " href="javascript:void(0);"><img src="img/icon-add.png" /></a> 
        </div>
     	</div> 
               		<div class="page">
					<section>
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th style="text-align:centert">no.</th>
                                <th style="text-align: center">title</th>
                                <th style="text-align: center">description</th>
                                <th style="text-align: center">latitude & longitude</th>
                                <th style="text-align:centert">icon</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							if(isset($_GET['delete_id']))
							{
								// Delete image & file in DB
								$stmt_select = $DB_con->prepare('SELECT event_icon, event_pic FROM eventarea WHERE event_id =:uid');
								$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
								$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
								unlink("../icon/".$imgRow['event_icon']);		
								unlink("../icon/".$imgRow['event_pic']);		
								
								// Delete record in DB
								$stmt_delete = $DB_con->prepare('DELETE FROM eventarea WHERE event_id =:uid');
								$stmt_delete->bindParam(':uid',$_GET['delete_id']);
								$stmt_delete->execute();
								
								echo "<meta http-equiv='refresh' content='0;URL=Location-EventArea.php?view_id=$view_id'>";
							}
							?>
                             <?php							 
								$n=1;
								$stmt = $DB_con->prepare('SELECT event_id, locate_url, event_title, event_des, event_link, event_Latitude, event_Longitude, event_icon,event_pic FROM eventarea ORDER BY event_id DESC');
								$stmt->execute();	
								if($stmt->rowCount() > 0)
      							{									
									while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        							{ 	extract($row);  
										if($locate_url == $id )
										{   
      						?>
							<tr>
                                 	<td valign="middle"><center><?php echo "$n";?></center></td>
                                    <td valign="middle"><?php echo $event_title; ?></td>
                                    <td valign="middle"><?php echo $event_des; ?></td>                    
                                    <td valign="middle"><?php echo $event_Latitude; ?> , <?php echo $event_Longitude; ?></td>
                                    <td valign="middle"><center><img src="../icon/<?php echo $event_icon; ?>" alt=""/></center></td>  
                                    <td valign="middle"><center><img src="../icon/<?php echo $event_pic; ?>" alt="" width="50px"/></center></td>
                              		<td valign="middle"><center><a href="#" onClick="CenterWindow(600,400,10,'Location-EventAreaPIC.php?edit_id=<?php echo $row['event_id']; ?>',''); " href="javascript:void(0);" title="click for edit" ><img src="img/icon-upload.png" alt=""/></a></center></td>
                              <td valign="middle"><center><a href="#" onClick="CenterWindow(1024,768,10,'Location-EventAreaEDIT.php?edit_id=<?php echo $row['event_id']; ?>',''); " href="javascript:void(0);" title="click for edit" ><img src="img/icon-edit.png" alt=""/></a></center></td>
                                    <td valign="middle"><center><a onClick="return confirm('Do you want to delete?');" href="?delete_id=<?php echo $row['event_id']; ?>&view_id=<?php echo $row['locate_url']; ?>" onSubmit="return confirm('Do you want to delete?');" title="click for delete"><img src="img/icon-delete.png" alt=""/></a>
                              </center></td>
				  			</tr> 
      						<?php $n++; } } } else { ?>
   							<?php } ?>
                            </tbody>
                        </table>
					</section>
					</div>
        </div>
        </div>
        <!-- End of Data Table  -->     
        
        <!-- Footer -->     
        <div id="panel-fullarea">
        <div class="panelfooter">
        <div class="panel-iconlist"><img src="img/icon-addview.png" alt=""/></div>
        <div class="panel-detail">ADD</div>
        <div class="panel-iconlist"><img src="img/icon-image.png" alt=""/></div>
        <div class="panel-detail">PICTURE VIEW</div>
        <div class="panel-iconlist"><img src="img/icon-upload.png" alt=""/></div>
        <div class="panel-detail">PICTURE VIEW</div>
        <div class="panel-iconlist"><img src="img/icon-edit.png" alt=""/></div>
        <div class="panel-detail">EDIT</div> 
        <div class="panel-iconlist"><img src="img/icon-delete.png" alt=""/></div>
        <div class="panel-detail">DELETE</div> 
        </div>
        </div>   
        
</div>
</main>
</body>
</html>