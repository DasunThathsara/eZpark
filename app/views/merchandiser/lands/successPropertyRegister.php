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
            <h1 class="title">Congratulations!! <br /> Your land was created</h1>
            <p class="subtitle" style="font-size: 15px">Please wait for admin approval</p>
            <?php if(isset($_GET['error'])){?>
                <div style="color: red; background-color: rgba(255,0,0,0.05); border-radius: 10px; padding: 5px; width: calc(100% - 30px); text-align: center; border: 1px solid rgba(255,0,0,0.1); margin-top: 30px; font-size: 13px;">
                    You have no any free vehicle to enter the parking
                </div>
            <?php }?>
            <div class="view-parking-container " style="">
                <div class="parking-cover-container">
                    <img class="parking-cover" src="<?php echo URLROOT ?>/images/parking_bg1.jpg" alt="Phone">
                </div>

                <div class="parking-details">
                    <div class="main-area">
                        <div class="parking-about">
                            <div class="parking-name"><?php echo $data->name?></div>
                            <div class="parking-address"><?php echo ucwords($data->address)?>, <?php echo ucwords($data->street)?>, <?php echo ucwords($data->city)?></div>
                            <div class="parking-open-time">Open Hours: 8.30 AM - 9.30 PM</div>
                        </div>
                        <div class="parking-directions">
                            <a class="parking-option second-option" href="<?php echo URLROOT?>/deeds/<?php echo $data->deed ?>" style="height: 60px;">
                                <div class="parking-option-text">View Deed</div>
                                <div class="parking-option-icon">
                                    <img class="parking-option-icon" src="<?php echo URLROOT ?>/images/booking.png" alt="Parking" style="padding: 10px 0;">
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="slot-area">
                        <p style="color: gray; font-size: 14px;">Real-Time Availability</p>
                        <div class="slot-cards">
                            <div class="slot-card">
                                <div class="slot-card-title">
                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/motor-sports.png" alt="" class="vehicle-image">
                                </div>
                                <div class="slot-card-value"><?php echo $data->car?></div>
                            </div>
                            <div class="slot-card">
                                <div class="slot-card-title">
                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/car-c.png" alt="" class="vehicle-image">
                                </div>
                                <div class="slot-card-value"><?php echo $data->bike?></div>
                            </div>
                            <div class="slot-card">
                                <div class="slot-card-title">
                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/tuk-tuk.png" alt="" class="vehicle-image">
                                </div>
                                <div class="slot-card-value"><?php echo $data->threeWheel?></div>
                            </div>
                        </div>
                    </div>

                    <div class="location-area">
                        <div class="map-section">
                            <div id="map" style="border-radius: 20px 0 0 20px; height: 100%"></div>
                        </div>
                        <div class="address-section">
                            <div class="address">
                                <div style="display: grid">
                                    <div style="color: #6b6b6b; font-size: 15px; width: 100%;">Address</div>
                                    <div style="color: #000000; font-size: 15px; width: 100%; margin-top: 5px"><?php echo ucwords($data->address)?>,<br /><?php echo ucwords($data->street)?>, <?php echo ucwords($data->city)?></div>
                                </div>
                            </div>
                            <div class="contact-no">
                                <div style="display: grid">
                                    <div style="color: #6b6b6b; font-size: 15px; width: 100%;">Contact Number</div>
                                    <div style="color: #000000; font-size: 15px; width: 100%; margin-top: 5px"><?php echo ucwords($data->contactNo)?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GMAP;?>"></script>
<script>
    function initMap() {
        // Specify the latitude and longitude coordinates of the location
        var latitude = <?php echo $data->latitude?>;
        var longitude = <?php echo $data->longitude?>;

        // Create a new map centered on the location
        var location = { lat: latitude, lng: longitude };
        var map = new google.maps.Map(document.getElementById('map'), {
            center: location,
            zoom: 15
        });

        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: '<?php echo $data->name?>'
        });
    }

    // Initialize the map when the page loads
    initMap();
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
