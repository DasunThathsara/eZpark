<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'vehicles';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<div class="form-container">
    <h1>Update Package</h1>
    <?php if (!empty($data['err'])){?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
    <?php } ?>

    <form action="<?php echo URLROOT ?>/Package/packageUpdate" method="post">
        <input type="text" name="id" id="id" required hidden value="<?php echo $data['id'] ?>" />
        <input type="text" name="old_vehicle_type" id="old_vehicle_type" required hidden value="<?php echo $data['vehicle_type'] ?>" />
        <input type="text" name="old_package_type" id="old_package_type" required hidden value="<?php echo $data['package_type'] ?>" />

        <!-- package name -->
        <select name="package_type">
            <?php if($data['package_type'] == 'weekly') {?>
                <option value="weekly" selected>weekly</option>
                <option value="monthly">monthly</option>
            <?php }
            else if($data['package_type'] == 'monthly') {?>
                <option value="weekly">weekly</option>
                <option value="monthly" selected>monthly</option>
            <?php }
            else{?>
                <option value="" hidden disabled selected>Package Type</option>
                <option value="weekly">weekly</option>
                <option value="monthly">monthly</option>
            <?php }?>
        </select>

        <!-- Price -->
        <div class="form-input-title">Price:</div>
        <input type="text" name="package_price" id="package_price" required value="<?php echo $data['package_price'] ?>" />
        
        <br><br>
        <!-- package Type -->
        <select name="vehicle_type">
            <?php if($data['vehicle_type'] == 'car') {?>
                <option value="car" selected>Car</option>
                <option value="bike">Bike</option>
                <option value="3wheel">Three wheel</option>
            <?php }
            else if($data['vehicle_type'] == 'bike') {?>
                <option value="car">Car</option>
                <option value="bike" selected>Bike</option>
                <option value="3wheel">Three wheel</option>
            <?php }
            else if($data['vehicle_type'] == '3wheel') {?>
                <option value="car">Car</option>
                <option value="bike">Bike</option>
                <option value="3wheel" selected>Three wheel</option>
            <?php }
            else{?>
                <option value="" hidden disabled selected>Vehicle Type</option>
                <option value="car">Car</option>
                <option value="bike">Bike</option>
                <option value="3wheel">Three wheel</option>
            <?php }?>
        </select>

        <br><br>

        <!-- Submit -->
        <input type="submit" value="Update">
    </form>
</div>

<script>
    const userSelectionList = document.querySelector('.user-selection-list');

    userSelectionList.addEventListener('click', function(event) {
        if (event.target.tagName === 'LI') {
            document.getElementById('name').value = event.target.getAttribute('data-user-type');
            document.getElementById('vehicle_type').value = event.target.getAttribute('data-user-type');
        }
    });
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
