<?php require APPROOT.'/views/inc/header.php'; ?>


<div class="login-form-container">  <!--changed the class name-->
<h3>welcome to</h3> 
    <h1>eZpark</h1> 
    <?php if (!empty($data['err'])) { ?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
    <?php } ?>
    <form action="<?php echo URLROOT ?>/users/login" method="post">
        <!-- Email -->
        <input class="login-form-input" type="text" name="email" id="email" required value="<?php echo $data['email'] ?>" placeholder="Email" />

        <!-- Password -->
        <input class="login-form-input" type="password" name="password" id="password" required placeholder="Password" />    <!--added the classes-->

        <br><br><br>
        <!-- Remember Me Checkbox -->
        <div class="login-form-check">
            <input type="checkbox" name="remember_me" id="remember_me">
            <label for="remember_me">Remember Me</label>
        </div>

        <br><br>

        <!-- Submit -->
        <div class="login-submit-button">
            <input type="submit" value="Login"> 
        </div>
    </form>

    <div class="login-other-options">
        <p>If you don't have an account? <a href="<?php echo URLROOT ?>/users/register">Register</a></p>
    </div>
</div>
    

<!--?xml version="1.0" standalone="no"?-->
<!--<div class="svg">
    <img class="svg-1" src="<?php echo URLROOT ?>/images/svg-1.png" alt="">
    <img class="svg-2" src="<?php echo URLROOT ?>/images/svg-7.png" alt="">
</div>-->

<script>
    document.body.style.backgroundColor = '#E29C00';
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
