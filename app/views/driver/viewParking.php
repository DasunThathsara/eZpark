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

            <?php foreach ($data->packages as $package){?>
                <div class="package-card" style="background-color: #ffffff; border-radius: 10px; margin: 10px; padding: 10px; box-shadow: 0 0 10px 0.1px rgba(0,0,0,0.19);">
                    <div class="package-type" style="font-size: 15px; font-weight: 1000"><?php echo $package->packageType?> - <?php echo $package->name?></div>
                    <div class="package-price" style="margin-top: 5px;">Price: Rs. <?php echo $package->price?></div>

                    <?php if ($package->name == 'monthly'){?>
                        <div class="package-price" style="margin-top: 5px;">Valid till: <?php echo date('Y-m-d', strtotime(date('Y-m-d') . ' +1 month'))?></div>
                    <?php }?>
                    <?php if ($package->name == 'weekly'){?>
                        <div class="package-price" style="margin-top: 5px;">Valid till: <?php echo date('Y-m-d', strtotime(date('Y-m-d') . ' +1 week'))?></div>
                    <?php }?>
                    <a href="<?php echo URLROOT?>/driver/subscribePackage/<?php echo $data->id?>" style="background-color: #fccc04; border-radius: 10px; padding: 10px 20px 10px 20px; position: absolute; margin-top: -60px; margin-left: 150px;">Subscribe</a>
                </div>
            <?php }?>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
