<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'dashboard';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <div class="form-container">
                <h1 style="text-align: center;">Update Admin</h1>
                <?php if (!empty($data->err)){?>
                    <div class="error-msg">
                        <span class="form-invalid"><?php echo $data->err ?></span>
                    </div>
                <?php } ?>

                <form action="<?php echo URLROOT ?>/superAdmin/updateAdmin" method="post" enctype="multipart/form-data">
                    <!-- ID -->
                    <input type="text" name="id" id="id" required hidden value="<?php echo $data->id ?>" />

                    <!-- Username -->
                    <input type="text" name="username" id="username" required value="<?php echo $data->username ?>" placeholder="Username" />
                    <input type="text" name="old_username" id="old_username" required value="<?php echo $data->username ?>" hidden />

                    <!-- Name -->
                    <input type="text" name="name" id="name" required value="<?php echo $data->name ?>" placeholder="Name" />

                    <!-- Password -->
                    <input type="password" name="password" id="password" required placeholder="Password" />

                    <!-- Confirm Password -->
                    <input type="password" name="confirm_password" id="confirm_password" required placeholder="Confirm Password" />

                    <!-- User Type -->
                    <input type="text" name="user_type" id="user_type" value="parkingOwner" required hidden  />

                    <br><br>

                    <!-- Submit -->
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
