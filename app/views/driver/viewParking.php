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
            <h1>Dashboard</h1>

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
                <!--                <a href="--><?php //echo URLROOT?><!--/deeds/--><?php //echo $data->deed ?><!--" style="background-color: #fcd426; border-radius: 10px; padding: 10px 20px 10px 20px">Directions</a>-->
                <a href="<?php echo URLROOT?>/driver/startAndStopTimer/<?php echo $data->id?>" style="background-color: #fcd426; border-radius: 10px; padding: 10px 20px 10px 20px">Enter Parking</a>
            </div>

        </div>

        <div class="" style="position: absolute; top: 52px; right: 50px; padding: 10px 20px; box-shadow: 0 0 10px 0.1px rgba(0,0,0,0.16); border-radius: 10px;" onclick="closeRightCard()">View Transaction</div>

        <div class="side-cards">
            <div class="close-btn" onclick="closeRightCard()">X</div>
            <h2>Packages</h2>

            <p><span>&#9632;</span>Today</p>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Nolimit</div>
                <div class="transaction-type in">In</div>
            </div>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Keels</div>
                <div class="transaction-type out">Out</div>
            </div>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Nolimit</div>
                <div class="transaction-type in">In</div>
            </div>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Keels</div>
                <div class="transaction-type out">Out</div>
            </div>

            <p><span>&#9632;</span>Yesterday</p>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Nolimit</div>
                <div class="transaction-type in">In</div>
            </div>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Keels</div>
                <div class="transaction-type out">Out</div>
            </div>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Nolimit</div>
                <div class="transaction-type in">In</div>
            </div>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Keels</div>
                <div class="transaction-type out">Out</div>
            </div>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
