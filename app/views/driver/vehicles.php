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
            <a href="<?php echo URLROOT ?>/driver/vehicleRegister">Add Vehicle</a>

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
                                <td><?php echo $data[$i]->name ?></td>
                                <td><?php echo $data[$i]->vehicleType ?></td>
                                <td style="text-align: center"><a class="sub-option" href="#">Update</a><br><br>
                                    <a class="sub-option" href="#">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
