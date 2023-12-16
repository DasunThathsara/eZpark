<?php require APPROOT.'/views/inc/header.php'; ?>
<div class="form-container" style="margin-top: 10vh;">
    <h1>Sign up</h1>
    <?php if (!empty($data['err'])){?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
    <?php } ?>

    <form action="<?php echo URLROOT ?>/users/securityRegister" method="post">
        <!-- Username -->
        <input type="text" name="username" id="username" required value="<?php echo $data['username'] ?>" placeholder="Username" />

        <!-- Name -->
        <input type="text" name="name" id="name" required value="<?php echo $data['name'] ?>" placeholder="Name" />

        <!-- Email -->
        <input type="email" name="email" id="email" required value="<?php echo $data['email'] ?>" placeholder="Email" />

        <!-- Contact number -->
        <input type="text" name="contact_no" id="contact_no" required value="<?php echo $data['contact_no'] ?>" placeholder="Contact number" />

        <!-- Address -->
        <input type="text" name="address" id="address" required value="<?php echo $data['address'] ?>" placeholder="Address" />

        <!-- City -->
        <select name="city" id="city" required>
            <option value="" disabled selected>Select City</option>
            <option value="Ampara" <?php if ($data['city'] == 'Ampara') echo 'selected' ?>>Ampara</option>
            <option value="Anuradhapura" <?php if ($data['city'] == 'Anuradhapura') echo 'selected' ?>>Anuradhapura</option>
            <option value="Badulla" <?php if ($data['city'] == 'Badulla') echo 'selected' ?>>Badulla</option>
            <option value="Batticaloa" <?php if ($data['city'] == 'Batticaloa') echo 'selected' ?>>Batticaloa</option>
            <option value="Colombo" <?php if ($data['city'] == 'Colombo') echo 'selected' ?>>Colombo</option>
            <option value="Galle" <?php if ($data['city'] == 'Galle') echo 'selected' ?>>Galle</option>
            <option value="Gampaha" <?php if ($data['city'] == 'Gampaha') echo 'selected' ?>>Gampaha</option>
            <option value="Hambantota" <?php if ($data['city'] == 'Hambantota') echo 'selected' ?>>Hambantota</option>
            <option value="Jaffna" <?php if ($data['city'] == 'Jaffna') echo 'selected' ?>>Jaffna</option>
            <option value="Kandy" <?php if ($data['city'] == 'Kandy') echo 'selected' ?>>Kandy</option>
            <option value="Kegalle" <?php if ($data['city'] == 'Kegalle') echo 'selected' ?>>Kegalle</option>
            <option value="Kilinochchi" <?php if ($data['city'] == 'Kilinochchi') echo 'selected' ?>>Kilinochchi</option>
            <option value="Kurunegala" <?php if ($data['city'] == 'Kurunegala') echo 'selected' ?>>Kurunegala</option>
            <option value="Mannar" <?php if ($data['city'] == 'Mannar') echo 'selected' ?>>Mannar</option>
            <option value="Matara" <?php if ($data['city'] == 'Matara') echo 'selected' ?>>Matara</option>
            <option value="Matale" <?php if ($data['city'] == 'Matale') echo 'selected' ?>>Matale</option>
            <option value="Monaragala" <?php if ($data['city'] == 'Monaragala') echo 'selected' ?>>Monaragala</option>
            <option value="Mullaitivu" <?php if ($data['city'] == 'Mullaitivu') echo 'selected' ?>>Mullaitivu</option>
            <option value="Nuwara Eliya" <?php if ($data['city'] == 'Nuwara Eliya') echo 'selected' ?>>Nuwara Eliya</option>
            <option value="Polonnaruwa" <?php if ($data['city'] == 'Polonnaruwa') echo 'selected' ?>>Polonnaruwa</option>
            <option value="Puttalam" <?php if ($data['city'] == 'Puttalam') echo 'selected' ?>>Puttalam</option>
            <option value="Ratnapura" <?php if ($data['city'] == 'Ratnapura') echo 'selected' ?>>Ratnapura</option>
            <option value="Trincomalee" <?php if ($data['city'] == 'Trincomalee') echo 'selected' ?>>Trincomalee</option>
            <option value="Vavuniya" <?php if ($data['city'] == 'Vavuniya') echo 'selected' ?>>Vavuniya</option>
        </select>


        <!-- Password -->
        <input type="password" name="password" id="password" required placeholder="Password" />

        <!-- Password Strength Indicator -->
        <div class="strength-text" id="strength-text"></div>

        <!-- Confirm Password -->
        <input type="password" name="confirm_password" id="confirm_password" required placeholder="Confirm Password" />

        <!-- NIC -->
        <input type="text" name="NIC" id="NIC" required value="<?php echo $data['NIC'] ?>" placeholder="NIC" />

        <!-- text area for Experience -->
        <textarea name="experience" id="experience" placeholder="Experience..."><?php echo $data['experience'] ?></textarea>

        <!-- User Type -->
        <input type="text" name="user_type" id="user_type" required hidden value="security" />


        <br><br>

        <!-- Submit -->
        <input type="submit" value="Submit">
    </form>

    <div class="other-options">
        <p>If you already have an account? <a href="<?php echo URLROOT ?>/users/login">Login</a></p>
    </div>
</div>

<!--?xml version="1.0" standalone="no"?-->
<img class="svg-1" src="<?php echo URLROOT ?>/images/svg-1.png" alt="">
<img class="svg-2" src="<?php echo URLROOT ?>/images/svg-7.png" alt="">

<script>
    document.body.style.backgroundColor = 'white';
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
