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
            <div class="vehicle-type-selection">
                <form action="<?php echo URLROOT?>/driver/enterParking" method="post">
                    <input type="text" name="id" value="<?php echo $data['id'] ?>" hidden>
                    <input type="text" name="vehicle_type" value="car" hidden>
                    <input type="submit" value="Car">
                </form>

                <form action="<?php echo URLROOT?>/driver/enterParking" method="post">
                    <input type="text" name="id" value="<?php echo $data['id'] ?>" hidden>
                    <input type="text" name="vehicle_type" value="bike" hidden>
                    <input type="submit" value="Bike">
                </form>

                <form action="<?php echo URLROOT?>/driver/enterParking" method="post">
                    <input type="text" name="id" value="<?php echo $data['id'] ?>" hidden>
                    <input type="text" name="vehicle_type" value="threeWheel" hidden>
                    <input type="submit" value="threeWheel">
                </form>
            </div>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
