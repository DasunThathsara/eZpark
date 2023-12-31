<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'vehicles';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1>My Vehicles</h1>

            <br><br>
            <a class="add-btn" href="<?php echo URLROOT ?>/vehicle/vehicleRegister" style="font-weight: 1000; font-size: 20px">+</a>

            <?php if (sizeof($data) == 0) {?>
                <div class="emptyVehicle">You have no any registered vehicles</div>
            <?php }
            else {?>
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th>Vehicle Name</th>
                            <th width="60px"></th>
                        </tr>
                        <?php for ($i = 0; $i < sizeof($data); $i++) {?>
                            <tr>
                                <td>
                                    <a class="tile">
                                        <div class="content">
                                            <div class="left" style="width:50%">
                                                <?php echo $data[$i]->name ?>
                                            </div>
                                            <div class="left" style="width:20%">
                                                <?php echo $data[$i]->vehicleType ?>
                                            </div>
                                            <div class="right">
                                                <form action="<?php echo URLROOT ?>/vehicle/vehicleUpdateForm" method="post">
                                                    <input type="text" name="name" id="name" hidden value="<?php echo $data[$i]->name ?>" />
                                                    <input type="text" name="vehicle_type" id="vehicle_type" hidden value="<?php echo $data[$i]->vehicleType ?>" />
                                                    <button type="submit" class="edit">
                                                        <img src="<?php echo URLROOT ?>/images/edit-solid.svg" alt="">
                                                    </button>
                                                </form>
                                                &nbsp;
                                                <form action="<?php echo URLROOT ?>/vehicle/vehicleRemove" method="post">
                                                    <input type="text" name="name" id="name" hidden value="<?php echo $data[$i]->name ?>" />
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
        return confirm("Are you sure you want to delete this vehicle?");
    }
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
