
initMap();

var geocoder;
var map;

function initMap() {
    if(user.lat==null || user.lng==null){
        var position={lat: -7.5360639, lng: 112.2384017};
    }else{
        var position={lat: user.lat, lng: user.lng};
    }
    
    $('#loading-address').html('<span class="badge badge-warning">..search your location..</span>');
    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById('map'), {
        center: position,
        zoom: 6
    });
    infoWindow = new google.maps.InfoWindow;

    if(user.lat==null || user.lng==null){
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                document.getElementById('latlng').value=pos.lat+','+pos.lng;
                locToAddress(geocoder, map, infoWindow);

                infoWindow.setPosition(pos);
                // infoWindow.setContent('Location found.');
                infoWindow.open(map);
                map.setCenter(pos);
                map.setZoom(10);
                $('#loading-address').html('');
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
        }
    }else{
        var pos = {
            lat: user.lat,
            lng: user.lng
        };
        document.getElementById('latlng').value=pos.lat+','+pos.lng;
        locToAddress(geocoder, map, infoWindow);

        infoWindow.setPosition(pos);
        // infoWindow.setContent('Location found.');
        infoWindow.open(map);
        map.setCenter(pos);
        map.setZoom(10);
        $('#loading-address').html('');
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    $('#loading-address').html('');
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                          'Error: The Geolocation service failed.' :
                          'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}

function addressToLoc() {
    var address = document.getElementById('address').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == 'OK') {
            var position=results[0].geometry.location;
            console.log(results);
            map.setCenter(position);
            var marker = new google.maps.Marker({
                map: map,
                position: position
            });
            document.getElementById('latlng').value=position.lat()+','+position.lng();
            locToAddress(geocoder, map, infoWindow);
            $('#loading-address').html('');
        } else {
			$('#loading-address').html('<div class="alert alert-danger">Geocode was not successful for the following reason: ' + status+'</div>');
        }
    });
}
function locToAddress(geocoder, map, infowindow) {
    var input = document.getElementById('latlng').value;
    var latlngStr = input.split(',', 2);
    var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
    geocoder.geocode({'location': latlng}, function(results, status) {
      if (status === 'OK') {
        if (results[0]) {
          map.setZoom(11);
          var marker = new google.maps.Marker({
            position: latlng,
            map: map
          });
          console.log(latlng);
          infowindow.setContent(results[0].formatted_address);
          infowindow.open(map, marker);
          document.getElementById('address').value=results[0].formatted_address;
          $('#loading-address').html('');
        } else {
			$('#loading-address').html('<div class="alert alert-danger">No results found</div>');
        }
      } else {
        $('#loading-address').html('<div class="alert alert-danger">Geocoder failed due to: ' + status+'</div>');
      }
    });
}

