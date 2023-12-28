<?php require APPROOT.'/views/inc/header.php'; ?>

<div class="form-container" style="transform: translateY(100px);">
    <h1>Verify your email</h1>

    <?php if (!empty($data->err)) { ?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data->err ?></span>
        </div>
    <?php } ?>
    <form action="<?php echo URLROOT ?>/users/emailVerify" method="post">
        <!-- Email -->
        <p style="color: #8a8a8a; text-align: center">The verification code is sent to <b style="color: rgba(0,0,0,0.66)"><?php echo $data->email ?></b> please check.</p>
        <input type="text" name="email" id="email" required value="<?php echo $data->username ?>" hidden />

        <!-- Password -->
        <input type="text" name="otp" id="otp" required placeholder="OTP" style="text-align: center" />

        <br>

        <!-- Submit -->
        <input type="submit" value="Submit">
    </form>

    <div class="other-options" style="display: none;">
        <p>If you didn't get your OTP yet, <a href="<?php echo URLROOT ?>/users/resendOTP/<?php echo $data->username?>">Resend</a></p>
    </div>
</div>

<!--?xml version="1.0" standalone="no"?-->
<div class="svg">
    <img class="svg-1" src="<?php echo URLROOT ?>/images/svg-1.png" alt="">
    <img class="svg-2" src="<?php echo URLROOT ?>/images/svg-7.png" alt="">
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(function () {
            const otherOptionsDiv = document.querySelector('.other-options');
            otherOptionsDiv.style.display = 'block';

            const formContainer = document.querySelector('.form-container');
            formContainer.style.transform = 'translateY(60px)';
        }, 5000);
    });

    document.body.style.backgroundColor = 'white';
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
