<?php
    session_start();

    if(isset($_SESSION['administrator'])=="")
    {
        echo "<script>alert('กรุณาเข้าสู่ระบบในฐานะผู้ดูแล');</script>";
        echo "<script>window.location='WebUserAdmin/index.php';</script>";
    }
?>

<?php
include_once 'locations_model.php';
?>

<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,600,700' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="icon" href="img\icon.png">

    <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
    <link rel="stylesheet" href="css/patternCSS.css"> <!-- Pattern style -->

	<script src="js/modernizr.js"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;language=en"></script> -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLlPkgIjxNsgSIYPbhknlpOUfzTjrxp6w&callback=initMap"></script>
    <script src="js/gmap3.js"></script> 
	<script src="js/main.js"></script>




<header>
<?php  include_once 'include-header.php'; ?>

</header>


<div id="map"></div>

<!------ Include the above in your HEAD tag ---------->
<script>
    var map;
    var marker;
    var infowindow;
    var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
    var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
    var locations = <?php get_all_locations() ?>;

    function initMap() {
        var france = {lat: 18.7995473, lng: 98.9560846};
        infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(document.getElementById('map'), {
            center: france,
            zoom: 15
        });


        var i ; var confirmed = 0;
        for (i = 0; i < locations.length; i++) {

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon :   locations[i][4] === '1' ?  red_icon  : purple_icon,
                html: document.getElementById('form')
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    confirmed =  locations[i][4] === '1' ?  'checked'  :  0;
                    // types = if(locations[i][5]=="ธนาคาร")
                    $("#confirmed").prop(confirmed,locations[i][4]);
                    $("#id").val(locations[i][0]);
                    $("#description").val(locations[i][3]);
                    $("#types").val(locations[i][5]);
                    $("#url").val(locations[i][6]);

                    $("#form").show();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            
        }
    }

    function saveData() {
        var confirmed = document.getElementById('confirmed').checked ? 1 : 0;
        var id = document.getElementById('id').value;
        var url = 'locations_model.php?confirm_location&id=' + id + '&confirmed=' + confirmed ;
        downloadUrl(url, function(data, responseCode) {
            if (responseCode === 200  && data.length > 1) {
                infowindow.close();
                window.location.reload(true);
            }else{
                infowindow.setContent("<div style='color: purple; font-size: 25px;'>Inserting Errors</div>");
            }
        });
    }


    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                callback(request.responseText, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }


</script>

<div style="display: none" id="form">
    <table class="map1">
        <tr>
            <input name="id" type='hidden' id='id'/>
            <td><a>Description:</a></td>
            <td><textarea disabled id='description' placeholder='Description'></textarea></td>
        </tr>
        <tr>
            <td><a>Confirm Location ?:</a></td>
            <td><input id='confirmed' type='checkbox' name='confirmed'></td>
        </tr>
        <tr>
            <td><a>Type:</a></td>
            <td><input id='types' type='text' name='type' disabled></td>
        </tr>
        
        <tr><td></td><td><input type='button' value='Save' onclick='saveData()'/></td></tr>
    </table>
</div>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLlPkgIjxNsgSIYPbhknlpOUfzTjrxp6w&callback=initMap">
</script>


<nav id="cd-lateral-nav">
  	<?php include "include-menu-admin.php"; ?>    
    </nav> 