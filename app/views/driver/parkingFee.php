<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1>Independence Square Parking Lot - Colombo07</h1>
        </div>

        <div class="container">
            <h2>Total Time : 00:45:35</h2>
            <h2>Fee : Rs.150.00</h2>
        </div>

        <div class="container">
                <a href="<?php echo URLROOT ?>/driver/startTime">
                    <button>Online Payment</button>
                </a>

                <a href="<?php echo URLROOT ?>/driver/startTime">
                    <button>Manual Payment</button>
                </a>
        </div>        
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>