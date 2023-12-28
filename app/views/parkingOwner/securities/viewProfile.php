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
                <h1 style="text-align: center;">Security profile</h1>
                <?php if (!empty($data['err'])){?>
                    <div class="error-msg">
                        <span class="form-invalid"><?php echo $data["err"] ?></span>
                    </div>
                <?php } ?>

                <form action="" method="post"  id="request-form">
                    <input type="text" name="landID" id="landID" hidden value="<?php echo $data['lid']?>" />
                    <input type="text" name="securityID" id="securityID" hidden value="<?php echo $data['id']?>" />

                    <div class="profile-container">
                        <?php if($other_data[0]->profilePhoto){ ?>
                            <img class="profile-pic" id="preview" src="<?php echo URLROOT ?>/profile_pics/<?php echo $other_data[0]->profilePhoto ?>" alt="<?php echo $_SESSION['user_name'] ?>">
                        <?php }
                        else{ ?>
                            <img class="profile-pic" id="preview" src="<?php echo URLROOT ?>/images/user.png" alt="<?php echo $_SESSION['user_name'] ?>">
                        <?php } ?>
                    </div>

                    <!-- Username -->
                    <div class="form-input-title">Name:</div>
                    <p><?php echo $other_data[0]->name ?></p>

                    <!-- Email -->
                    <div class="form-input-title">Email:</div>
                    <p><?php echo $other_data[0]->email ?></p>

                    <!-- Contact number -->
                    <div class="form-input-title">Contact number:</div>
                    <p><?php echo $other_data[0]->contactNo ?></p>

                    <!-- NIC -->
                    <div class="form-input-title">NIC:</div>
                    <p><?php echo $other_data[0]->NIC ?></p>

                    <!-- Address -->
                    <div class="form-input-title">Address:</div>
                    <p><?php echo $other_data[0]->address ?></p>

                    <!-- District -->
                    <div class="form-input-title">District:</div>
                    <p><?php echo $other_data[0]->preferredDistrictToWork ?></p>

                    <!-- Province -->
                    <div class="form-input-title">Province:</div>
                    <p><?php echo $other_data[0]->preferredProvinceToWork ?></p>

                    <!-- Experience -->
                    <div class="form-input-title">Experience:</div>
                    <?php if ($other_data[0]->experience) {?>
                        <p><?php echo $other_data[0]->experience ?></p>
                    <?php } else{ ?>
                        <p>No experience</p>
                    <?php } ?>

                    <br><br>

                    <!-- Submit -->
                    <input type="submit" value="" id="submit-btn">
                </form>
            </div>
        </div>
    </section>
</main>

<script>
    const pendingSecurityData = <?php echo json_encode($other_data['pending_securities']); ?>;
    const requestForm = document.getElementById('request-form'); // Remove the dot before 'request-form'
    const submitButton = document.getElementById('submit-btn'); // Remove the dot before 'submit-btn'

    if (pendingSecurityData.includes(<?php print_r($data['id']); ?>)) { // Wrap $data['lid'] in quotes
        requestForm.setAttribute("action", '<?php echo URLROOT ?>/land/cancelRequest');
        submitButton.setAttribute("value", "Cancel request");
    } else {
        requestForm.setAttribute("action", '<?php echo URLROOT ?>/land/sendRequest');
        submitButton.setAttribute("value", "Send request");
    }

</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
