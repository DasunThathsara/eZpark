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
            <h1>Packages</h1>

            <br><br>
            <a class="add-btn" href="<?php echo URLROOT ?>/package/packageRegister/<?php echo $data['id'] ?>/<?php echo $data['name'] ?>" style="font-weight: 1000; font-size: 20px">+</a>
            
            <?php if (sizeof($data) == 1) {?>
                <div class="emptyVehicle">You have no any registered vehicles</div>
            <?php }
            else {?>
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Type</th>
                            <th width="60px"></th>
                        </tr>
                        <?php for ($i = 0; $i < sizeof($other_data); $i++) {?>
                            <tr>
                                <td>
                                    <?php echo $other_data[$i]->name ?>
                                </td>
                                <td>
                                    <?php echo $other_data[$i]->price ?>
                                </td>
                                <td>
                                    <?php echo $other_data[$i]->packageType ?>
                                </td>
                                <td style="text-align: center; display: flex">
                                    <form action="<?php echo URLROOT ?>/package/packageUpdateForm" method="post">
                                        <input type="text" name="package_type" id="package_type" hidden value="<?php echo $other_data[$i]->package_type ?>" />
                                        <input type="text" name="package_price" id="package_price" hidden value="<?php echo $other_data[$i]->package_price ?>" />
                                        <input type="text" name="vehicle_type" id="vehicle_type" hidden value="<?php echo $other_data[$i]->vehicle_type ?>" />
                                        <input type="submit" class="sub-option" value="Update"/>
                                    </form>
                                    &nbsp;
                                    <form action="<?php echo URLROOT ?>/package/packageRemove" method="post">
                                    <input type="text" name="package_type" id="package_type" hidden value="<?php echo $other_data[$i]->package_type ?>" />
                                        <input type="text" name="package_price" id="package_price" hidden value="<?php echo $other_data[$i]->package_price ?>" />
                                        <input type="text" name="vehicle_type" id="vehicle_type" hidden value="<?php echo $other_data[$i]->vehicle_type ?>" />
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
