<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'lands';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<div class="form-container">
    <h1>Add Parking</h1>
    <?php if (!empty($data['err'])){?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
    <?php } ?>

    <form action="<?php echo URLROOT ?>/merchandiser/landRegister" method="post">
        <!-- Name -->
        <div class="form-input-title">Name:</div>
        <input type="text" name="name" id="name" required value="" />

        <br><br>

        <!-- City -->
        <div class="form-input-title">City:</div>
        <input type="text" name="city" id="city" required value="" />

        <br><br>

        <!-- Street -->
        <div class="form-input-title">Street:</div>
        <input type="text" name="street" id="street" required value="" />

        <br><br>

        <!-- Deed -->
        <div class="form-input-title">Deed:</div>
        <input type="text" name="deed" id="deed" required value="" />

        <br><br>

        <!-- Car -->
        <div class="form-input-title">How much the Car parking slots:</div>
        <input type="text" name="car" id="car" required value="" />

        <br><br>

        <!-- Bike -->
        <div class="form-input-title">How much the Bike parking slots:</div>
        <input type="text" name="bike" id="bike" required value="" />

        <br><br>

        <!-- Three Wheel -->
        <div class="form-input-title">How much the Three Wheel parking slots:</div>
        <input type="text" name="threeWheel" id="threeWheel" required value="" />

        <br><br>

        <!-- contactNo -->
        <div class="form-input-title">Contact Number:</div>
        <input type="text" name="contactNo" id="contactNo" required value="" />

        <br><br>

        <!-- Submit -->
        <input type="submit" value="Add">
    </form>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
