<div class="sidenav">
    <div class="container">
        <div class="logo"><img src="<?php echo URLROOT ?>/images/logo.png" alt=""></div>
        <a class="sidenav-close-btn" onclick="navToggle()">X</a>
        <div class="items">
            <div class="item selected"><img src="<?php echo URLROOT ?>/images/home.svg" alt="">Dashboard</div>
            <div class="item"><img src="<?php echo URLROOT ?>/images/booking.svg" alt="">Bookings</a></div>
            <div class="item"><img src="<?php echo URLROOT ?>/images/search.svg" alt="">Search Parking</div>
            <div class="item"><img src="<?php echo URLROOT ?>/images/history.svg" alt="">Parking History</div>
            <div class="item"><img src="<?php echo URLROOT ?>/images/package.svg" alt="">Packages</div>
            <a href="<?php echo URLROOT ?>/users/login">
                <div class="item"><img src="<?php echo URLROOT ?>/images/vehicle.svg" alt="">Vehicles</div>
            </a>
            <div class="item"><img src="<?php echo URLROOT ?>/images/rating.svg" alt="">Rating</div>
            <div class="item"><img src="<?php echo URLROOT ?>/images/profile.svg" alt="">Profile</div>
            <div class="logout"><a href="<?php echo URLROOT ?>/users/logout">Logout</a></div>
        </div>
    </div>
</div>

<script>
    function navToggle() {
        console.log("pushed")
        var element;
        element = document.querySelector('.sidenav');
        element.classList.toggle("sidenav-toggled");
    }
</script>