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
            <h1>Vehicles</h1>

            <br><br>
            <a href="<?php echo URLROOT ?>/driver/vehicleRegister" style="font-weight: 1000; font-size: 20px">+</a>

            <?php if (sizeof($data) == 0) {?>
                <div class="emptyVehicle">You have no any registered vehicles</div>
            <?php }
            else {?>
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th>Vehicle Name</th>
                            <th>Vehicle Type</th>
                            <th width="60px"></th>
                        </tr>
                        <?php for ($i = 0; $i < sizeof($data); $i++) {?>
                            <tr>
                                <td>
                                    <?php echo $data[$i]->name ?>
                                </td>
                                <td>
                                    <?php echo $data[$i]->vehicleType ?>
                                </td>
                                <td style="text-align: center; display: flex">
                                    <form action="<?php echo URLROOT ?>/driver/vehicleUpdateForm" method="post">
                                        <input type="text" name="name" id="name" hidden value="<?php echo $data[$i]->name ?>" />
                                        <input type="text" name="vehicle_type" id="vehicle_type" hidden value="<?php echo $data[$i]->vehicleType ?>" />
                                        <input type="submit" class="sub-option" value="Update"/>
                                    </form>
                                    &nbsp;
                                    <form action="<?php echo URLROOT ?>/driver/vehicleRemove" method="post">
                                        <input type="text" name="name" id="name" hidden value="<?php echo $data[$i]->name ?>" />
                                        <input type="submit" class="sub-option" onclick="return confirmSubmit();" value="Delete"/>
                                    </form>
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
