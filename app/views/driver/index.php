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
            <div class="search">
                <input type="text" placeholder="Search Parking" style="border: 1px solid #ccc">
            </div>
            <div class="map">
                <img src="<?php echo URLROOT ?>/images/location.png" alt="">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4231.666368350934!2d79.86014226253688!3d6.902790088271364!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae259100761b8f3%3A0x78f0a33054ea929b!2sIndependence%20Square%20Parking%20Lot!5e0!3m2!1sen!2slk!4v1697709991816!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
