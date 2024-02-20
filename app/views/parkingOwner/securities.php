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

                        <?php foreach ($data['securityDetails'] as $security) {?>
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

                                            <div>
                                                <!-- Toggle Button -->
                                               
                                                <label class="switch">
                                                    <input type="checkbox" class="toggleButton" data-security-id="<?php echo $security->security_id;?>" <?php echo $security->landAccess == 1 ? 'checked' : ''; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>    
                                            <div class="right" style="width: calc(50% - 30px);">
                                                <form action="<?php echo URLROOT ?>/parkingOwner/securityRemove" method="post">
                                                    <input type="text" name="sec_id" id="sec_id" value="<?php echo $security->security_id; ?>" hidden />
                                                    <input type="text" name="land_id" id="land_id" value="<?php echo $data['id']; ?>" hidden />
                                                    <button type="submit" class="delete" onclick="return confirmSubmit();">
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

<script>
    function confirmSubmit() {
        return confirm("Are you sure you want to delete this security?");
    }
</script>

<!-- <script>
        $(document).ready(function () {
            $('#toggleButton').change(function () {
                var isChecked = $(this).prop('checked');
                console.log("Checkbox is checked: " + isChecked);

                $.ajax({
                    url: '<?php echo URLROOT?>/parkingOwner/landAccessControl/<?php echo $security->security_id?>',
                    method: 'GET',
                    data: { isChecked: isChecked },
                    success: function (response) {
                        console.log("AJAX success:", response);
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX error:", xhr.responseText);
                    }
                });
            });
        });
    </script> -->

    <script>
    $(document).ready(function () {
        $('.toggleButton').change(function () {
            var isChecked = $(this).prop('checked');
            var securityId = $(this).data('security-id');

            $.ajax({
                url: '<?php echo URLROOT?>/parkingOwner/landAccessControl/' + securityId,
                method: 'GET',
                data: { isChecked: isChecked },
                success: function (response) {
                    console.log("AJAX success:", response);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", xhr.responseText);
                }
            });
        });
    });
</script>


<?php require APPROOT.'/views/inc/footer.php'; ?>