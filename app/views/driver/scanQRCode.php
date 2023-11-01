<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <div class="scanQR">
                    <h1>Scan QR Code</h1>
            </div>

            <div class="QRCode">
                <a href="#">
                    <img src="<?php echo URLROOT ?>/images/QRCode.jpg" alt="">
                </a>
            </div>
        </div>

    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>