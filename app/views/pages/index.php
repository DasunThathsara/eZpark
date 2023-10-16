<?php require APPROOT.'/views/inc/header.php'; ?>
    <!--  TOP NAVIGATION  -->
    <div class="topnav" style="background-color: white">
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

    <div class="container">
        <div class="row" style="display: flex; margin-top: 200px;">
            <div class="" style="width: 50%">
                <div class="" style="padding-left: 30px">
                    <h1 style="font-size: 55px; font-family: Candara; font-weight: 1500;">Search Parking<br />Anywhere</h1>
                    <p style="color: rgba(0,0,0,0.29);">At eZpark, we're committed to simplifying your parking experience and ensuring hassle-free journeys to your destination.</p>
                </div>
            </div>
            <div class="" style="width: 50%">
                <div class="">
                    <div class="black-circle" style="background-color: #1c1c1c; border-radius: 50%; height: 350px; width: 350px; position: absolute; right: 50px;"></div>
                    <div class="black-circle" style="background: linear-gradient(to right, rgb(248,215,90), rgb(255,156,19));; border-radius: 50%; height: 150px; width: 150px; z-index: 1; position: absolute; right: 70px; top: 200px;"></div>
                    <div class="black-circle" style="background: linear-gradient(to right, rgb(248,215,90), rgb(255,167,41));; border-radius: 50%; height: 70px; width: 70px; z-index: 1; position: absolute; right: 340px; top: 250px;"></div>
                    <div class="black-circle" style="background: linear-gradient(to right, rgb(248,215,90), rgb(255,167,41));; border-radius: 50%; height: 150px; width: 150px; z-index: 1; position: absolute; left: 80px; bottom: -50px;"></div>
                    <img src="<?php echo URLROOT ?>/images/phone.png" alt="" style="width: 220px; position: absolute; right: 80px; top: 250px; z-index: 1">
                    <img src="<?php echo URLROOT ?>/images/car.png" alt="" style="width: 300px; position: absolute; right: 170px; top: 450px">
                </div>
            </div>
        </div>
    </div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
