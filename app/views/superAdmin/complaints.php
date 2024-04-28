<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'complaints';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>



<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1 class="title">Complaints</h1>
            <p class="subtitle">View and get actions about users</p>

            <br><br>
            <?php if (sizeof($data) == 0) {?>
                <div class="emptyVehicle">You have no any complaints</div>
            <?php }
            else {?>

                <div class="table-container" id="tcontainer">
                    <table class="requesttable" >
                        <tr>
                            <th >
                                <div class="content" id="theader">
                                    <div class="left" style="width:33%">
                                        Name
                                    </div>
                                    <div class="left" style="width:33%; padding-left:5px">
                                        Parking
                                    </div>
                                    <div class="left" style="width:33%; padding-left:5px">
                                        Message
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
                                    <a class="tile" href="<?php echo URLROOT?>/superAdmin/viewComplaint/<?php echo $data[$i]->complaintID?>">
                                        <div class="content" id="content">
                                            <div class="left" style="width:33%">
                                                <?php echo $data[$i]->complainerName ?>
                                            </div>
                                            <div class="left" style="width:33%; padding-left:149px">
                                                <?php echo $data[$i]->complaineeName ?>
                                            </div>
                                            <div class="left" style="width:33%; padding-left:149px">
                                                <?php echo $data[$i]->message ?>
                                            </div>
                                            <div class="right">
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
