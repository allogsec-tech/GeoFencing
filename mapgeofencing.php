<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
	 #map_canvas {
    height: 300px;
    width: 700px;
    margin: px;
    padding: 100px;
}
	</style>
	<script src="https://maps.googleapis.com/maps/api/js?key=Your_APIKEY&libraries=geometry,drawing"></script>
	<script type="text/javascript">
		var geocoder;
var map;
var polygonArray = [];
var polyCoords = new Array();
var jsonObj = {};

function initialize() {
    map = new google.maps.Map(
    document.getElementById("map_canvas"), {
        center: new google.maps.LatLng(37.4419, -122.1419),
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.POLYGON,
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [
            google.maps.drawing.OverlayType.MARKER,
            google.maps.drawing.OverlayType.CIRCLE,
            google.maps.drawing.OverlayType.POLYGON,
            google.maps.drawing.OverlayType.POLYLINE,
            google.maps.drawing.OverlayType.RECTANGLE]
        },
        markerOptions: {
            icon: 'images/car-icon.png'
        },
        circleOptions: {
            fillColor: '#ffff00',
            fillOpacity: 1,
            strokeWeight: 5,
            clickable: false,
            editable: true,
            zIndex: 1
        },
        polygonOptions: {
            fillColor: '#BCDCF9',
            fillOpacity: 0.5,
            strokeWeight: 2,
            strokeColor: '#57ACF9',
            clickable: false,
            editable: false,
            zIndex: 1
        }
    });
    console.log(drawingManager)
    drawingManager.setMap(map)



    google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
        document.getElementById('info').innerHTML += "polygon points:" + "<br>";
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "#";   
        form.id = "#jsonObj";
        for (var i = 0; i < polygon.getPath().getLength(); i++) {
            document.getElementById('info').innerHTML += polygon.getPath().getAt(i).toUrlValue(6) + "<br>";
            // window.alert(polygon.getPath().getAt(i).toUrlValue(6));
            var z = polygon.getPath().getAt(i).toUrlValue(6);
            window.alert(z);
            jsonObj[i] = z;
            var element = document.createElement("input");
            element.value = z;
            element.name = i;
            form.appendChild(element);
            // polyCoords.push(jsonObj);
        }
        // for (var j = 0; j < polyCoords.length; j++){
        //     form.appendChild(polyCoords[j]);
        // }
        document.body.appendChild(form);
        form.submit();    
        polygonArray.push(polygon);
        console.log(jsonObj);
    });

}

google.maps.event.addDomListener(window, "load", initialize);
	</script>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "socialdb";

$conn = new mysqli($servername, $username, $password, $db);
// $array=json_decode($_POST['jsonObj']);

// echo $array;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$coords = $_POST;
print_r(count(explode(",",$coords[0])));
$i=0;
foreach ($coords as $coarr){
    $coarr = explode(",",$coarr);
    // print_r($coarr[0]);
    $sql = "INSERT into coordinates (indexxy, x, y) VALUES (".$i.",".$coarr[0].",".$coarr[1].")";
    $i++;
    print_r($sql);
    mysqli_query($conn, $sql);
}

?>
</head>
<body>
	<div id="map_canvas" style=" border: 2px solid #3872ac;"></div>
	<div id="info"></div>

</body>
</html>