<?php require APPROOT.'/views/inc/header.php'; ?>
<div class="form-container">
    <h3 class="subheading">WELCOME TO</h3>  <!--newly added-->
    <h1 class="heading">eZpark</h1> <!--newly added-->
    <?php if (!empty($data['err'])) { ?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
    <?php } ?>
    <form action="<?php echo URLROOT ?>/users/login" method="post">
        <!-- Email -->
        <input type="text" name="email" id="email" required value="<?php echo $data['email'] ?>" placeholder="Email" />

        <!-- Password -->
        <input type="password" name="password" id="password" required placeholder="Password" />

        <br><br><br>
        <!-- Remember Me Checkbox -->
        <div class="form-check">
            <input type="checkbox" name="remember_me" id="remember_me">
            <label for="remember_me">Remember Me</label>
        </div>

        <br><br>

        <!-- Submit -->
        <input type="submit" value="Submit">
    </form>

    <div class="other-options">
        <p>If you don't have an account? <a href="<?php echo URLROOT ?>/users/register">Register</a></p>
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
