<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<div class="topnav" style="width: 96%; background: rgba(255,255,255,0.65); backdrop-filter: blur(20px); padding-left: 2%; padding-right: 2%; z-index: 1; box-shadow: none">
    <div class="container">
        <div class="items">
            <?php if (empty($_SESSION['user_id'])){ ?>
                <a class="item" style="margin-top: 20px" href="<?php echo URLROOT ?>/users/login">Login</a>     
                <a class="item" style="margin-top: 20px" href="<?php echo URLROOT ?>/users/register">Register</a>
                <a class="item logo" onclick="navToggle()"><img style="width: 150px" src="<?php echo URLROOT ?>/images/logo.png" alt=""></i></a>
            <?php } ?>
        </div>
    </div>
</div>

<div class="landing-container">
    <div class="row">
        <div class="col">
            <div class="left-col">
                <h1>Search Parking<br />Anywhere</h1>
                <p>At eZpark, we're committed to simplifying your parking experience and ensuring hassle-free journeys to your destination.</p>

                <form action="" style="width: 70%">
                    <input id="locationInput" type="text" placeholder="Enter a location">
                    <input type="submit">
                </form>
                
            </div>
        </div>
        <div class="col">
            <div class="right-col">
                <div class="black-circle-1"></div>
                <div class="yellow-circle-1"></div>
                <div class="yellow-circle-2"></div>
                <img class="phone" src="<?php echo URLROOT ?>/images/phone-1.png" alt="Phone">
                <img class="car" src="<?php echo URLROOT ?>/images/car1.png" alt="Car">
            </div>
        </div>
    </div>
<!--    <div class="yellow-circle-3"></div>-->
    <!--<div class="yellow-circle-4"></div>-->
    <div class="yellow-circle-5 anm"></div>

    <div class="parkingOwner-area">
        <div class="parking-img">
            <img class="parking-landing-img" src="<?php echo URLROOT ?>/images/landing-PO.png" alt="">
        </div>
        <div class="parking-details">f</div>
    </div>
</div>

<script>
    document.body.style.backgroundColor = 'white';
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GMAP?>&libraries=places"></script>
<script>
    function initMap() {
        var input = document.getElementById('locationInput');
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                console.error("Autocomplete's returned place contains no geometry");
                return;
            }

            // Access the selected place's details here
            console.log("Selected Place:", place.name, place.geometry.location.lat(), place.geometry.location.lng());
        });
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GMAP?>&libraries=places&callback=initMap"></script>




<?php require APPROOT.'/views/inc/footer.php'; ?>
