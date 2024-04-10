<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'dashboard';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <div id="map" style="margin-top: 50px; height: 80vh; border-radius: 10px;"></div>
            <div class="start-btn" style="margin-top: 10px;">
                <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $data->latitude?>,<?php echo $data->longitude?>" target="_blank" style="background-color: #fcd426; border-radius: 10px; padding: 10px 20px 10px 20px">Start</a>
                <a href="<?php echo URLROOT?>/driver/gotoLand/<?php echo $data->id?>" style="background-color: #fcd426; border-radius: 10px; padding: 10px 20px 10px 20px">Go back to parking</a>
            </div>
        </div>
    </section>
</main>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GMAP?>"></script>
<script>
    function initMap() {
        // Initialize the map centered on the user's current location
        navigator.geolocation.getCurrentPosition(function(position) {
            var userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            var map = new google.maps.Map(document.getElementById('map'), {
                center: userLocation,
                zoom: 15
            });

            var iconSize = new google.maps.Size(40, 40);

            // Create marker for current location
            var userMarker = new google.maps.Marker({
                position: userLocation,
                map: map,
                title: 'Your Current Location',
                icon: {
                    url: '<?php echo URLROOT ?>/public/images/pin-y.png',
                    scaledSize: iconSize
                }
            });

            // Define the destination location
            var destination = new google.maps.LatLng(<?php echo $data->latitude ?>, <?php echo $data->longitude ?>);

            // Create marker for destination location
            var destinationMarker = new google.maps.Marker({
                position: destination,
                map: map,
                title: 'Destination',
                icon: {
                    url: '<?php echo URLROOT ?>/public/images/pin-g.png',
                    scaledSize: iconSize
                }
            });

            // Create a LatLngBounds object to encompass both current and destination locations
            var bounds = new google.maps.LatLngBounds();
            bounds.extend(userLocation);
            bounds.extend(destination);

            // Fit the map to the bounds
            map.fitBounds(bounds);

            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true // Do not display default markers along the route
            });

            // Define the request for directions
            var request = {
                origin: userLocation,
                destination: destination,
                travelMode: 'DRIVING' // You can change this to other travel modes like 'WALKING', 'BICYCLING', 'TRANSIT'
            };

            // Get directions from the DirectionsService
            directionsService.route(request, function(result, status) {
                if (status == 'OK') {
                    // Display the directions on the map
                    directionsRenderer.setDirections(result);
                } else {
                    // Handle errors
                    window.alert('Directions request failed due to ' + status);
                }
            });
        });
    }

    initMap();
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
