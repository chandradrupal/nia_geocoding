

<?php

function get_multimarker_location($srch_str='')
{
	
	$var = $_GET['srch_name'];
	if($var)
	{	
		$sql = "SELECT city, address, latitude, longitude from {nia_address} where name = '$var'"; 
	}
	else
	{
		$sql = "SELECT city, address, latitude, longitude from {nia_address} where name = 'user1'"; 
	}
	
	$data = db_query($sql);
	echo '<pre>';
	print_r($data);
	$count = mysql_num_rows($data);
	 $i=1;
	 $lant='';$info='';
	while ($item = db_fetch_array($data)) 
	{   
	$lant .="['".$item['city'].",".$item['address']."',".$item['latitude'].",".$item['longitude']."],";
	$info .="['".$item['city'].",".$item['address']."'],"; 
	$i++;
	}
	
	
	$locations = trim($lant,",");
	$information=trim($info,",");;
?>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
	jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
});

function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);
        
    // Multiple Markers
	
    var markers = [<?php echo $locations;?>];
                        
    // Info Window Content
    var infoWindowContent = [<?php echo $information;?>];
        
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(5);
        google.maps.event.removeListener(boundsListener);
    });    
}	

</script>		
		
<?php		
		return ``;
}
?>

<style type="text/css">
	#map_wrapper {
    height: 400px;
	}

	#map_canvas {
		width: 50%;
		height: 100%;
	}
</style>

<div id="map_wrapper">
    <div id="map_canvas" class="mapping"></div>
</div>	

	<form >
		<input type="text" value="" name="srch_name"> 
	<input type="submit" value="Search By Location"> 
	</form>