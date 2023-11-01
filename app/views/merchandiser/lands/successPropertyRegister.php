<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'rating';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
        <img class="mechandiserParkingImage" src="<?php echo URLROOT ?>/images/parkingForMerchandiser.jpg" alt="Phone">
        <h2>Ratha Gala - Colombo03</h2>
        </div>

        <div class="container">
        <h1>Parking Added Successfully</h1>
        </div>
    </section>
</main>
<?php require APPROOT.'/views/inc/footer.php'; ?>
