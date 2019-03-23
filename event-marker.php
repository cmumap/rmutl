<?php require_once('Connections/dbconfig.php'); ?>
<?
	error_reporting( ~E_NOTICE );
	if(isset($_GET['view_id']) && !empty($_GET['view_id']))
	{
		$id = $_GET['view_id'];
		$stmt_view = $DB_con->prepare('SELECT locate_id, locate_province, locate_title, locate_des, locate_Latitude, locate_Longitude,  locate_zoom, locate_url, locate_icon FROM maplocate WHERE locate_url =:uid');
		$stmt_view->execute(array(':uid'=>$id));
		$view_row = $stmt_view->fetch(PDO::FETCH_ASSOC);
		extract($view_row);
	}
	else{}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>EXO CNX TravelMap-Location</title>

    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,600,700' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
    <link rel="stylesheet" href="css/patternCSS.css"> <!-- Pattern style -->

	<script src="js/modernizr.js"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script src="js/gmap3.js"></script> 
	<script src="js/main.js"></script>
    <script type="text/javascript">
		window.onload = function(){
		var heights = window.innerHeight;
		document.getElementById("map").style.height = heights + "px";}
	</script>
</head>

<body>
	<header>
    <?php include "include-header.php" ?>
	</header>
    <main class="cd-main-content">    
	<div id="googlemaps"></div>

    </main>
    <script type="text/javascript">
    $(function ()
        { 
            $('#googlemaps').gmap3(
                { map: 
                    { options: 
                        {
                        center: [<?php echo $locate_Latitude; ?>,<?php echo $locate_Longitude; ?>], // MAIN LOCATION
                        zoom: <?php echo $locate_zoom; ?>, // LOCATION ZOOM
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        mapTypeControl: true,
                        mapTypeControlOptions: 
                            {
                                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                            },
                        }
                    },
                    marker: {
						
						                  	values: [
	               
                    <?php							 
					$stmt = $DB_con->prepare('SELECT event_id, locate_url, event_title, event_des, event_link, event_Latitude, event_Longitude, event_icon, event_pic FROM eventarea');
					$stmt->execute();	
					if($stmt->rowCount() > 0)
					{
						while($row=$stmt->fetch(PDO::FETCH_ASSOC))
						{ 	
						++$i;
		              	$i != $num ? $k=',' : $k='';
						extract($row);  
						if($locate_url == $id )
						{   
      				?> 
                    { latLng:[<?php echo $row[event_Latitude]?>, <?php echo $row[event_Longitude]?>], 
					  data:"<div class='panel-des'><br><h4><?php echo $row['event_title']?></h4><p><?php echo $row['event_des']?></p><p><a href='<?php echo $row['event_link']?>'>View All...</a></p><br><br><?php if($event_pic!=null){?><img src='icon/<?php echo $event_pic;?>' width='230px' /><?php }else{}?><br><br></div>",		 
					  options:{icon: "icon/<?php echo $row[event_icon]?>"}}<?php echo $k?>
		 			<?php } } } else { ?>
   					<? } ?>  
                    ],

                    
                    events: {
                        mouseover: function (marker, event, context) {
                            var map = $(this).gmap3("get"),
                                infowindow = $(this).gmap3({
                                    get: {
                                        name: "infowindow"
                                    }
                                });
                            if (infowindow) {
                                infowindow.open(map, marker);
                                infowindow.setContent(context.data);
                            } else {
                                $(this).gmap3({
                                    infowindow: {
                                        anchor: marker,
                                        options: {
                                            content: context.data
                                        }
                                    }
                                });
                            }
                        },
                        closeclick: function () {
                            infowindow.close();
                        },
                        mouseout: function () {
                            var infowindow = $(this).gmap3({
                                get: {
                                    name: "infowindow"
                                }
                            });
                        }
                    }
                }
            });
        });
    </script>

 	<nav id="cd-lateral-nav">
  	<?php include "include-menu.php" ?>    
	</nav>
</body>
</html>