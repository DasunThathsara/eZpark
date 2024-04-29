<?php require APPROOT . '/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'findParking';
require APPROOT . '/views/inc/components/sidenavbar.php';
?>

<script
    src="https://kit.fontawesome.com/3d9946f29b.js"
    crossorigin="anonymous"
></script>

<main class="page-container">

    <!-- Rating window start -->
    <?php if(isset($_GET['completion_status'])){?>
        <div class="overlay1 overlay" id="overlay1">
            <div class="get-direction light-box">
                <p class="close-btn1 close-btn do-not">
                    <i class="fas fa-xmark"></i>
                </p>
                <form id="ratingForm" action="<?php echo URLROOT?>/driver/addRatingReviewComplaint" method="post">
                    <div class="direction-container">
                        <div class="completion-container">
                            <input type="text" name="landID" hidden value="<?php echo $_GET['completion_status']?>">
                            <h2 class="rating-title">Transaction completed!<br /><span style="font-size: 20px; margin-top: 10px; color: #6b6b6b">Rate to the parking location</span></h2>
                            <div class="rate">
                                <input type="radio" id="star5" name="rate" value="5" />
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rate" value="4" />
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rate" value="3" />
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rate" value="2" />
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rate" value="1" />
                                <label for="star1" title="text">1 star</label>
                            </div>

                            <textarea class="review-box" name="review-message" id="review-message" placeholder="Add Review..." cols="30" rows="10"></textarea>

                            <label class="check-box-area">
                                <br>
                                <input class="check-box" type="checkbox" name="complaint">
                                Make Complaint for the parking
                            </label>

                            <input type="submit" id="submitButton" value="Send" style="margin-left: 50px; margin-right: 50px; width: calc(100% - 100px); background-color: #ffc536; margin-top: 30px" disabled>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php }?>
    </div>
    <!-- Rating window end -->

    <section class="section" id="main">
        <div class="container">
            <div id="map" style="margin-top: 50px; height: 80vh; border-radius: 10px;"></div>
        </div>
    </section>
</main>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GMAP ?>"></script>
<script>
    function initMap() {
        // Initialize the map centered on the user's current location
        navigator.geolocation.getCurrentPosition(function (position) {
            var userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            var map = new google.maps.Map(document.getElementById('map'), {
                center: userLocation,
                zoom: 14
            });

            var iconSize = new google.maps.Size(40, 40);

            // Add a marker for the user's current location
            var userMarker = new google.maps.Marker({
                position: userLocation,
                map: map,
                title: 'Your Current Location',
                icon: {
                    url: '<?php echo URLROOT ?>/public/images/pin1.png',
                    scaledSize: iconSize
                }
            });

            // Define multiple locations to be displayed on the map
            var locations = [
                <?php foreach ($data as $land) {
                    echo "{ lat: $land->latitude, lng: $land->longitude, name: '$land->name', type: '$land->availability', car: '$land->car', bike: '$land->bike', threeWheel: '$land->threeWheel', url: 'viewParking/$land->id' },\n";
                }?>
            ];

            console.log(locations);

            // Add markers for each location
            locations.forEach(function (location) {
                var markerIcon;
                if (location.type === '1') {
                    markerIcon = '<?php echo URLROOT ?>/public/images/pin-g.png';
                } else if (location.type === '0') {
                    markerIcon = '<?php echo URLROOT ?>/public/images/pin-r.png';
                } else {
                    markerIcon = '<?php echo URLROOT ?>/public/images/pin-y.png';
                }

                // Create a marker for each location
                var marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: location.name,
                    icon: {
                        url: markerIcon,
                        scaledSize: iconSize
                    }
                });

                // Create an InfoWindow for each marker
                var infoWindow = new google.maps.InfoWindow({
                    content: '<div><b><center>' + location.name + '</center></b><br>Available slots<br>&#8226; Car: ' + location.car + '<br>&#8226; Bike: ' + location.bike + '<br>&#8226; Three Wheel: ' + location.threeWheel + '</div>'
                });

                // Show InfoWindow when marker is hovered over
                marker.addListener('mouseover', function () {
                    infoWindow.open(map, marker);
                });

                // Close InfoWindow when mouse leaves marker
                marker.addListener('mouseout', function () {
                    infoWindow.close();
                });

                // Set URL to the marker
                marker.addListener('click', function () {
                    var markerUrl = location.url;
                    window.location.href = markerUrl;
                });
            });
        });
    }

    initMap();
</script>
<script>
    const body = document.querySelector("body"),
        closeBtn1 = body.querySelector(".close-btn1");

    closeBtn1.addEventListener("click", () => {
        document.querySelector(".get-direction").style.display = "none";
    });

    history.pushState(null, null, 'http://localhost/eZpark/driver/index');





    // Get all radio buttons
    var radioButtons = document.querySelectorAll('input[type="radio"][name="rate"]');
    // Get submit button
    var submitButton = document.getElementById('submitButton');

    // Add event listener to radio buttons
    radioButtons.forEach(function(radioButton) {
        radioButton.addEventListener('change', function() {
            // Enable submit button if any radio button is checked
            submitButton.disabled = false;
        });
    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
