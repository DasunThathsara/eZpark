<?php require APPROOT.'/views/inc/header.php'; ?>
    <!--  TOP NAVIGATION  -->
    <div class="topnav" style="width: 96%; background-color: rgba(255,255,255,0); padding-left: 2%; padding-right: 2%; z-index: 1">
        <div class="container">
            <div class="items">
                <?php if (empty($_SESSION['user_id'])){ ?>
                    <a class="item" href="<?php echo URLROOT ?>/users/login">Login</a>
                    <a class="item" href="<?php echo URLROOT ?>/users/register">Register</a>
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
                </div>
            </div>
            <div class="col">
                <div class="right-col">
                    <div class="black-circle-1"></div>
                    <div class="yellow-circle-1"></div>
                    <div class="yellow-circle-2"></div>
                    <div class="yellow-circle-3"></div>
<!--                    <div class="yellow-circle-4"></div>-->
                    <div class="yellow-circle-5"></div>
                    <img class="phone" src="<?php echo URLROOT ?>/images/phone.png" alt="Phone">
                    <img class="car" src="<?php echo URLROOT ?>/images/car1.png" alt="Car">
                </div>
            </div>
        </div>
    </div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
