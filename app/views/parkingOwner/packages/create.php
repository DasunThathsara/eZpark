<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'packages';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<div class="form-container">
    <h1>Add Package</h1>
    <?php if (!empty($data['err'])){?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
    <?php } ?>

    <form action="<?php echo URLROOT ?>/package/packageRegister" method="post">

        <!-- package name -->
        <select name="name">
            <option value="" hidden disabled selected>Package Name</option>
            <option value="weekly">weekly</option>
            <option value="monthly">monthly</option>
        </select>

        <!-- Price -->
        <div class="form-input-title">Price:</div>
        <input type="text" name="price" id="price" required value="" />
        
        <br><br>
        <!-- package Type -->
        <select name="package_type">
            <option value="" hidden disabled selected>Package Type</option>
            <option value="car">Car</option>
            <option value="bike">Bike</option>
            <option value="3wheel">Three wheel</option>
        </select>

        <br><br>

        <!-- Submit -->
        <input type="submit" value="Add">
    </form>
</div>

<script>
    const userSelectionList = document.querySelector('.user-selection-list');

    userSelectionList.addEventListener('click', function(event) {
        if (event.target.tagName === 'LI') {
            // document.getElementById('name').value = event.target.getAttribute('data-user-type');
            document.getElementById('package_type').value = event.target.getAttribute('data-user-type');
        }
    });
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
