// ========== Google Map ========== //

$(function() {

    // Setup map
    function initialize() {
        $mapCanvas = $('#map-canvas');
        if($mapCanvas.length){
            console.log("Đả cài map");
            var lat = $mapCanvas.data("lat") || "20.7858135";
            var long = $mapCanvas.data("long") || "105.3462104";
            var contentString = $mapCanvas.data("place") || 'Your Office';
    
            
            // Options
            var myLatlng = new google.maps.LatLng(lat, long);
            var mapOptions = {
                zoom: 15,
                center: myLatlng
            };
    
            var map = new google.maps.Map($('#map-canvas')[0], mapOptions);
            
    
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
    
    
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: ''
            });
    
    
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
            });
    
        }
        
    };
	
		// Initialize map on window load
	google.maps.event.addDomListener(window, 'load', initialize);

});
	