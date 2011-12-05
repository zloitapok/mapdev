var map;
    
function initialize(lat, lng) {
        var myLatlng = new google.maps.LatLng(lat,lng);
        geocoder = new google.maps.Geocoder();
        var myOptions = {
                zoom: 14,
                center: myLatlng,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.HYBRID
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        placeMarker(myLatlng);
}

function placeMarker(myLatlng) {
        var marker = new google.maps.Marker({
                position: myLatlng, 
                map: map
        });
        map.setCenter(myLatlng);
}

