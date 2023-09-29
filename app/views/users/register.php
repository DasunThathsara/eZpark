<?php require APPROOT.'/views/inc/header.php'; ?>
    <!--  TOP NAVIGATION  -->
    <?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

    <div class="form-container">
        <h1>Sign up</h1>
        <?php if (!empty($data['err'])){?>
        <div class="error-msg">
            <span class="form-invalid"><?php echo $data["err"] ?></span>
        </div>
        <?php } ?>

        <form action="<?php echo URLROOT ?>/users/register" method="post">
            <!-- Username -->
            <div class="form-input-title">Username:</div>
            <input type="text" name="username" id="username" required value="<?php echo $data['username'] ?>" />

            <!-- Name -->
            <div class="form-input-title">Name:</div>
            <input type="text" name="name" id="name" required value="<?php echo $data['name'] ?>" />

            <!-- Email -->
            <div class="form-input-title">Email:</div>
            <input type="email" name="email" id="email" required value="<?php echo $data['email'] ?>" />

            <!-- Contact number -->
            <div class="form-input-title">Contact number:</div>
            <input type="text" name="contact_no" id="contact_no" required value="<?php echo $data['contact_no'] ?>" />

            <!-- Password -->
            <div class="form-input-title">Password:</div>
            <input type="password" name="password" id="password" required />

            <!-- Password Strength Indicator -->
            <div class="strength-text" id="strength-text"></div>


            <!-- Confirm Password -->
            <div class="form-input-title">Confirm Password:</div>
            <input type="password" name="confirm_password" id="confirm_password" required />

            <br><br>
            <!-- User Type -->
            <div class="form-input-title">User Type:</div>
            <div class="user-selection-container">
                <ul class="user-selection-list">
                    <li data-user-type="driver">Driver</li>
                    <li data-user-type="parkingOwner">Owner</li>
                    <li data-user-type="security">Security</li>
                    <li data-user-type="merchandiser">Merchandiser</li>
                </ul>
            </div>

            <!-- Hidden Input for User Type -->
            <input type="hidden" name="user_type" id="user_type" value="" />

            <div id="driverFields" class="additional-fields" style="display: none;">
                <input type="text" value="Driver">
            </div>

            <div id="parkingOwnerFields" class="additional-fields" style="display: none;">
                <input type="text" value="Parking Owner">
            </div>

            <div id="securityFields" class="additional-fields" style="display: none;">
                <input type="text" value="Security">
            </div>

            <div id="merchandiserFields" class="additional-fields" style="display: none;">
                <input type="text" value="Merchandiser">
            </div>



            <br><br>

            <!-- Submit -->
            <input type="submit" value="Submit">
        </form>
    </div>
<?php require APPROOT.'/views/inc/footer.php'; ?>
