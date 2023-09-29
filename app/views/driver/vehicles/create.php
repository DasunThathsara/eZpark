<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'vehicles';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<div class="form-container">
    <h1>Add Vehicle</h1>
    <?php if (!empty($data['err'])){?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
    <?php } ?>

    <form action="<?php echo URLROOT ?>/users/register" method="post">
        <!-- Name -->
        <div class="form-input-title">Name:</div>
        <input type="text" name="Name" id="Name" required value="" />

        <br><br>
        <!-- Vehicle Type -->
        <div class="form-input-title">User Type:</div>
        <div class="user-selection-container">
            <ul class="user-selection-list">
                <li data-user-type="car">Car</li>
                <li data-user-type="bike">Bike</li>
                <li data-user-type="3wheel">3wheel</li>
            </ul>
        </div>

        <!-- Hidden Input for User Type -->
        <input type="hidden" name="vehicle_type" id="vehicle_type" value="" />

        <br><br>

        <!-- Submit -->
        <input type="submit" value="Add">
    </form>
</div>
<?php require APPROOT.'/views/inc/footer.php'; ?>
