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

                <form action="<?php echo URLROOT ?>/users/updateProfile" method="post" enctype="multipart/form-data">
                    <div class="profile-container">
                        <?php if($_SESSION['profile_photo']){ ?>
                            <img class="profile-pic" src="<?php echo URLROOT ?>/profile_pics/<?php echo $data['profile_photo']?>" alt="<?php echo $_SESSION['user_name'] ?>">
                        <?php }
                        else{ ?>
                            <img class="profile-pic" src="<?php echo URLROOT ?>/images/user.png" alt="<?php echo $_SESSION['user_name'] ?>">
                        <?php } ?>

                        <div class="profile-dropdown-container">
                            <img class="profile-pic-edit" src="<?php echo URLROOT ?>/images/edit-solid.svg" alt="">
                            <div class="profile-dropdown-content">
                                <input class="dropdown-item" type="file" id="profile_photo" name="profile_photo"/>
                                <a class="dropdown-item" href="<?php echo URLROOT ?>/users/profilePhotoRemove" onclick="return confirmSubmit();">Remove photo</a>
                            </div>
                        </div>
                    </div>
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

<script>
    function confirmSubmit() {
        return confirm("Are you sure you want to remove your profile photo?");
    }

    function dropdownBtn() {
        var element1, element2;
        element1 = document.querySelector('.chat-box');
        element1.classList.toggle("chat-box-active");

        element2 = document.querySelector('.chatbtn');
        element2.classList.toggle("chatbtn-active");
    }
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
