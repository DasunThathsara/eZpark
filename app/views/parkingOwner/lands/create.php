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

    <form action="<?php echo URLROOT ?>/land/landRegister" method="post" enctype="multipart/form-data">
        <!-- Name -->
        <div class="form-input-title">Name:</div>
        <input type="text" name="name" id="name" required value="<?php echo $data['name'] ?>" />

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
        <div class="file-upload-container">
            <label class="file-upload" for="deed">Upload File</label>
            <input type="file" name="deed" id="deed" hidden />
            <div class="description">*Upload deed in PDF format</div>
        </div>

        <br><br>

        <!-- Car -->
        <div class="form-input-title">Number of available car parking slots:</div>
        <input type="text" name="car" id="car" required value="<?php echo $data['car'] ?>" />

        <br><br>

        <!-- Bike -->
        <div class="form-input-title">Number of available bike parking slots:</div>
        <input type="text" name="bike" id="bike" required value="<?php echo $data['bike'] ?>" />

        <br><br>

        <!-- Three Wheel -->
        <div class="form-input-title">Number of available threewheel parking slots:</div>
        <input type="text" name="threeWheel" id="threeWheel" required value="<?php echo $data['threeWheel'] ?>" />

        <br><br>

        <!-- contactNo -->
        <div class="form-input-title">Contact Number:</div>
        <input type="text" name="contactNo" id="contactNo" required value="<?php echo $data['contactNo'] ?>" />

        <br><br>

        <!-- Submit -->
        <input type="submit" value="Next">
    </form>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
