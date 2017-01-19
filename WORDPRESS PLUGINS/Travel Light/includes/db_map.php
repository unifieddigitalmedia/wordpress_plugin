<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>

var map;

var directionDisplay ;


var latlng;

//lat:18.166586, lng: -76.380681 51.507064, -0.126318

function initMap() {



directionsDisplay = new google.maps.DirectionsRenderer();

var geocoder;

geocoder = new google.maps.Geocoder();


var address = <?php echo json_encode($_REQUEST[location]); ?>;

geocoder.geocode( { 'address': address}, function(results, status) {

if (status == google.maps.GeocoderStatus.OK) {

latlng = results[0].geometry.location;


latlng = latlng.replace('(','');


latlng = latlng.replace(")","");


latlng = latlng.split(",");



}



});

 map = new google.maps.Map(document.getElementById('map'), {

    center:{lat:18.166586, lng: -76.380681}, 

    zoom:16,styles :[

  {

    "featureType": "poi.business",

    "stylers": [

      { "visibility": "off" }

    ]

  }

]

  });



 



}



    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRymGUo1SnzUFFYcAjrXO-vJpJ-fwT5NE&libraries=weather&callback=initMap"
        async defer></script>
  </body>
</html>