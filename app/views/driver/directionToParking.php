<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'driver';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <div class="mapDirection">
                <img src="<?php echo URLROOT ?>/images/directionToParking.jpg" alt="">
            </div>

            <div class="mapDirection">
                <a href="#">
                    <button><img src="<?php echo URLROOT ?>/images/QR_icon.png" alt="QR icon">Scan QR Code</button>
                </a>
            </div>
        </div>

    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>