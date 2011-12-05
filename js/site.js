var markersPool = new Array();
var markersArray = [];
var map;

function initialize(lat, lng) {
        var myLatlng = new google.maps.LatLng(lat,lng);
        geocoder = new google.maps.Geocoder();
        var myOptions = {
                zoom: 14,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                        position: google.maps.ControlPosition.TOP_LEFT
                },
                panControl: false,
                zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.LARGE,
                        position: google.maps.ControlPosition.LEFT_CENTER
                },
                scaleControl: true,
                scaleControlOptions: {
                        position: google.maps.ControlPosition.BOTTOM_LEFT
                },
                streetViewControl: false

        };
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
}


function placeMarkers(data, nodesToDisplay) {
        clearOverlays();
        var infowindow = new google.maps.InfoWindow();
        var places = data.points;
        for(var i in places)
        {
                if (inArray(places[i]['id'], nodesToDisplay))
                {
                        var myLatlng = new google.maps.LatLng(places[i]['lat'],places[i]['lng']);
                        var marker = new google.maps.Marker({
                                position: myLatlng, 
                                map: map
                        });
                        
                        
                        
                        infowindow.setContent(places[i]['title']);
                        
                        google.maps.event.addListener(marker, 'click', function () {
                                infowindow.open(map, this);
                        });
                        
                        markersArray.push({id: places[i]['id'], marker : marker});
                }
        }
}

function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}

 
function clearOverlays() {
        if (markersArray) {
                for (i in markersArray) {
                        markersArray[i]['marker'].setMap(null);
                }
        }
}

function resizeMap()
{
        var padd = $('#content').outerHeight() - $('#content').height() + $('#mainmenu').height();
        $('#map_canvas').height($(window).height() - padd);
        resizeBlock();
}

function resizeBlock()
{
     $('#right-block #body').height($('#map_canvas').height() - $('#right-block #title').height());   
}

function fillMenu()
{
        $('#body').empty();
        
        var categories = markersPool.categories;
        
        for (i in categories) {
                $('#body').append(makeCategory(categories[i]));
        }
}

function makeCategory(category)
{
        var nodes = category.nodes;
        var nodesHtml = '';
        var count = 0;
        for (i in nodes) {
                count = count + 1;
                nodesHtml = nodesHtml 
                          + '<span node_id="' + i + '" class="node">'
                          + '<a href="#">' + nodes[i] + '</a>'
                          + '</span>';
        }
        
        var html = '<div class="category">' 
                 +   '<span class="to-right counter">'
                 +     '(' + count + ')'
                 +   '</span>'
                 +   '<div class="title">'
                 +     '<a href="#">'
                 +       category.name
                 +     '</a>'
                 +   '</div>'
                 +   '<div class="body">'
                 +     nodesHtml
                 +   '</div>'
                 +   '<div class="clear-left"></div>'
                 + '</div>'
         ;
        
        
        return html;
}

function fillMarkersPool(data)
{
      markersPool = data;
}

$(document).ready( function () {
        
        resizeMap();
        
        $(window).resize( function() {
                resizeMap();
        });
        
        $('#right-block #title').mouseover( function (){
                $('#right-block #title,#right-block #title a').css('color', '#FFFFFF');
                $(this).css('background-color', '#0066A4');
        })
        .mouseout( function (){
                $('#right-block #title').css('color', '#EFEFEF').find('a').css('color', 'inherit');
                $(this).css('background-color', '#6399cd');
        });
        
        $('#searchSmb').submit( function () {
                var sndData = {search_request : $('#mapSearch').val()};
                $.ajax({
                        type: 'POST',
                        url: '/site/searchAjax',
                        data: sndData,
                        beforeSend: function() {
                                //
                        },
                        complete: function() {
                                //
                        },
                        success: function(data) {
                                markersPool = data;
                                fillMenu();
                        },
                        dataType: 'JSON'
                });
                return false;
        });
        
        $('#toggle-right-block').click( function () {
                $('#right-block #body').toggle(250);
                return false;
        });
        
        $('#toggle-search').click( function () {
                $('#right-block #mapSearch').toggle();
                resizeBlock();
                return false;
        });
        
        $('.category .node a').live('click', function() {
                var node_id = $(this).parent().attr('node_id');
                var points = markersPool.points;
                for (i in points) {
                        if (points[i].id == node_id)
                        {
                                var lat = points[i].lat;
                                var lng = points[i].lng;
                        }
                }
                var myLatlng = new google.maps.LatLng(lat,lng);
                map.panTo(myLatlng);
                return false;
        });
        
        $('.category .title a').live('click', function() {
                var nodesToDisplay = new Array();
                
                $(this).parent().toggleClass('expanded')
                                .next().toggle();
                $(this).parent().parent().parent().find('.expanded').each( function() {
                        $(this).next().find('.node').each( function () {
                                if (!inArray($(this).attr('node_id'), nodesToDisplay))
                                {
                                        nodesToDisplay.push($(this).attr('node_id'));
                                }
                        });
                });
                
                placeMarkers(markersPool, nodesToDisplay);
                
                return false;
        });
});