<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">

<!--Submit comments -->
<?php
require "config.php";// connection to database 

//Select Data
$result = mysql_query("

SELECT * FROM ba
ORDER BY id DESC;

");
			
?>
<!--Submit complete -->
<head>     
  <title>YourFirstStep</title>     <!-- Title shows on address bar -->
  <link href="css/scaffold.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
		<div style="background:#ADD8E6" id="header" class="ui-layout-north">
			<h1><a href="/">YourFirstStep<span>.de</span></a></h1>                    <!-- Introductory message, common for all page-->
			<p style="color:#8B0000">Help Yourself to Start Your New Journey at Karlsruhe</p>
			<img src="img/kas2.png" style="width:180px;height:50px;float: right;">
		</div>

<style>
  #map {
    width: auto;
    height: auto;
  }
  </style>
  </head>
  <body>

  <div id="wrapper"> <!--Div Wrapper START-->
		<div id="right" style="margin:-10px 0px 0px 265px;">
				<div id="map"></div>	
		</div>			
		
	<div id="left" style="background: rgba(0, 0, 0, 0.5); padding-left:10px;" >
					<div>
					<img src="../img/ba.jpg" style="width:250px;height:120px">
					<p style="color:#ffffff; font-weight:bold; font-family: cursive; font-size:24px">
						  Bank Account
					</p>
					<p style="color:#ffffff; font-family: cursive; font-size:14px">
						  Available Location for this Service. Use Get Direction to reach at the service point. 
					</p>
					</div>
<br>
<button id="clear"> Get direction </button>
					
<div>
<br>
						<h1 style="color:#ffffff; font-family: cursive; font-weight:bold; font-size:16px">
						  Related Info:
						 </h1>
						  <p style="font-size:14px">
						  To open a bank account, you will need:<br>
Your Passport/ID Card<br>
Your address in Karlsruhe (You should have one)<br>
Your Student ID or enrollment certificate 
						  </p>
					</div>							
					
<br>
					
 			<form action="insert_ba.php" method="POST">
					<table>
                  <tr> 
              <td><b>Comments:</b></td>
            </tr>
			<tr> 
              <td><textarea rows="1" cols="33.5" name="name" id="name" required placeholder="Name"></textarea></td>
            </tr><br>
			<tr> 
              <td><textarea rows="4" cols="33.5" name="comment" id="comment" required placeholder="Please share your opinion"></textarea></td>
            </tr>
			<tr> 
              <td><button type="submit" name="submit" id="submit">Post</button></td>
            </tr>
          </table>
		  </form>
			<!-- Opinion column-->					
		<!-- Opinion Showing-->
		<br>
		<tr style="font-style:bold;"> 
         Story Board
      </tr>
		<div class="scroll" style="float:left; margin-left:0px; font-size:12px;"> 
    <table style="width:250px;border-style:solid;" border="1px" align="left">
      
	        <tr> 
        <hr width="100%"></hr>
      </tr>

      <?php
		while($row_result=mysql_fetch_array($result)){
		
		?>
      <tr style="border-width:0px;border-style:solid;"> 
        <tr> 
		<td bgcolor="#CCCCCC; font-style:bold;"> <?php echo $row_result['name'] ?> </td>
		</tr>
		 
		<tr> 
		<td bgcolor="#CCCCCC"> <?php echo $row_result['comment']?> </td>
		</tr>
        <td> <?php 
?> </td>
      </tr>
      <?php

            }
            ?>
    </table>
  </div>


  <div id="map">

  <script src="ol3/ol.js"></script>
  <script type="text/javascript">
  
  
  
  var map = new ol.Map({
    target: 'map',
    layers: [
      new ol.layer.Tile({
        source: new ol.source.OSM()
      })
    ],
    view: new ol.View({
      center: ol.proj.transform([8.40166597537923,49.01003030000012], 'EPSG:4326', 'EPSG:3857'),
      zoom: 16
    }),
    controls: ol.control.defaults({
      attributionOptions: {
        collapsible: false
      }
    })
  });
 
  var params = {
    LAYERS: 'pgrouting:pgrouting',
    FORMAT: 'image/png'
  }

  // The "start" and "destination" features.
  var startPoint = new ol.Feature();
  var destPoint = new ol.Feature();
 

  // The vector layer used to display the "start" and "destination" features.
  var vectorLayer = new ol.layer.Vector({
    source: new ol.source.Vector({
      features: [startPoint, destPoint]

    })
  });
  
 

  map.addLayer(vectorLayer);
 
  
  
  
 
  // A transform function to convert coordinates from EPSG:3857
  // to EPSG:4326.
  var transform = ol.proj.getTransform('EPSG:3857', 'EPSG:4326');

  // Register a map click listener.
  map.on('click', function(event) {
    if (startPoint.getGeometry() == null) {
      // First click.
      startPoint.setGeometry(new ol.geom.Point(event.coordinate));
    } else if (destPoint.getGeometry() == null) {
      // Second click.
      destPoint.setGeometry(new ol.geom.Point(event.coordinate));
      // Transform the coordinates from the map projection (EPSG:3857)
      // to the server projection (EPSG:4326).
      var startCoord = transform(startPoint.getGeometry().getCoordinates());
      var destCoord = transform(destPoint.getGeometry().getCoordinates());
      var viewparams = [
        'x1:' + startCoord[0], 'y1:' + startCoord[1],
        'x2:' + destCoord[0], 'y2:' + destCoord[1]
      ];
      params.viewparams = viewparams.join(';');
      result = new ol.layer.Image({
        source: new ol.source.ImageWMS({
          url: 'http://localhost:8082/geoserver/pgrouting/wms',
          params: params
        })
      });
      

      map.addLayer(result);
      
    
    }
  });

  var clearButton = document.getElementById('clear');
  clearButton.addEventListener('click', function(event) {
    // Reset the "start" and "destination" features.
    startPoint.setGeometry(null);
    destPoint.setGeometry(null);
    // Remove the result layer.
    map.removeLayer(result);
  });
  
  //for showing the markers of the activity's location.
  
//bank 1  
  var iconFeature1 = new ol.Feature({
	geometry : new ol.geom.Point(ol.proj.transform([8.40166597537923,49.01003030000012], 'EPSG:4326', 'EPSG:3857'))
  });
  
  var iconStyle1 = new ol.style.Style({
	image : new ol.style.Icon({
	src : 'img/m41.png'
     })
  });
  
  iconFeature1.setStyle(iconStyle1);
  
  var vectorSource1 = new ol.source.Vector ({
	features : [ iconFeature1 ]
  });

 var vectorLayer1 = new ol.layer.Vector ({
	source : vectorSource1
 });
 
 map.addLayer(vectorLayer1);

 //Bank 2 
 
 var iconFeature2 = new ol.Feature({
	geometry : new ol.geom.Point(ol.proj.transform([8.393273400000023,49.00980370000018], 'EPSG:4326', 'EPSG:3857'))
  });
  
  var iconStyle2 = new ol.style.Style({
	image : new ol.style.Icon({
	src : 'img/m42.png'
     })
  });
  
  iconFeature2.setStyle(iconStyle2);
  
  var vectorSource2 = new ol.source.Vector ({
	features : [ iconFeature2 ]
  });

 var vectorLayer2 = new ol.layer.Vector ({
	source : vectorSource2
 });
 
 map.addLayer(vectorLayer2);
 
 //bank 3  
  var iconFeature3 = new ol.Feature({
	geometry : new ol.geom.Point(ol.proj.transform([8.404416299999953,49.009038599999855], 'EPSG:4326', 'EPSG:3857'))
  });
  
  var iconStyle3 = new ol.style.Style({
	image : new ol.style.Icon({
	src : 'img/m43.png'
     })
  });
  
  iconFeature3.setStyle(iconStyle3);
  
  var vectorSource3 = new ol.source.Vector ({
	features : [ iconFeature3 ]
  });

 var vectorLayer3 = new ol.layer.Vector ({
	source : vectorSource3
 });
 
 map.addLayer(vectorLayer3);
 
 //bank 4  
  var iconFeature4 = new ol.Feature({
	geometry : new ol.geom.Point(ol.proj.transform([8.410276000000037,49.00936230000025], 'EPSG:4326', 'EPSG:3857'))
  });
  
  var iconStyle4 = new ol.style.Style({
	image : new ol.style.Icon({
	src : 'img/m44.png'
     })
  });
  
  iconFeature4.setStyle(iconStyle4);
  
  var vectorSource4 = new ol.source.Vector ({
	features : [ iconFeature4 ]
  });

 var vectorLayer4 = new ol.layer.Vector ({
	source : vectorSource4
 });
 
 map.addLayer(vectorLayer4);
 
 //bank 5  
  var iconFeature5 = new ol.Feature({
	geometry : new ol.geom.Point(ol.proj.transform([8.400367653438142,49.01083490000005], 'EPSG:4326', 'EPSG:3857'))
  });
  
  var iconStyle5 = new ol.style.Style({
	image : new ol.style.Icon({
	src : 'img/m45.png'
     })
  });
  
  iconFeature5.setStyle(iconStyle5);
  
  var vectorSource5 = new ol.source.Vector ({
	features : [ iconFeature5 ]
  });

 var vectorLayer5 = new ol.layer.Vector ({
	source : vectorSource5
 });
 
 map.addLayer(vectorLayer5);
 
 //bank 6  
  var iconFeature6 = new ol.Feature({
	geometry : new ol.geom.Point(ol.proj.transform([8.409759749999985,49.00898919999982], 'EPSG:4326', 'EPSG:3857'))
  });
  
  var iconStyle6 = new ol.style.Style({
	image : new ol.style.Icon({
	src : 'img/m46.png'
     })
  });
  
  iconFeature6.setStyle(iconStyle6);
  
  var vectorSource6 = new ol.source.Vector ({
	features : [ iconFeature6 ]
  });

 var vectorLayer6 = new ol.layer.Vector ({
	source : vectorSource6
 });
 
 map.addLayer(vectorLayer6);
 
 //bank 7  
  var iconFeature7 = new ol.Feature({
	geometry : new ol.geom.Point(ol.proj.transform([8.396222700000013,49.00982480000015], 'EPSG:4326', 'EPSG:3857'))
  });
  
  var iconStyle7 = new ol.style.Style({
	image : new ol.style.Icon({
	src : 'img/m47.png'
     })
  });
  
  iconFeature7.setStyle(iconStyle7);
  
  var vectorSource7 = new ol.source.Vector ({
	features : [ iconFeature7 ]
  });

 var vectorLayer7 = new ol.layer.Vector ({
	source : vectorSource7
 });
 
 map.addLayer(vectorLayer7);
 
 //end of adding markers
  
  </script>
  </div>
  </body>
</html>