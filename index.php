

<?php require_once('Connections/dbconfig.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>COOP Project Map-Location</title>

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
    <script type="text/javascript">
		window.onload = function(){
		var heights = window.innerHeight;
		document.getElementById("map").style.height = heights + "px";}
	</script>
</head>

<body>
    
<header>
<?php include 'include-header.php';?>


    </header>
    <div id="map">
        <?php include 'locations_model.php'; ?>
    </div>
    

    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLlPkgIjxNsgSIYPbhknlpOUfzTjrxp6w">
    </script>

    
    <script>
        /**
         * Create new map
         */
        var infowindow;
        var map;
        var bank =  'img/bank.png' ; var bus =  'img/bus.png' ; var food =  'img/food.png' ; var atm =  'img/atm.png' ; var coff =  'img/coff.png' ;
        var red_icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
        var locations = <?php get_confirmed_locations() ?>;
        var myOptions = {
            zoom: 15,
            center: new google.maps.LatLng(18.7995473, 98.9560846),
            mapTypeId: 'roadmap'
        };
        map = new google.maps.Map(document.getElementById('map'), myOptions);

        /**
         * Global marker object that holds all markers.
         * @type {Object.<string, google.maps.LatLng>}
         */
        // var markers = {};

        /**
         * Concatenates given lat and lng with an underscore and returns it.
         * This id will be used as a key of marker to cache the marker in markers object.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {string} Concatenated marker id.
         */
        // var getMarkerUniqueId= function(lat, lng) {
        //     return lat + '_' + lng;
        // };

        /**
         * Creates an instance of google.maps.LatLng by given lat and lng values and returns it.
         * This function can be useful for getting new coordinates quickly.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {google.maps.LatLng} An instance of google.maps.LatLng object
         */
        var getLatLng = function(lat, lng) {
            return new google.maps.LatLng(lat, lng);
        };

        /**
         * Binds click event to given map and invokes a callback that appends a new marker to clicked location.
         */
        var addMarker = google.maps.event.addListener(map, 'click', function(e) {
            var lat = e.latLng.lat(); // lat of clicked point
            var lng = e.latLng.lng(); // lng of clicked point
            var markerId = getMarkerUniqueId(lat, lng); // an that will be used to cache this marker in markers object.
            var marker = new google.maps.Marker({
                position: getLatLng(lat, lng),
                map: map,
                animation: google.maps.Animation.DROP,
                id: 'marker_' + markerId,
                html: "    <div id='info_"+markerId+"'>\n" +
                "        <table class=\"map1\">\n" +
                "            <tr>\n" +
                "                <td><a>Description:</a></td>\n" +
                "                <td><input text  id='manual_description' placeholder='Description'></td></tr>\n" +
                "                <td><a>Type :</a></td>\n" +
                "                <td><select  id='manual_type' placeholder='Description'> <option> ธนาคาร </option><option> โรงอาหาร </option><option> ตู้ ATM </option><option> ป้ายรถม่วง </option><option> ร้านกาแฟ </option></select></td></tr>\n" +
                "               <tr><td></td><td><input type='button' value='Save' onclick='saveData("+lat+","+lng+")'/></td></tr> " +
                "               <tr><td></td><td><input type='button' value='Remove' onclick='deletemark()'/></td></tr> " +

                "        </table>\n" +
                "    </div>"
            });
            markers[markerId] = marker; // cache marker in markers object
            bindMarkerEvents(marker); // bind right click event to marker
            bindMarkerinfo(marker); // bind infowindow with click event to marker
        });

        /**
         * Binds  click event to given marker and invokes a callback function that will remove the marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
         */
        var bindMarkerinfo = function(marker) {
            google.maps.event.addListener(marker, "click", function (point) {
                var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
                var marker = markers[markerId]; // find marker
                infowindow = new google.maps.InfoWindow();
                infowindow.setContent(marker.html);
                infowindow.open(map, marker);
                // removeMarker(marker, markerId); // remove it
            });
        };

        /**
         * Binds right click event to given marker and invokes a callback function that will remove the marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
         */
        var bindMarkerEvents = function remove(marker) {
            google.maps.event.addListener(marker, "rightclick", function (point) {
                var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
                var marker = markers[markerId]; // find marker
                removeMarker(marker, markerId); // remove it
            });
        };

        /**
         * Removes given marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that will be removed.
         * @param {!string} markerId Id of marker.
         */
        var removeMarker = function(marker, markerId) {
            marker.setMap(null); // set markers setMap to null to remove it from map
            delete markers[markerId]; // delete marker instance from markers object
        };


        /**
         * loop through (Mysql) dynamic locations to add markers to map.
         */
        var i ; var confirmed = 0;
        for (i = 0; i < locations.length; i++) {
            if(locations[i][5]=="ธนาคาร"){$a = bank;}
            else if(locations[i][5]=="โรงอาหาร"){$a = food;}
            else if(locations[i][5]=="ตู้ ATM"){$a = atm;}
            else if(locations[i][5]=="ป้ายรถม่วง"){$a = bus;}
            else if(locations[i][5]=="ร้านกาแฟ"){$a = coff;}
            else{$a = red_icon;}
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon :   locations[i][4] === '1' ?  $a : purple_icon,
                html: "<div>\n" +
                "<table class=\"map1\">\n" +
                "<tr>\n" +
                "<td><a>Description:</a></td>\n" +
                "<td><textarea disabled id='manual_description' placeholder='Description'>"+locations[i][3]+"</textarea></td></tr>\n" +
                "<td><a>Type:</a></td>\n" +
                "<td><textarea disabled id='manual_description' placeholder='Description'>"+locations[i][5]+"</textarea></td></tr>\n" +
                "<td><a href="+locations[i][6]+" target='_blank'>Direct</a></td></tr>\n" +
                "</table>\n" +
                "</div>"
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow = new google.maps.InfoWindow();
                    confirmed =  locations[i][4] === '1' ?  'checked'  :  0;
                    $("#confirmed").prop(confirmed,locations[i][4]);
                    $("#id").val(locations[i][0]);
                    $("#description").val(locations[i][3]);
                    $("#form").show();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }

        /**
         * SAVE save marker from map.
         * @param lat  A latitude of marker.
         * @param lng A longitude of marker.
         */
         
        function saveData(lat,lng) {
            var description = document.getElementById('manual_description').value;
            var types = document.getElementById('manual_type').value;
            var url = 'locations_model.php?add_location&description=' + description + '&types=' + types + '&lat=' + lat + '&lng=' + lng;
            downloadUrl(url, function(data, responseCode) {
                if (responseCode === 200  && data.length > 1) {
                    var markerId = getMarkerUniqueId(lat,lng); // get marker id by using clicked point's coordinate
                    var manual_marker = markers[markerId]; // find marker
                    manual_marker.setIcon(purple_icon);
                    infowindow.close();
                    infowindow.setContent("<div style=' color: purple; font-size: 25px;'> Waiting for admin confirm!!</div>");
                    infowindow.open(map, manual_marker);

                }else{
                    console.log(responseCode);
                    console.log(data);
                    infowindow.setContent("<div style='color: red; font-size: 25px;'>Inserting Errors</div>");
                }
            });
        }

        function deletemark(){
            location.reload();
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

    <!-- <script>
        function initMap() {
        var mapOptions = {
        center: {lat: 18.8098668, lng: 98.9521663},
        zoom: 20,
        }
        
        var maps = new google.maps.Map(document.getElementById("map"),mapOptions);
        
        var marker = new google.maps.Marker({
        position: new google.maps.LatLng(18.8098668, 98.9521663),
        map: maps,
        title: 'เรื่องของกู'
        });
        }
    </script> -->

 	<nav id="cd-lateral-nav">
  	<?php include "include-menu.php"; ?>    
    </nav> 
  </body>
 </html>