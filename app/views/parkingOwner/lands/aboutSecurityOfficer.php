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

    <form action="<?php echo URLROOT ?>/land/secAvailSet" method="post">
        <!-- Name -->
        <select name="secAvail">
            <option value="" hidden disabled selected>Security availability</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>

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
