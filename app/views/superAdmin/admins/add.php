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
                <h1 style="text-align: center;">Create Admin</h1>
                <?php if (!empty($data['err'])){?>
                    <div class="error-msg">
                        <span class="form-invalid"><?php echo $data["err"] ?></span>
                    </div>
                <?php } ?>

                <form action="<?php echo URLROOT ?>/users/adminRegister" method="post" enctype="multipart/form-data">
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
                    <input type="text" name="user_type" id="user_type" value="parkingOwner" required hidden  />

                    <br><br>

                    <!-- Submit -->
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </section>
</main>

<script>
    const actualBtn = document.getElementById('profile_photo');

    actualBtn.addEventListener('change', function(){
        fileChosen.textContent = this.files[0].name;
        previewImage(this);
    });

    function previewImage(input) {
        const preview = document.getElementById('preview');
        const file = input.files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "<?php echo URLROOT ?>/images/user.png";
        }
    }

    function confirmSubmit() {
        return confirm("Are you sure you want to remove your profile photo?");
    }

    function dropdownBtn() {
        var element1, element2;
        element1 = document.querySelector('.profile-dropdown-content');
        element1.classList.toggle("profile-dropdown-content-active");

        element2 = document.querySelector('.profile-pic-edit');
        element2.classList.toggle("profile-pic-edit-active");
    }
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
