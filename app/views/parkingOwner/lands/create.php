<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'lands';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1 class="title">Add a New Land</h1>
            <p class="subtitle">Fill up the below informations correctly to add a new land</p>

            <div class="form-container land-register-form">
                <br>
                <?php if (!empty($data['err'])){?>
                    <div class="error-msg">
                        <span class="form-invalid"><?php echo $data["err"] ?></span>
                    </div>
                <?php } ?>

                <form action="<?php echo URLROOT ?>/land/landRegister" method="post" enctype="multipart/form-data">
                    <!-- Name -->
                    <div class="form-input-title">Name of the parking:</div>
                    <input type="text" name="name" id="name" required value="<?php echo $data['name'] ?>" />

                    <br><br>

                    <!-- Address -->
                    <div class="form-input-title">Address:</div>
                    <input type="text" name="address" id="address" required value="<?php echo $data['address'] ?>" />

                    <br><br>

                    <!-- Street -->
                    <div class="form-input-title">Street:</div>
                    <input type="text" name="street" id="street" required value="<?php echo $data['street'] ?>" />

                    <br><br>

                    <!-- City -->
                    <div class="form-input-title">City:</div>
                    <input type="text" name="city" id="city" required value="<?php echo $data['city'] ?>" />

                    <br><br>

                    <!-- District -->
                    <div class="form-input-title">District:</div>
                    <select name="district" id="district" class="district" required>
                        <option value="" disabled selected>Select District</option>
                        <option value="Ampara" <?php if ($data['district'] == 'Ampara') echo 'selected' ?>>Ampara</option>
                        <option value="Anuradhapura" <?php if ($data['district'] == 'Anuradhapura') echo 'selected' ?>>Anuradhapura</option>
                        <option value="Badulla" <?php if ($data['district'] == 'Badulla') echo 'selected' ?>>Badulla</option>
                        <option value="Batticaloa" <?php if ($data['district'] == 'Batticaloa') echo 'selected' ?>>Batticaloa</option>
                        <option value="Colombo" <?php if ($data['district'] == 'Colombo') echo 'selected' ?>>Colombo</option>
                        <option value="Galle" <?php if ($data['district'] == 'Galle') echo 'selected' ?>>Galle</option>
                        <option value="Gampaha" <?php if ($data['district'] == 'Gampaha') echo 'selected' ?>>Gampaha</option>
                        <option value="Hambantota" <?php if ($data['district'] == 'Hambantota') echo 'selected' ?>>Hambantota</option>
                        <option value="Jaffna" <?php if ($data['district'] == 'Jaffna') echo 'selected' ?>>Jaffna</option>
                        <option value="Kandy" <?php if ($data['district'] == 'Kandy') echo 'selected' ?>>Kandy</option>
                        <option value="Kalutara" <?php if ($data['district'] == 'Kalutara') echo 'selected' ?>>Kalutara</option>
                        <option value="Kegalle" <?php if ($data['district'] == 'Kegalle') echo 'selected' ?>>Kegalle</option>
                        <option value="Kilinochchi" <?php if ($data['district'] == 'Kilinochchi') echo 'selected' ?>>Kilinochchi</option>
                        <option value="Kurunegala" <?php if ($data['district'] == 'Kurunegala') echo 'selected' ?>>Kurunegala</option>
                        <option value="Mannar" <?php if ($data['district'] == 'Mannar') echo 'selected' ?>>Mannar</option>
                        <option value="Matara" <?php if ($data['district'] == 'Matara') echo 'selected' ?>>Matara</option>
                        <option value="Matale" <?php if ($data['district'] == 'Matale') echo 'selected' ?>>Matale</option>
                        <option value="Monaragala" <?php if ($data['district'] == 'Monaragala') echo 'selected' ?>>Monaragala</option>
                        <option value="Mullaitivu" <?php if ($data['district'] == 'Mullaitivu') echo 'selected' ?>>Mullaitivu</option>
                        <option value="Nuwara Eliya" <?php if ($data['district'] == 'Nuwara Eliya') echo 'selected' ?>>Nuwara Eliya</option>
                        <option value="Polonnaruwa" <?php if ($data['district'] == 'Polonnaruwa') echo 'selected' ?>>Polonnaruwa</option>
                        <option value="Puttalam" <?php if ($data['district'] == 'Puttalam') echo 'selected' ?>>Puttalam</option>
                        <option value="Ratnapura" <?php if ($data['district'] == 'Ratnapura') echo 'selected' ?>>Ratnapura</option>
                        <option value="Trincomalee" <?php if ($data['district'] == 'Trincomalee') echo 'selected' ?>>Trincomalee</option>
                        <option value="Vavuniya" <?php if ($data['district'] == 'Vavuniya') echo 'selected' ?>>Vavuniya</option>
                    </select>

                    <br><br>

                    <!-- map button -->
                    <div id="map" class="map"></div>
                    <div onclick="showMap()" id="map-btn" class="map-btn">Done</div>

                    <div class="map-details">
                        <div onclick="showMap()" class="map-trigger-btn">Pick from the map</div>

                        <br>
                        <!-- latitude -->
                        <div class="form-input-title">Latitude:</div>
                        <input class="latitude" type="text" name="latitude" id="latitude" required value="<?php echo $data['latitude'] ?>" />

                        <br><br>

                        <!-- longitude -->
                        <div class="form-input-title">Latitude:</div>
                        <input class="longitude" type="text" name="longitude" id="longitude" required value="<?php echo $data['longitude'] ?>" />
                    </div>

                    <br><br>

                    <!-- contactNo -->
                    <div class="form-input-title">Contact Number:</div>
                    <input class="contact-no" type="text" name="contactNo" id="contactNo" required value="<?php echo $data['contactNo'] ?>" />

                    <br><br>

                    <!-- Deed -->
                    <div class="form-input-title">Deed:</div>
                    <div class="file-upload-container">
                        <label class="file-upload" for="deed">Upload File</label>
                        <input type="file" name="deed" id="deed" hidden />
                        <div class="description">*Upload deed in PDF format</div>
                    </div>

                    <br><br>

                    <!--Number of available slots-->
                    <div class="form-input-title">Number of available parking slots:</div>
                    <div class="slots-container">
                        <div class="slots">
                            <div class="slots-title">Car</div>
                            <input class="slot-value-field" type="number" name="car" id="car" required value="<?php echo $data['car'] ?>" />
                        </div>
                        <div class="slots">
                            <div class="slots-title">Bike</div>
                            <input class="slot-value-field" type="number" name="bike" id="bike" required value="<?php echo $data['bike'] ?>" />
                        </div>
                        <div class="slots">
                            <div class="slots-title">Three Wheel</div>
                            <input class="slot-value-field" type="number" name="threeWheel" id="threeWheel" required value="<?php echo $data['threeWheel'] ?>" />
                        </div>
                    </div>

                    <br><br>

                    <!-- Upload 3 images about parking -->
                    <div class="form-input-title">Upload 3 images about parking:</div>
                    <div class="file-upload-container">
                        <label class="file-upload" for="cover">Cover Photo</label>
                        <input type="file" name="cover" id="cover" hidden required />
                    </div>
                    <div class="file-upload-container">
                        <label class="file-upload" for="image1">Upload Image 1</label>
                        <input type="file" name="image1" id="image1" hidden />
                    </div>
                    <div class="file-upload-container">
                        <label class="file-upload" for="image2">Upload Image 2</label>
                        <input type="file" name="image2" id="image2" hidden />
                    </div>
                    <div class="file-upload-container">
                        <label class="file-upload" for="image3">Upload Image 3</label>
                        <input type="file" name="image3" id="image3" hidden />
                    </div>

                    <br><br>

                    <!-- Submit -->
                    <input type="submit" value="Next">
                </form>
            </div>
        </div>

        <div class="open-side-cards-btn" onclick="closeRightCardInForm()">View Instructions</div>

        <div class="side-cards">
            <div class="close-btn" onclick="closeRightCardInForm()">X</div>
            <h2>Instructions</h2>

            <br>

            <p><span>&#9632;</span>Sample image</p>

            <div style="display: flex; justify-content: center;">
                <div class="instruction-img" style="width: 90%;">
                    <img style="width: 100%; border-radius: 20px;" src="<?php echo URLROOT ?>/public/images/parking_bg1.jpg" alt="land-register-1">
                </div>
            </div>

            <br><br>

            <p><span>&#9632;</span>Sizes</p>
            <div style="margin-left: 30px; font-size: 13px;">
                <div style="margin-top: 10px;">Car: 4x5</div>
                <div style="margin-top: 10px;">Bike: 2x4</div>
                <div style="margin-top: 10px;">Three Wheel: 3x4</div>
            </div>
        </div>
    </section>
</main>

<script>
    function closeRightCardInForm(){
        var screenWidth = window.innerWidth;
        var element1, element2, element3;

        if (screenWidth <= 720){
            element1 = document.querySelector('.side-cards');
            element1.classList.toggle("side-cards-active");

            element2 = document.querySelector('.open-side-cards-btn');
            element2.classList.toggle("open-side-cards-btn-hide");
        }
        else {
            element1 = document.querySelector('.side-cards');
            element1.classList.toggle("side-cards-hide");

            element2 = document.querySelector('.open-side-cards-btn');
            element2.classList.toggle("open-side-cards-btn-active");

            element3 = document.querySelector('.land-register-form');
            element3.classList.toggle("land-register-form-expand");
        }
    }

    function showMap(){
        var element1, element2;
        element1 = document.querySelector('.map');
        element1.classList.toggle("map-active");

        element1 = document.querySelector('.map-details');
        element1.classList.toggle("map-details-hide");

        var mapBtn = document.getElementById('map-btn');
        mapBtn.classList.toggle('map-btn-active');
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GMAP?>&callback=initMap" async defer></script>
<script>
    var map;

    async function initMap() {
        map = await new google.maps.Map(document.getElementById('map'), {
            center: {lat: 6.8, lng: 79.8612},
            zoom: 2
        });

        // Try HTML5 geolocation to get the user's location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Set map center to user's location
                map.setCenter(userLocation);
                map.setZoom(15); // Optionally adjust zoom level

                var iconSize = new google.maps.Size(40, 40);

                // Place a marker at the user's location
                var marker = new google.maps.Marker({
                    position: userLocation,
                    map: map,
                    draggable: true,
                    icon: {
                        url: '<?php echo URLROOT ?>/public/images/pin1.png',
                        scaledSize: iconSize
                    }
                });

                // Event listener for marker dragend
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    document.getElementById('latitude').value = this.getPosition().lat();
                    document.getElementById('longitude').value = this.getPosition().lng();
                });
            }, function() {
                // Handle Geolocation error
                handleLocationError(true, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, map.getCenter());
        }
    }

    function handleLocationError(browserHasGeolocation, pos) {
        var infoWindow = new google.maps.InfoWindow({
            map: map,
            position: pos,
            content: browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.'
        });
    }
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
