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
            <h1 id="requestheader">Registration Requests</h1>

            <br><br>
            <?php if (sizeof($data) == 0) {?>
                <div class="emptyVehicle">You have no any registration requests</div>
            <?php }
            else {?>
                
                <div class="table-container" id="tcontainer">
                    <h1 id="ttitle">Unassigned</h1>
                    <table class="requesttable" >
                        <tr>
                            <th >
                                <div class="content" id="theader">
                                    <div class="left" style="width:31%">
                                        Parking Name
                                    </div>
                                    <div class="left" style="width:20%; padding-left:5px">
                                        City
                                    </div>
                                </div>
                            </th>
                        </tr>

                        <?php for ($i = 0; $i < sizeof($data); $i++)  {
                        if ($data[$i]->adminID == 0) { ?>
                            <tr>
                                <td>
                                    <a class="tile" href="<?php echo URLROOT?>/superAdmin/viewRegistrationRequestedLand/<?php echo $data[$i]->id ?>">
                                        <div class="content" id="content">
                                            <div class="left" style="width:30%">
                                                <?php echo $data[$i]->name ?>
                                            </div>
                                            <div class="left" style="width:20%">
                                                <?php echo $data[$i]->city ?>
                                            </div>
                                            <div class="right">
                                                <form action="<?php echo URLROOT ?>/superAdmin/verifyLand" method="post" class="update-form">
                                                    <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                    <button type="submit" class="edit" onclick="return confirmSubmit1();">
                                                        <img src="<?php echo URLROOT ?>/images/tick.svg" style="width: 18px" alt="">
                                                    </button>
                                                </form>
                                                &nbsp;
                                                <form action="<?php echo URLROOT ?>/superAdmin/unverifyLand" method="post" class="delete-form">
                                                    <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                    <button type="submit" class="delete" onclick="return confirmSubmit2();">
                                                        <img src="<?php echo URLROOT ?>/images/circle-xmark-regular.svg" style="width: 18px;" alt="">
                                                    </button>
                                                <!-- </form>
                                                &nbsp;
                                                <form action="<?php echo URLROOT ?>/admin/assignMySelf" method="post" class="delete-form">
                                                    <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                    <button type="submit" class="delete" id="bttn" onclick="return confirmSubmit3();">
                                                        Assign myself
                                                    </button>
                                                </form> -->
                                            </div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php } ?>
                    </table>
                

                    <h1 id="ttitle">Assigned  (From Admins)</h1>
                
                    <table class="requesttable">
                        <tr>
                            <th>
                                <div class="content" id="theader">
                                <div class="left" style="width:31%">
                                        Admin Name
                                    </div>
                                    <div class="left" style="width:31%">
                                        Parking Name
                                    </div>
                                    <div class="left" style="width:20%; padding-left:5px ">
                                        City
                                    </div>
                                </div>
                            </th>
                        </tr>

                        <?php for ($i = 0; $i < sizeof($data); $i++) {
                            if ($data[$i]->adminID != 0) {?>
                                <tr>
                                    <td>
                                        <a class="tile" href="<?php echo URLROOT?>/superAdmin/viewRegistrationRequestedLand/<?php echo $data[$i]->id ?>">
                                            <div class="content" id="content" >
                                                <div class="left" style="width:30%">
                                                    <?php echo $data[$i]->adminName ?>
                                                    <br>
                                                    Admin ID:
                                                    <?php echo $data[$i]->adminID ?>
                                                </div>
                                                <div class="left" style="width:30%">
                                                    <?php echo $data[$i]->name ?>
                                                </div>
                                                <div class="left" style="width:20%">
                                                    <?php echo $data[$i]->city ?>
                                                </div>
                                                <div class="right">
                                                    <form action="<?php echo URLROOT ?>/superAdmin/verifyLand" method="post" class="update-form">
                                                        <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                        <button type="submit" class="edit" onclick="return confirmSubmit1();">
                                                            <img src="<?php echo URLROOT ?>/images/tick.svg" style="width: 18px" alt="">
                                                        </button>
                                                    </form>
                                                    &nbsp;
                                                    <form action="<?php echo URLROOT ?>/superAdmin/unverifyLand" method="post" class="delete-form">
                                                        <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                        <button type="submit" class="delete" onclick="return confirmSubmit2();">
                                                            <img src="<?php echo URLROOT ?>/images/circle-xmark-regular.svg" style="width: 18px;" alt="">
                                                        </button>
                                                    </form>
                                                    &nbsp;
                                                    <form action="<?php echo URLROOT ?>/superAdmin/unassignedAdminFromLand" method="post" class="delete-form">
                                                        <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                        <input type="text" name="admin" id="admin" hidden value="<?php echo $data[$i]->adminID ?>" />
                                                        <button type="submit" class="delete" id="bttn" onclick="return confirmSubmit3();" >
                                                            Unassigned <br>
                                                            (from <?php echo $data[$i]->adminName?>)
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
    function confirmSubmit1() {
        return confirm("Are you sure you want to confirm this land?");
    }

    function confirmSubmit2() {
        return confirm("Are you sure you want to delete this land?");
    }

    function confirmSubmit3() {
        return confirm("Are you sure you want to unasigned land from this admin?");
    }

</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
