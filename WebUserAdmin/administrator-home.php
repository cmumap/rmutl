<?php
	// foreach ($_GET as $key => $value) 
	// {
	// 	$_GET[$key]=addslashes(strip_tags(trim($value)));
	// }
	// if ($_GET['id'] !='') { $_GET['id']=(int) $_GET['id']; }
	// extract($_GET);
?>
<?php include "phpscript/security.php";?>
<?php include_once "Connections/dbconfig.php";?>
<?php
	session_start();
	if (isset($_SESSION['administrator'])&&($_SESSION['userpass'])){}
	else
	{
		header("Location:index.php");
	}
	include_once 'Connections/dbconnect.php';
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
	if(isset($_GET['delete_id']))
	{		
		$stmt_delete = $DB_con->prepare('DELETE FROM officeradmin WHERE user_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
		header("Location: administrator-home.php");
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>WebOfficer ADMINISTRATOR</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
  	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alex+Brush" rel="stylesheet">
	
	<link rel="stylesheet" href="styles.css">
	<link href="css/administratorCSS.css" rel="stylesheet" type="text/css">
    <link href="css/jquery.dataTables.css" rel="stylesheet" type="text/css">
	<link href="css/shCore.css" rel="stylesheet" type="text/css">
	<link href="css/demo.css" rel="stylesheet" type="text/css">
	
	<script src="js/responsive-nav.js"></script>
    <script src="js/responsive-nav.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="js/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="js/demo.js"></script>
  
	<script type="text/javascript" language="javascript" class="init">
	$(document).ready(function() {$('#example').dataTable();} );
    </script>
       
	<script>
	  /**
	   * Opens window screen centered.
	   * @param windowWidth the window width in pixels (integer)
	   * @param windowHeight the window height in pixels (integer)
	   * @param windowOuterHeight the window outer height in pixels (integer)
	   * @param url the url to open
	   * @param wname the name of the window
	   * @param features the features except width and height (status, toolbar, location, menubar, directories, resizable, scrollbars)
	   */
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
    
  </head>
  <body>
  
  			<!--LightBoxADD-->

    		<!--END LightBoxADD-->
            
            <!--LightBoxTransfer-->

    		<!--END LightBoxTransfer-->
            
	<!--MENU-->
    <div role="navigation" id="foo" class="nav-collapse">
	<?php include "menu-include.php" ?>
    </div>
 	
    <!--Main Page-->
    <div role="main" class="main">
     <a href="#nav" class="nav-toggle">Menu</a>     
    
     <!--Header-->
     <div id="header-main">
     WebOfficer <font color="#000000">Administrator</font>
     </div>
     <div id="header-title">
     User Online : <b><font color="#000000"><?php echo $_SESSION['username']; ?></font></b>
     </div>
     <!--End Header-->

     <!--Main Detial-->
     <!-- Panel -->     
     <div id="panel">
     <div id="panel-fullarea">
     	<div class="panelfull">
        <div class="panel-fullheader">
        <a onClick="CenterWindow(700,550,50,'WebUser-add.php',''); " href="javascript:void(0);">ADD NEW USER</a>
        </div> 
        
         <!-- Data Table  -->
               		<div class="page">
					<section>
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                         		<th>NO.</th>
								<th>NAME</th>
                        		<th>USERNAME</th>
                                <th>E-MAIL</th>
                      			<th>TOOLS</th>
                                </tr>
                            </thead>
                            <tbody>
   					<?php
					$n=1;
					$stmt = $DB_con->prepare('SELECT user_id, name, user, email FROM officeradmin ORDER BY user_id desc');
					$stmt->execute(); 
					if($stmt->rowCount() > 0)
					{
						while($row=$stmt->fetch(PDO::FETCH_ASSOC))
						{
							extract($row);					
					?>
					<tr>
						<td align="center"><?php echo "$n";?></td>
						<td><?php echo $name; ?></td>
                        <td align="center"><?php echo $user; ?></td>
                        <td align="center"><?php echo $email; ?></td>
                      	<td align="center">
                        <a href="#" onClick="CenterWindow(800,600,10,'WebUser-edit.php?edit_id=<?php echo $user_id; ?>',''); " href="javascript:void(0);" title="click for edit" ><img src="images/icon-edit.png" alt=""/></a>
                        <a onClick="return confirm('Do you want to delete?');" href="?delete_id=<?php echo $user_id; ?>" onSubmit="return confirm('Do you want to delete?');" title="click for delete"><img src="images/icon-delete.png"></a>
                        </td>

				  	</tr>
              		<?php } } else { ?>
   					<?php } ?> 
                            </tbody>
                        </table>
					</section>
					</div>
         <!-- End of Data Table  -->
        
        </div>
     </div>     
     </div>
     <!-- End Panel -->   
     </div>
	<!--End Main Page-->
    <script>
      var navigation = responsiveNav("foo", {customToggle: ".nav-toggle"});
    </script>
  </body>
</html>
