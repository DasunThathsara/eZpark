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
            <img class="table" style="height: 50vh" src="<?php echo URLROOT ?>/images/parkingForMerchandiser.jpg" alt="Phone">
            <div class="content" style="width: 100%; text-align: center">
                <h2><?php echo $data['name'] ?> Added Successfully</h2>
                <dl>
                    <dd>Car : <?php echo $data['car'] ?></dd>
                    <dd>Bike : <?php echo $data['bike'] ?></dd>
                    <dd>Three Wheel : <?php echo $data['threeWheel'] ?></dd>
                </dl>
            </div>
        </div>
    </section>
</main>
<?php require APPROOT.'/views/inc/footer.php'; ?>
