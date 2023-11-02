<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h2>Independence Square Parking Lot - Colombo07</h2>
            <img class="mechandiserParkingImage" src="<?php echo URLROOT ?>/images/parkingForMerchandiser.jpg" alt="Phone">
        </div>

        <div class="container">
                <a href="<?php echo URLROOT ?>/driver/startTime">
                    <button>Enter the parking</button>
                </a>
        </div>        
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>