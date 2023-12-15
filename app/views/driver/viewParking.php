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
                <a href="<?php echo URLROOT?>/deeds/<?php echo $data->deed ?>" style="background-color: #fcd426; border-radius: 10px; padding: 10px 20px 10px 20px">Directions</a>
            </div>
        </div>
    </section>
</main>
<?php require APPROOT.'/views/inc/footer.php'; ?>
