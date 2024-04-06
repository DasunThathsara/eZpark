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
                                        Name
                                    </div>
                                    <div class="left" style="width:20%; padding-left:5px">
                                        City
                                    </div>
                                </div>
                            </th>
                        </tr>

                        <?php for ($i = 0; $i < sizeof($data); $i++)  {
                        if ($data[$i]->adminID != 0) {
                            continue;
                        }?>
                            <tr>
                                <td>
                                    <a class="tile">
                                        <div class="content" id="content">
                                            <div class="left" style="width:30%">
                                                <?php echo $data[$i]->name ?>
                                            </div>
                                            <div class="left" style="width:20%">
                                                <?php echo $data[$i]->city ?>
                                            </div>
                                            <div class="right">
                                                <form action="<?php echo URLROOT ?>/admin/verifyLand" method="post" class="update-form">
                                                    <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                    <button type="submit" class="edit" onclick="return confirmSubmit1();">
                                                        <img src="<?php echo URLROOT ?>/images/tick.svg" style="width: 18px" alt="">
                                                    </button>
                                                </form>
                                                &nbsp;
                                                <form action="<?php echo URLROOT ?>/admin/unverifyLand" method="post" class="delete-form">
                                                    <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                    <button type="submit" class="delete" onclick="return confirmSubmit2();">
                                                        <img src="<?php echo URLROOT ?>/images/circle-xmark-regular.svg" style="width: 18px;" alt="">
                                                    </button>
                                                </form>
                                                &nbsp;
                                                <form action="<?php echo URLROOT ?>/admin/assignMySelf" method="post" class="delete-form">
                                                    <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                    <button type="submit" class="delete" id="bttn" onclick="return confirmSubmit3();">
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
                

                    <h1 id="ttitle">Assigned</h1>
                
                    <table class="requesttable">
                        <tr>
                            <th>
                                <div class="content" id="theader">
                                    <div class="left" style="width:31%">
                                        Name
                                    </div>
                                    <div class="left" style="width:20%; padding-left:5px ">
                                        City
                                    </div>
                                </div>
                            </th>
                        </tr>

                        <?php for ($i = 0; $i < sizeof($data); $i++) {
                            if ($data[$i]->adminID == $_SESSION['user_id']) {?>
                                <tr>
                                    <td>
                                        <a class="tile">
                                            <div class="content" id="content" >
                                                <div class="left" style="width:30%">
                                                    <?php echo $data[$i]->name ?>
                                                </div>
                                                <div class="left" style="width:20%">
                                                    <?php echo $data[$i]->city ?>
                                                </div>
                                                <div class="right">
                                                    <form action="<?php echo URLROOT ?>/admin/verifyLand" method="post" class="update-form">
                                                        <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                        <button type="submit" class="edit" onclick="return confirmSubmit1();">
                                                            <img src="<?php echo URLROOT ?>/images/tick.svg" style="width: 18px" alt="">
                                                        </button>
                                                    </form>
                                                    &nbsp;
                                                    <form action="<?php echo URLROOT ?>/admin/unverifyLand" method="post" class="delete-form">
                                                        <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                        <button type="submit" class="delete" onclick="return confirmSubmit2();">
                                                            <img src="<?php echo URLROOT ?>/images/circle-xmark-regular.svg" style="width: 18px;" alt="">
                                                        </button>
                                                    </form>
                                                    &nbsp;
                                                    <form action="<?php echo URLROOT ?>/admin/unassignedMySelf" method="post" class="delete-form">
                                                        <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                        <button type="submit" class="delete" id="bttn" onclick="return confirmSubmit4();" >
                                                            Unassigned myself
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
        return confirm("Are you sure you want to conferm this land?");
    }

    function confirmSubmit2() {
        return confirm("Are you sure you want to delete this land?");
    }

    function confirmSubmit3() {
        return confirm("Are you sure you want to assign this land to yourself?");
    }

    function confirmSubmit4() {
        return confirm("Are you sure you want to unassign this land from yourself?");
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#toggleButton').change(function () {
            var isChecked = $(this).prop('checked');
            console.log("Checkbox is checked: " + isChecked);

            $.ajax({
                url: '<?php echo URLROOT?>/land/changeAvailability/<?php echo $data["id"]?>',
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
