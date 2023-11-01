<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'lands';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<div class="form-container">
    <h1>Add Land</h1>
    <?php if (!empty($data['err'])){?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
    <?php } ?>

    <form action="<?php echo URLROOT ?>/parkingOwner/landRegister" method="post">
        <!-- Name -->
        <div class="form-input-title">Name:</div>
        <input type="text" name="name" id="name" required value="" />

        <!-- City -->
        <div class="form-input-title">City:</div>
        <input type="text" name="city" id="city" required value="" />

        <br><br>

        <!--Street-->
        <div class="form-input-title">Street:</div>
        <input type="text" name="street" id="street" required value="" />

        <br><br>

        <!--Deed-->
        <div class="form-input-title">Deed:</div>
        <input type="text" name="deed" id="deed" required value="" />

        <br><br>

         <!-- Car -->
         <div class="form-input-title">Price per hour for a Car:</div>
        <input type="text" name="car" id="car" required value="" />

        <br><br>

        <!-- Bike -->
        <div class="form-input-title">Price per hour for a Bike:</div>
        <input type="text" name="bike" id="bike" required value="" />

        <br><br>

        <!-- Three Wheel -->
        <div class="form-input-title">Price per hour for a Three-wheeler:</div>
        <input type="text" name="threeWheel" id="threeWheel" required value="" />

        <br><br>

        <!-- ContactNo -->
        <div class="form-input-title">Contact No:</div>
        <input type="text" name="contactNo" id="contactNo" required value="" />

        <!-- Submit -->
        <input type="submit" value="Add">
    </form>
</div>
<!--

<?php require APPROOT.'/views/inc/footer.php'; ?>
