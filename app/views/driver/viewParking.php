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
            <h1 class="title">View Parking</h1>
            <p class="subtitle">View real-time information about the parking before entering</p>

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
                            <a class="parking-option" href="<?php echo URLROOT?>/driver/enterExitParking/<?php echo $data->id?>">
                                <div class="parking-option-text">Enter Parking</div>
                                <div class="parking-option-icon">
                                    <img class="parking-option-icon" src="<?php echo URLROOT ?>/images/Enter.png" alt="Parking">
                                </div>
                            </a>

                            <a class="parking-option second-option" href="<?php echo URLROOT?>/driver/directionToParking/<?php echo $data->id?>">
                                <div class="parking-option-text">Get Direction</div>
                                <div class="parking-option-icon">
                                    <img class="parking-option-icon" src="<?php echo URLROOT ?>/images/Navigation.png" alt="Parking">
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="slot-area">
                        <p style="color: gray; font-size: 12px;">Real-Time Availability</p>
                        <div class="slot-cards">
                            <div class="slot-card">
                                <div class="slot-card-title">
                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/motor-sports.png" alt="" class="vehicle-image">
                                </div>
                                <div class="slot-card-value"><?php echo $data->car?> / <?php echo $data->car?></div>
                            </div>
                            <div class="slot-card">
                                <div class="slot-card-title">
                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/car-c.png" alt="" class="vehicle-image">
                                </div>
                                <div class="slot-card-value"><?php echo $data->bike?> / <?php echo $data->bike?></div>
                            </div>
                            <div class="slot-card">
                                <div class="slot-card-title">
                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/tuk-tuk.png" alt="" class="vehicle-image">
                                </div>
                                <div class="slot-card-value"><?php echo $data->threeWheel?> / <?php echo $data->threeWheel?></div>
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

                    <div class="package-area">
                        <div style="color: #fccc04; margin-top: 60px; font-size: 25px;">Available Packages</div>
                        <div class="package-cards">
                            <?php foreach ($data->packages as $package){?>
                                <div class="package-card">
                                    <div class="package-vehicle-type">
                                        <?php echo $package->packageType?> Parking Package
                                    </div>

                                    <div class="package-type">
                                        <?php echo $package->name?> • 1 Vehicle
                                    </div>

                                    <?php if ($package->name == 'monthly'){?>
                                        <div class="package-expire">Available till <?php echo date('Y-m-d', strtotime(date('Y-m-d') . ' +1 month'))?></div>
                                    <?php }?>

                                    <?php if ($package->name == 'weekly'){?>
                                        <div class="package-expire">Available till <?php echo date('Y-m-d', strtotime(date('Y-m-d') . ' +1 week'))?></div>
                                    <?php }?>

                                    <div class="package-option">
                                        <div class="package-price">
                                            LKR <?php echo $package->price?>
                                        </div>

                                        <div class="subscribe-btn">
                                            <?php if (empty($package->status)){?>
                                                <form action="<?php echo URLROOT?>/driver/subscribePackage" method="post">
                                                    <input type="text" name="landID" id="landID" value="<?php echo $data->id?>" hidden required>
                                                    <input type="text" name="vehicleType" id="vehicleType" value="<?php echo $package->packageType?>" hidden required>
                                                    <input type="text" name="packageType" id="packageType" value="<?php echo $package->name?>" hidden required>
                                                    <input type="submit" style="background-color: #fccc04; border-radius: 10px; padding: 10px; width: 100px; transform: translateY(-5px)" value="Subscribe">
                                                </form>
                                            <?php } else {?>
                                                <button style="color: black; background-color: white; border-radius: 10px; padding: 10px; width: 100px; outline: none; border: 1px solid #fccc04;">Subscribed</button>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
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

<!--<main class="page-container">-->
<!--    <section class="section" id="main">-->
<!--        <div class="container">-->
<!--            <h1>Dashboard</h1>-->
<!---->
<!--            <div class="cover-img">-->
<!--                <img class="cover-photo" src="--><?php //echo URLROOT ?><!--/images/parking_bg1.jpg" alt="Phone">-->
<!--            </div>-->
<!--            <div class="details">-->
<!--                <h2>--><?php //echo $data->name?><!--</h2>-->
<!--                <p>City: --><?php //echo $data->city?><!--</p>-->
<!--                <p>Street: --><?php //echo $data->street?><!--</p>-->
<!--                <p>Telephone Number: --><?php //echo $data->contactNo?><!--</p>-->
<!--                <p>Car: --><?php //echo $data->car?><!--</p>-->
<!--                <p>Bike: --><?php //echo $data->bike?><!--</p>-->
<!--                <p>Three wheel: --><?php //echo $data->threeWheel?><!--</p>-->
<!--                <a href="--><?php //echo URLROOT?><!--/driver/enterExitParking/--><?php //echo $data->id?><!--" style="background-color: #fcd426; border-radius: 10px; padding: 10px 20px 10px 20px">Enter Parking</a>-->
<!--                <a href="--><?php //echo URLROOT?><!--/driver/directionToParking/--><?php //echo $data->id?><!--" style="background-color: #fcd426; border-radius: 10px; padding: 10px 20px 10px 20px">Get Directions</a>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="" style="position: absolute; top: 52px; right: 50px; padding: 10px 20px; box-shadow: 0 0 10px 0.1px rgba(0,0,0,0.16); border-radius: 10px;" onclick="closeRightCard()">View Transaction</div>-->
<!---->
<!--        <div class="side-cards">-->
<!--            <div class="close-btn" onclick="closeRightCard()">X</div>-->
<!--            <h2>Packages</h2>-->
<!---->
<!--            --><?php //foreach ($data->packages as $package){?>
<!--                <div class="package-card" style="background-color: #ffffff; border-radius: 10px; margin: 10px; padding: 10px; box-shadow: 0 0 10px 0.1px rgba(0,0,0,0.19);">-->
<!--                    <div class="package-type" style="font-size: 15px; font-weight: 1000">--><?php //echo $package->packageType?><!-- - --><?php //echo $package->name?><!--</div>-->
<!--                    <div class="package-price" style="margin-top: 5px;">Price: Rs. --><?php //echo $package->price?><!--</div>-->
<!---->
<!--                    --><?php //if ($package->name == 'monthly'){?>
<!--                        <div class="package-price" style="margin-top: 5px;">Valid till: --><?php //echo date('Y-m-d', strtotime(date('Y-m-d') . ' +1 month'))?><!--</div>-->
<!--                    --><?php //}?>
<!--                    --><?php //if ($package->name == 'weekly'){?>
<!--                        <div class="package-price" style="margin-top: 5px;">Valid till: --><?php //echo date('Y-m-d', strtotime(date('Y-m-d') . ' +1 week'))?><!--</div>-->
<!--                    --><?php //}?>
<!---->
<!--                    --><?php //if (empty($package->status)){?>
<!--                        <form action="--><?php //echo URLROOT?><!--/driver/subscribePackage" method="post">-->
<!--                            <input type="text" name="landID" id="landID" value="--><?php //echo $data->id?><!--" hidden required>-->
<!--                            <input type="text" name="vehicleType" id="vehicleType" value="--><?php //echo $package->packageType?><!--" hidden required>-->
<!--                            <input type="text" name="packageType" id="packageType" value="--><?php //echo $package->name?><!--" hidden required>-->
<!--                            <input type="submit" style="background-color: #fccc04; border-radius: 10px; padding: 10px; width: 100px; position: absolute; margin-top: -60px; margin-left: 160px;" value="Subscribe">-->
<!--                        </form>-->
<!--                    --><?php //} else {?>
<!--                        <button style="color: black; background-color: white; border-radius: 10px; padding: 10px; width: 100px; position: absolute; margin-top: -60px; margin-left: 160px; outline: none; border: 1px solid #fccc04">Subscribed</button>-->
<!--                    --><?php //}?>
<!--                </div>-->
<!--            --><?php //}?>
<!--        </div>-->
<!--    </section>-->
<!--</main>-->

<?php require APPROOT.'/views/inc/footer.php'; ?>
