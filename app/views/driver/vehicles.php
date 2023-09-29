<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'vehicles';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <h1>Vehicles</h1>

        <div class="options">
            <a href="<?php echo URLROOT ?>/driver/vehicleRegister">
                <div class="vehicles">
                    <h1>ADD</h1>
                </div>
            </a>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
