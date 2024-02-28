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

    <form action="<?php echo URLROOT ?>/vehicle/vehicleRegister" method="post">
        <!-- Name -->
        <div class="form-input-title">Name:</div>
        <input type="text" name="name" id="name" required value="" />

        <!-- Number -->
        <div class="form-input-title">Vehicle Number:</div>
        <input type="text" name="vehicle_number" id="vehicle_number" required value="" />

        <br><br>
        <!-- Vehicle Type -->
        <div class="form-input-title">User Type:</div>
        <div class="user-selection-container">
            <ul class="user-selection-list">
                <li data-user-type="car">Car</li>
                <li data-user-type="bike">Bike</li>
                <li data-user-type="threeWheel">3wheel</li>
            </ul>
        </div>

        <!-- Hidden Input for User Type -->
        <input type="hidden" name="vehicle_type" id="vehicle_type" value="" />

        <br><br>

        <!-- Submit -->
        <input type="submit" value="Add">
    </form>
</div>

<script>
    const userSelectionList = document.querySelector('.user-selection-list');

    userSelectionList.addEventListener('click', function(event) {
        if (event.target.tagName === 'LI') {
            document.getElementById('vehicle_type').value = event.target.getAttribute('data-user-type');
        }
    });
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
