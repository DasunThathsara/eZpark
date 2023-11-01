<?php require APPROOT.'/views/inc/header.php'; ?>
<div class="form-container" style="margin-top: 10vh;">
    <h1>Sign up</h1>
    <?php if (!empty($data['err'])){?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
    <?php } ?>

    <form action="<?php echo URLROOT ?>/users/parkingOwnerRegister" method="post">
        <!-- Username -->
        <input type="text" name="username" id="username" required value="<?php echo $data['username'] ?>" placeholder="Username" />

        <!-- Name -->
        <input type="text" name="name" id="name" required value="<?php echo $data['name'] ?>" placeholder="Name" />

        <!-- Email -->
        <input type="email" name="email" id="email" required value="<?php echo $data['email'] ?>" placeholder="Email" />

        <!-- Contact number -->
        <input type="text" name="contact_no" id="contact_no" required value="<?php echo $data['contact_no'] ?>" placeholder="Contact number" />

        <!-- Password -->
        <input type="password" name="password" id="password" required placeholder="Password" />

        <!-- Password Strength Indicator -->
        <div class="strength-text" id="strength-text"></div>

        <!-- Confirm Password -->
        <input type="password" name="confirm_password" id="confirm_password" required placeholder="Confirm Password" />

        <!-- User Type -->
        <input type="text" name="user_type" id="user_type" required hidden value="parkingOwner" />

        <br><br>

        <!-- Submit -->
        <input type="submit" value="Submit">
    </form>

    <div class="other-options">
        <p>If you already have an account? <a href="<?php echo URLROOT ?>/users/login">Login</a></p>
    </div>
</div>

<!--?xml version="1.0" standalone="no"?-->
<div class="svg">
    <img class="svg-1" src="<?php echo URLROOT ?>/images/svg-1.png" alt="">
    <img class="svg-2" src="<?php echo URLROOT ?>/images/svg-7.png" alt="">
</div>
<?php require APPROOT.'/views/inc/footer.php'; ?>
