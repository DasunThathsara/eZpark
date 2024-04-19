<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'packages';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1>Securities</h1>

            <br><br>
            <a class="add-btn" href="<?php echo URLROOT ?>/land/securitySearch/<?php echo $data['id'] ?>" style="font-weight: 1000; font-size: 20px">+</a>

            <?php if (sizeof($data['securityDetails']) == 0) {?>
                <div class="emptyVehicle">You have no any securities</div>
            <?php }
            else {?>
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th width="60px">
                                <div class="content" style="display:flex;">
                                    <div class="left" style="width:31%">
                                        Name
                                    </div>

                                    <div class="left" style="width:31%">
                                        Contact Number
                                    </div>

                                    <div class="left" style="width:31%">
                                        Access For Security
                                    </div>
                                </div>
                            </th>
                        </tr>

   

                        <?php foreach ($data['securityDetails'] as $security) {?>    <!--change $data['securityDetails'] to $other_data-->
                            <tr>
                                <td>
                                    <a class="tile" href="<?php echo URLROOT?>/land/viewSecurity/<?php echo $security->security_id?>">
                                        <div class="content">
                                            <div class="left" style="width:50%;">
                                                <?php echo $security->security_name; ?>
                                            </div>
                                            <div class="left" style="width:50%;">
                                                <?php echo $security->sec_contact; ?>
                                            </div>

                                            <div class="toggle">
                                                <!-- Toggle Button -->
                                                <label class="switchAccess" id="switch">
                                                    <input type="checkbox" hidden class="toggleButton" data-security-id="<?php echo $security->security_id;?>" <?php echo $security->landAccess == 1 ? 'checked' : ''; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>    
                                            <div class="right" style="width: calc(50% - 30px);">
                                                <form action="<?php echo URLROOT ?>/merchandiser/securityRemove" method="post" class="delete-form" id="delete-form">
                                                    <input type="text" name="sec_id" id="sec_id" value="<?php echo $security->security_id; ?>" hidden />
                                                    <input type="text" name="land_id" id="land_id" value="<?php echo $data['id']; ?>" hidden />
                                                    <button type="submit" class="delete" onclick="confirmSubmit();">
                                                        <img src="<?php echo URLROOT ?>/images/trash-solid.svg" alt="">
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteForms = document.querySelectorAll(".delete-form");

        deleteForms.forEach(function (deleteform) {
            const submitButton = deleteform.querySelector("button[type='submit']");

            if (submitButton) {
                submitButton.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent the form from submitting

                    // Use SweetAlert for confirmation
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete this security.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteform.submit();
                        }
                    });
                });
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleButtons = document.querySelectorAll(".toggleButton");

        toggleButtons.forEach(function (toggleButton) {
            toggleButton.addEventListener("change", function () {
                const isChecked = this.checked;
                const securityId = this.getAttribute("data-security-id");

                // Use SweetAlert for confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to change security access.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform the AJAX request to update security access
                        $.ajax({
                            url: '<?php echo URLROOT?>/merchandiser/landAccessControl/' + securityId,
                            method: 'GET',
                            data: { isChecked: isChecked },
                            success: function (response) {
                                console.log("AJAX success:", response);
                            },
                            error: function (xhr, status, error) {
                                console.error("AJAX error:", xhr.responseText);
                            }
                        });
                    } else {
                        // Revert the checkbox state if the user cancels
                        toggleButton.checked = !isChecked;
                    }
                });
            });
        });
    });
    
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
