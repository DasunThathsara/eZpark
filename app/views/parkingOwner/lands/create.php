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

        <!-- Submit -->
        <input type="submit" value="Add">
    </form>
</div>
<!--

<?php require APPROOT.'/views/inc/footer.php'; ?>
