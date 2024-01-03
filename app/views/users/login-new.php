



<div class="form-container">
    <h3 class="login-subheading">welcome to</h3> 
    <h1 class="login-heading">eZpark</h1> 
    <?php if (!empty($data['err'])) { ?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
    <?php } ?>
    <form action="<?php echo URLROOT ?>/users/login" method="post">
        <!-- Email -->
        <input class="login-email" type="text" name="email" id="email" required value="<?php echo $data['email'] ?>" placeholder="Email" />

        <!-- Password -->
        <input class="login-password" type="password" name="password" id="password" required placeholder="Password" />

        <br><br><br>
        <!-- Remember Me Checkbox -->
        <div class="login-form-check">
            <input type="checkbox" name="remember_me" id="remember_me">
            <label for="remember_me">Remember Me</label>
        </div>

        <br><br>

        <!-- Submit -->
        <input class="login-submit-button" type="submit" value="Submit"> 
    </form>

    <div class="login-other-options">
        <p>If you don't have an account? <a href="<?php echo URLROOT ?>/users/register">Register</a></p>
    </div>
</div>

