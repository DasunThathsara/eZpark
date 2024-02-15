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

                                </div>
                            </th>
                        </tr>

                        <?php foreach ($data['securityDetails'] as $security) {?>
                            <tr>
                                <td>
                                    <a class="tile" href="">
                                        <div class="content">
                                            <div class="left" style="width:50%;">
                                                <?php echo $security->security_name; ?>
                                            </div>
                                            <div class="left" style="width:50%;">
                                                <?php echo $security->sec_contact; ?>
                                            </div>
                                            <div class="right" style="width: calc(50% - 30px);">
                                                <form action="<?php echo URLROOT ?>/security/securityRemove/<?php echo $security->security_id; ?>" method="post">
                                                    <input type="text" name="sec_id" id="sec_id" hidden value="<?php echo $security->security_id; ?>" />
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

<?php require APPROOT.'/views/inc/footer.php'; ?>