<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'lands';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<div class="form-container">
    <h1>Update Parking</h1>
    <?php if (!empty($data['err'])){?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
    <?php } ?>

    <form action="<?php echo URLROOT ?>/parkingOwner/landUpdate" method="post">
        <!-- Name -->
        <div class="form-input-title">Name:</div>
        <input type="text" name="name" id="name" required value="<?php echo $data['name'] ?>" />
        <input type="text" name="old_name" id="old_name" required value="<?php echo $data['name'] ?>"  disable hidden />

        <br><br>
        <!-- City -->
        <div class="form-input-title">City:</div>
        <input type="text" name="city" id="city" required value="<?php echo $data['city'] ?>" />

        <br><br>

        <!-- Street -->
        <div class="form-input-title">Street:</div>
        <input type="text" name="street" id="street" required value="<?php echo $data['street'] ?>" />

        <br><br>

        <!-- Deed -->
        <div class="form-input-title">Deed:</div>
        <input type="text" name="deed" id="deed" required value="<?php echo $data['deed'] ?>" />

        <br><br>

        <!-- car -->
        <div class="form-input-title">How much the Car parking slots:</div>
        <input type="number" name="car" id="car" required value="<?php echo $data['car'] ?>" />

        <br><br>

        <!-- Bike -->
        <div class="form-input-title">How much the Bike parking slots:</div>
        <input type="number" name="bike" id="bike" required value="<?php echo $data['bike'] ?>" />

        <br><br>

        <!-- Three Wheel -->
        <div class="form-input-title">How much the Three Wheel parking slots:</div>
        <input type="number" name="threeWheel" id="threeWheel" required value="<?php echo $data['threeWheel'] ?>" />

        <br><br>

        <br><br>
        <!-- contactNo -->
        <div class="form-input-title">Contact Number:</div>
        <input type="tex" name="contactNo" id="contactNo" required value="<?php echo $data['contactNo'] ?>" />

        <br><br>

        <!-- Submit -->
        <input type="submit" value="Update">
    </form>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
