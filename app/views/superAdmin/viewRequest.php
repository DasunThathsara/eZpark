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
            <div class="cover-img">
                <img class="cover-photo" src="<?php echo URLROOT ?>/images/parking_bg1.jpg" alt="Phone">
            </div>
            <div class="details">
                <h2><?php echo $data->name?></h2>
                <p>City: <?php echo $data->city?></p>
                <p>Street: <?php echo $data->street?></p>
                <p>Telephone Number: <?php echo $data->contactNo?></p>
                <p>Car: <?php echo $data->car?></p>
                <p>Bike: <?php echo $data->bike?></p>
                <p>Three wheel: <?php echo $data->threeWheel?></p>
                <a href="<?php echo URLROOT?>/deeds/<?php echo $data->deed ?>" style="background-color: #fcd426; border-radius: 10px; padding: 10px 20px 10px 20px">View deed</a>

                <div class="options" style="display: flex; margin-top: 20px">
                    <form action="<?php echo URLROOT ?>/admin/verifyLand" method="post" class="update-form">
                        <input type="text" name="id" id="id" hidden value="<?php echo $data->id?>" />
                        <button type="submit" style="border: none; background-color: rgb(255,255,255) onclick=" return confirmSubmit();">
                            <img src="<?php echo URLROOT ?>/images/tick.svg" style="width: 18px" alt="">
                        </button>
                    </form>
                    &nbsp;
                    <form action="<?php echo URLROOT ?>/admin/unverifyLand" method="post" class="delete-form">
                        <input type="text" name="id" id="id" hidden value="<?php echo $data->id?>" />
                        <button type="submit" style="border: none; background-color: rgb(255,255,255) onclick=" return confirmSubmit();">
                            <img src="<?php echo URLROOT ?>/images/circle-xmark-regular.svg" style="width: 18px;" alt="">
                        </button>
                    </form>
                </div>
            </div>

            <div class="map-area" style="width: 50vw; position: absolute; right: 40px; bottom: 40px;">
                <div id="map"></div>
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
