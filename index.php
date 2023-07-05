<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jor[di's map</title>

     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
     crossorigin=""/>

     <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
     integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
     crossorigin=""></script>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

     <style>
        body {
            background-color: linen;
        }
        #map {
            height: 100%;
            width: auto;
        }
    </style>
</head>
<body>
    <div id="map" style="width: auto; height:  98vh;"></div>
    <script>    

        var map = L.map('map').setView([37.52715,-96.877441], 4); 

        var osm=new L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png',{ 
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);

        var  geojsonMarkerOptions = {
        'radius':6,
        'opacity': .5,
        'color': "red",
        'fillColor':  "blue",
        'fillOpacity': 0.8
        };

        function forEachFeature(feature, layer) {

            var popupContent = "<p>The <b>";
                            
            if (feature.properties && feature.properties.popupContent) {
                popupContent += feature.properties.popupContent;
            }
                layer.bindPopup(popupContent);
        };

        //var bbTeam = L.geoJSON(null, {onEachFeature: forEachFeature, style: style});
        var bbTeam = L.geoJSON(null, {
            onEachFeature: forEachFeature, 
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, geojsonMarkerOptions);
            }
        });


    </script>

    <?php
        $jsons= scandir(".\geojson");
    ?>

     <script>
       
     // Access the array elements
     var passedArray = 
         <?php echo json_encode($jsons); ?>;
            
     // Display the array elements
     for(var i = 0; i < passedArray.length; i++){
         //document.write(passedArray[i]);

         var url = "geojson/" + passedArray[i];
         //document.write(url);

         $.getJSON(url, function(data) {
            bbTeam.addData(data);
        });
     }

     bbTeam.addTo(map);

     </script>

</body>
</html>