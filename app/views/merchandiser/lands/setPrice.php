<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'vehicles';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<div class="form-container">
    <h1>About Security Officer</h1>
    <?php if (!empty($data['err'])){?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
    <?php } ?>

    <form action="<?php echo URLROOT ?>/merchandiser/successPropertyRegister" method="post">
        <!-- Car -->
        <div class="form-input-title">Car:</div>
        <input type="text" name="name" id="name" required value="" />

        <br><br>

        <!-- Bike -->
        <div class="form-input-title">Bike:</div>
        <input type="text" name="city" id="city" required value="" />

        <br><br>

        <!-- Three Wheel -->
        <div class="form-input-title">Three Wheel:</div>
        <input type="text" name="street" id="street" required value="" />

        <br><br>
        <!-- Hidden Input for User Type -->
        <input type="hidden" name="name" id="vehicle_type" value="<?php echo $data['name'] ?>" />

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
