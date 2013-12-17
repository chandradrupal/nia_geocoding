<?php
function get_lat_lang()
{
?>

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"> </script>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
	var map;
	var myCenter=new google.maps.LatLng(17.363745937326893,82.72293090820312);

	function initialize()
	{
	var mapProp = {
	  center:myCenter,
	  zoom:5,
	  mapTypeId:google.maps.MapTypeId.ROADMAP
	  };

	  map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

	  google.maps.event.addListener(map, 'click', function(event) {
		placeMarker(event.latLng);
		var val = event.latLng;
		alert(val);
	  });
	}

	function placeMarker(location) {
	  var marker = new google.maps.Marker({
		position: location,
		map: map,
	  });
	  var infowindow = new google.maps.InfoWindow({
		content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
	  });
	  infowindow.open(map,marker);
	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div id="googleMap" style="width:500px;height:380px;"></div>


<?php
	return TRUE;
	}
?>