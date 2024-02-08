<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'lands';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1>Registration Requests</h1>

            <br><br>
            <?php if (sizeof($data) == 1) {?>
                <div class="emptyVehicle">You have no any registered vehicles</div>
            <?php }
            else {?>
                <h1>Unassigned</h1>
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th width="60px">
                                <div class="content" style="display:flex;">
                                    <div class="left" style="width:31%">
                                        Name
                                    </div>
                                    <div class="left" style="width:20%; padding-left:5px">
                                        City
                                    </div>
                                </div>
                            </th>
                        </tr>

                        <?php for ($i = 0; $i < sizeof($data) - 1; $i++)  {
                        if ($data[$i]->admin != 0) {
                            continue;
                        }?>
                            <tr>
                                <td>
                                    <a class="tile">
                                        <div class="content">
                                            <div class="left" style="width:30%">
                                                <?php echo $data[$i]->name ?>
                                            </div>
                                            <div class="left" style="width:20%">
                                                <?php echo $data[$i]->city ?>
                                            </div>
                                            <div class="right">
                                                <form action="<?php echo URLROOT ?>/admin/verifyLand" method="post" class="update-form">
                                                    <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                    <button type="submit" class="edit" onclick="return confirmSubmit();">
                                                        <img src="<?php echo URLROOT ?>/images/tick.svg" style="width: 18px" alt="">
                                                    </button>
                                                </form>
                                                &nbsp;
                                                <form action="<?php echo URLROOT ?>/admin/unverifyLand" method="post" class="delete-form">
                                                    <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                    <button type="submit" class="delete" onclick="return confirmSubmit();">
                                                        <img src="<?php echo URLROOT ?>/images/circle-xmark-regular.svg" style="width: 18px;" alt="">
                                                    </button>
                                                </form>
                                                &nbsp;
                                                <form action="<?php echo URLROOT ?>/admin/assignMySelf" method="post" class="delete-form">
                                                    <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                    <button type="submit" class="delete" onclick="return confirmSubmit();" style="background-color: #fcd426; padding: 5px 10px;">
                                                        Assign myself
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

                <h1>Assigned</h1>
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th width="60px">
                                <div class="content" style="display:flex;">
                                    <div class="left" style="width:31%">
                                        Name
                                    </div>
                                    <div class="left" style="width:20%; padding-left:5px">
                                        City
                                    </div>
                                </div>
                            </th>
                        </tr>

                        <?php for ($i = 0; $i < sizeof($data) - 1; $i++) {
                            if ($data[$i]->admin == $_SESSION['user_id']) {?>
                                <tr>
                                    <td>
                                        <a class="tile">
                                            <div class="content">
                                                <div class="left" style="width:30%">
                                                    <?php echo $data[$i]->name ?>
                                                </div>
                                                <div class="left" style="width:20%">
                                                    <?php echo $data[$i]->city ?>
                                                </div>
                                                <div class="right">
                                                    <form action="<?php echo URLROOT ?>/admin/verifyLand" method="post" class="update-form">
                                                        <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                        <button type="submit" class="edit" onclick="return confirmSubmit();">
                                                            <img src="<?php echo URLROOT ?>/images/tick.svg" style="width: 18px" alt="">
                                                        </button>
                                                    </form>
                                                    &nbsp;
                                                    <form action="<?php echo URLROOT ?>/admin/unverifyLand" method="post" class="delete-form">
                                                        <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                        <button type="submit" class="delete" onclick="return confirmSubmit();">
                                                            <img src="<?php echo URLROOT ?>/images/circle-xmark-regular.svg" style="width: 18px;" alt="">
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </section>
</main>

<script>
    function confirmSubmit() {
        return confirm("Are you sure you want to delete this land?");
    }
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
