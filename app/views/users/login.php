<?php require APPROOT.'/views/inc/header.php'; ?>
    <!--  TOP NAVIGATION  -->
    <?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

    <div class="form-container">
        <h1>Login</h1>
        <?php if (!empty($data['err'])) { ?>
            <div class="error-msg">
                <span class="form-invalid"><?php echo $data["err"] ?></span>
            </div>
        <?php } ?>
        <form action="<?php echo URLROOT ?>/users/login" method="post">
            <!-- Email -->
            <div class="form-input-title">Email:</div>
            <input type="email" name="email" id="email" required value="<?php echo $data['email'] ?>" />

            <!-- Password -->
            <div class="form-input-title">Password:</div>
            <input type="password" name="password" id="password" required>

            <!-- Remember Me Checkbox -->
            <div class="form-check">
                <input type="checkbox" name="remember_me" id="remember_me">
                <label for="remember_me">Remember Me</label>
            </div>

            <br><br>

            <!-- Submit -->
            <input type="submit" value="Submit">
        </form>
    </div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
