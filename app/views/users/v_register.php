<?php require APPROOT.'/views/inc/header.php'; ?>
    <!--  TOP NAVIGATION  -->
    <?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

    <div class="form-container">
        <h1>Sign up</h1>
        <form action="" method="post">
            <!-- Name -->
            <div class="form-input-title">Name:</div>
            <input type="text" name="name" id="name" required>
            <span class="form-invalid"></span>

            <!-- Email -->
            <div class="form-input-title">Email:</div>
            <input type="email" name="email" id="email" required>
            <span class="form-invalid"></span>

            <!-- Password -->
            <div class="form-input-title">Password:</div>
            <input type="password" name="password" id="password" required>
            <span class="form-invalid"></span>

            <br><br>

            <!-- Submit -->
            <input type="submit" value="Submit">
        </form>
    </div>
<?php require APPROOT.'/views/inc/footer.php'; ?>
