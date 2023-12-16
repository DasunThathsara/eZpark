<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'dashboard';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1>Security Dashboard</h1>
            <div class="emptyVehicle">Currently you have no any parking</div>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
