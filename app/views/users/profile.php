<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'profile';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <div class="form-container">
                <h1>Profile</h1>
                <?php if (!empty($data['err'])){?>
                    <div class="error-msg">
                        <span class="form-invalid"><?php echo $data["err"] ?></span>
                    </div>
                <?php } ?>

                <form action="<?php echo URLROOT ?>/users/updateProfile" method="post">
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

                    <br><br>

                    <!-- Submit -->
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
