<?php require APPROOT.'/views/inc/header.php'; ?>
<div class="form-container" style="margin-top: 5vh"><!--change margin-top to 5vh-->
    <h1>User Type Selection</h1>    <!--newly added-->
    <?php if (!empty($data['err'])){?>
    <div class="error-msg">
        <span class="form-invalid"><?php echo $data["err"] ?></span>
    </div>
    <?php } ?>

    <div class="type-select">
        <a href="<?php echo URLROOT ?>/users/driverRegister">
            <div class="type-select-btn">
                Driver
            </div>
        </a>

        <a href="<?php echo URLROOT ?>/users/parkingOwnerRegister">
            <div class="type-select-btn">
                Parking Owner
            </div>
        </a>

        <a href="<?php echo URLROOT ?>/users/merchandiserRegister">
            <div class="type-select-btn">
                Merchandiser
            </div>
        </a>

        <a href="<?php echo URLROOT ?>/users/securityRegister">
            <div class="type-select-btn">
                Security
            </div>
        </a>
    </div>

    <div class="other-options">
        <p>If you already have an account? <a href="<?php echo URLROOT ?>/users/login">Login</a></p>
    </div>
</div>

<!--?xml version="1.0" standalone="no"?-->
<!--<div class="svg">
    <img class="svg-1" src="<?php echo URLROOT ?>/images/svg-1.png" alt="">
    <img class="svg-2" src="<?php echo URLROOT ?>/images/svg-7.png" alt="">
</div>-->

<script>
    document.body.style.backgroundColor = 'white';
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
