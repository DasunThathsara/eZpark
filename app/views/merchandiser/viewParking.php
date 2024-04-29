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
                            <form action="<?php echo URLROOT?>/merchandiser/requestParking" method="post">
                                <input type="text" value="<?php echo $data->landID?>" required hidden name="landID" id="landID">

                                <select name="baseLandID" id="baseLandID" class="baseLandID" required>
                                    <option value="" hidden disabled selected>Select Base Land</option>
                                    <?php foreach ($data->baseLands as $item){?>
                                        <option value="<?php echo $item->id ?>"><?php echo $item->name?></option>
                                    <?php }?>
                                </select>

                                <br>

                                <select name="duration" id="duration" class="duration" required>
                                    <option value="" hidden disabled selected>Select Duration</option>
                                    <option value="30">Month</option>
                                    <option value="7">Week</option>
                                </select>

                                <!-- Remove the id attribute from this input -->
                                <input type="text" value="<?php echo $data->id?>" name="otherBaseLandID" required hidden>

                                <button type="submit" style="border: none; outline: none; display: flex; justify-content: space-between; align-items: center; border-radius: 10px; padding: 5px 10px; background-color: #fccc04; color: white; width: 150px;">
                                    Request Parking<img class="parking-option-icon" src="<?php echo URLROOT ?>/images/Enter.png" alt="Parking" style="padding: 4px 0;">
                                </button>
                            </form>

                        </div>
                    </div>

                    <div class="slot-area">
                        <p style="color: gray; font-size: 14px;">Real-Time Availability</p>
                        <div class="slot-cards">
                            <div class="slot-card">
                                <div class="slot-card-title">
                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/motor-sports.png" alt="" class="vehicle-image">
                                </div>
                                <div class="slot-card-value"><span style="color: #ffb700"><?php echo $data->freeSLots['car']?></span> / <?php echo $data->car?></div>
                            </div>
                            <div class="slot-card">
                                <div class="slot-card-title">
                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/car-c.png" alt="" class="vehicle-image">
                                </div>
                                <div class="slot-card-value"><span style="color: #ffb700"><?php echo $data->freeSLots['bike']?></span> / <?php echo $data->bike?></div>
                            </div>
                            <div class="slot-card">
                                <div class="slot-card-title">
                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/tuk-tuk.png" alt="" class="vehicle-image">
                                </div>
                                <div class="slot-card-value"><span style="color: #ffb700"><?php echo $data->freeSLots['threeWheel']?></span> / <?php echo $data->threeWheel?></div>
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
                            <?php if (empty($data->packages)){?>
                                <div style="border: 2px dotted rgb(252,204,4); background-color: rgba(252,204,4,0.04); color: #a98000; border-radius: 20px; padding: 10px; width: calc(100%); height: 100px; display: flex; align-items: center; justify-content: center">No Packages Available</div>
                            <?php }
                            else{?>
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

<?php require APPROOT.'/views/inc/footer.php'; ?>
