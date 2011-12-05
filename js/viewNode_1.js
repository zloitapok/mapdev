var map;
var markers = [];
    
function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(40.757221, -73.989787);
        var myOptions = {
                zoom: 8,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.TERRAIN
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        google.maps.event.addListener(map, 'click', function(event) {
                storeAddress(event.latLng);
        });
}

function storeAddress(location) {
        var coords = location.toString();
        codeLatLng(coords);
        jQuery('#submission_location_latlng').val(coords);
        console.log(coords);
}

function codeAddress() {
        var address = jQuery("#submission_location").val();
        if (address) 
        {
                if (geocoder) 
                {
                        geocoder.geocode( { 'address': address}, function(results, status) {
                                if (status == google.maps.GeocoderStatus.OK) 
                                {
                                        map.setCenter(results[0].geometry.location);
                                        map.setZoom(13);
                                        deleteOverlays();
                                        var marker = new google.maps.Marker({
                                                map: map,
                                                position: results[0].geometry.location
                                        });
                                        markers.push(marker);
                                        var latlng = results[0].geometry.location.toString();
                                        var formatted_address = results[0].formatted_address;
                                        jQuery('#submission_location').val(formatted_address);
                                        jQuery('#submission_location_latlng').val(latlng);
                                } 
                                else 
                                {
                                        alert("Sorry, we couldn't find that location. Please try again.");
                                }
                        });
                }
        }
}

function codeLatLng(location) {
        if (location != undefined) 
        {
                var latlngStr = location.replace('(', '').replace(')', '').split(',',2)
                var lat = parseFloat(latlngStr[0]);
                var lng = parseFloat(latlngStr[1]);
                var latlng = new google.maps.LatLng(lat, lng);
                if (geocoder) 
                {
                        geocoder.geocode({'latLng': latlng}, function(results, status) {
                                if (status == google.maps.GeocoderStatus.OK) 
                                {
                                        if (results[2]) 
                                        {
                                                formatted_address = results[2].formatted_address;
                                                jQuery('#submission_location').val(formatted_address);
                                        }
                                } 
                                else 
                                {
                                        alert("Sorry, we couldn't find that location. Please try again.");
                                }
                        });
                }
        }
}


function deleteOverlays() {
        if (markers) 
        {
                for (i in markers) {
                        markers[i].setMap(null);
                }
                markers.length = 0;
        }
}
jQuery(document).ready(function() {
        initialize();
        //      jQuery("#submission_location").change(function() {
        //        codeAddress();
        //      });
        //      jQuery("#find_me").click(function() {
        //        codeAddress();
        //      });
});