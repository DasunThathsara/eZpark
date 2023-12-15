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
            <a class="add-btn" href="<?php echo URLROOT ?>/package/packageRegister/<?php echo $data['id'] ?>" style="font-weight: 1000; font-size: 20px">+</a>

            <?php if (sizeof($data) == 1) {?>
                <div class="emptyVehicle">You have no any registered vehicles</div>
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
                                    <div class="left" style="width:20%; padding-left:5px">
                                        Price
                                    </div>
                                    <div class="left" style="width:20%; padding-left:12px;">
                                        Type
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <?php for ($i = 0; $i < sizeof($other_data) - 1; $i++) {?>
                            <tr>
                                <td>
                                    <a class="tile">
                                        <div class="content">
                                            <div class="left" style="width:30%">
                                                <?php echo $other_data[$i]->name ?>
                                            </div>
                                            <div class="left" style="width:20%">
                                                <?php echo $other_data[$i]->price ?>
                                            </div>
                                            <div class="left" style="width:20%">
                                                <?php echo $other_data[$i]->packageType ?>
                                            </div>
                                            <div class="right">
                                                <form action="<?php echo URLROOT ?>/package/packageUpdateForm" method="get">
                                                    <input type="text" name="id" id="id" hidden value="<?php echo $data['id'] ?>" />
                                                    <input type="text" name="package_type" id="package_type" hidden value="<?php echo $other_data[$i]->name ?>" />
                                                    <input type="text" name="vehicle_type" id="vehicle_type" hidden value="<?php echo $other_data[$i]->packageType ?>" />
                                                    <button type="submit" class="edit">
                                                        <img src="<?php echo URLROOT ?>/images/edit-solid.svg" alt="">
                                                    </button>
                                                </form>
                                                &nbsp;
                                                <form action="<?php echo URLROOT ?>/package/packageRemove" method="post">
                                                    <input type="text" name="package_type" id="package_type" hidden value="<?php echo $other_data[$i]->name ?>" />
                                                    <input type="text" name="id" id="id" hidden value="<?php echo $data['id'] ?>" />
                                                    <input type="text" name="vehicle_type" id="vehicle_type" hidden value="<?php echo $other_data[$i]->packageType ?>" />
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
