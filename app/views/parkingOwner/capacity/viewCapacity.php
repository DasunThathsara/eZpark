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
            <h1>Capacity</h1>

            <br><br>
            <!-- <a class="add-btn" href="<?php echo URLROOT ?>/package/packageRegister/<?php echo $data['id'] ?>" style="font-weight: 1000; font-size: 20px">+</a> -->
            
            <?php if (sizeof($data) == 1) {?>
                <div class="emptyVehicle">You have no any registered lands</div>
            <?php }
            else {?>
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th width="60px">
                                <div class="content" style="display:flex;">
                                    <div class="left" style="width:31%">
                                        Vehicle Type
                                    </div>
                                    <div class="left" style="width:20%; padding-left:12px;">
                                        Capacity
                                    </div>
                                    <?php if($_SESSION['user_type'] == 'security') {?>
                                    <div class="left" style="width:30%; padding-left:100px; text-align:center;">
                                        Request to Change Capacity
                                    </div>
                                    <?php }?>
                                </div>
                            </th>
                        </tr>

                        <tr>
                            <td>
                                <a class="tile">
                                    <div class="content">
                                        <div class="left" style="width:30%">
                                            Car
                                        </div>
                                        <div class="left" style="width:20%">
                                            <?php echo $other_data[0]->car?>
                                        </div>
                                        <div class="right">
                                            <form action="<?php echo URLROOT ?>/landCapacity/capacityUpdateForm" method="get">
                                                <input type="text" name="id" id="id" hidden value="<?php echo $data['id'] ?>" />
                                                <input type="text" name="vehicle_type" id="vehicle_type" hidden value="car" />
                                                <button type="submit" class="edit">
                                                    <img src="<?php echo URLROOT ?>/images/edit-solid.svg" alt="">
                                                </button>
                                            </form>
<!--                                            &nbsp;-->
<!--                                            <form action="--><?php //echo URLROOT ?><!--/package/packageRemove" method="post">-->
<!--                                                <input type="text" name="package_type" id="package_type" hidden value="--><?php //echo $other_data[$i]->name ?><!--" />-->
<!--                                                <input type="text" name="id" id="id" hidden value="--><?php //echo $data['id'] ?><!--" />-->
<!--                                                <input type="text" name="name" id="name" hidden value="--><?php //echo $data['name'] ?><!--" />-->
<!--                                                <input type="text" name="vehicle_type" id="vehicle_type" hidden value="--><?php //echo $other_data[$i]->packageType ?><!--" />-->
<!--                                                <button type="submit" class="delete" onclick="return confirmSubmit();">-->
<!--                                                    <img src="--><?php //echo URLROOT ?><!--/images/trash-solid.svg" alt="">-->
<!--                                                </button>-->
<!--                                            </form>-->
                                        </div>
                                    </div>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <a class="tile">
                                    <div class="content">
                                        <div class="left" style="width:30%">
                                            Bike
                                        </div>
                                        <div class="left" style="width:20%">
                                            <?php echo $other_data[0]->bike?>
                                        </div>
                                        <div class="right">
                                            <form action="<?php echo URLROOT ?>/landCapacity/capacityUpdateForm" method="get">
                                                <input type="text" name="id" id="id" hidden value="<?php echo $data['id'] ?>" />
                                                <input type="text" name="name" id="name" hidden value="<?php echo $data['name'] ?>" />
                                                <input type="text" name="vehicle_type" id="vehicle_type" hidden value="bike" />
                                                <button type="submit" class="edit">
                                                    <img src="<?php echo URLROOT ?>/images/edit-solid.svg" alt="">
                                                </button>
                                            </form>
                                            <!--                                            &nbsp;-->
                                            <!--                                            <form action="--><?php //echo URLROOT ?><!--/package/packageRemove" method="post">-->
                                            <!--                                                <input type="text" name="package_type" id="package_type" hidden value="--><?php //echo $other_data[$i]->name ?><!--" />-->
                                            <!--                                                <input type="text" name="id" id="id" hidden value="--><?php //echo $data['id'] ?><!--" />-->
                                            <!--                                                <input type="text" name="name" id="name" hidden value="--><?php //echo $data['name'] ?><!--" />-->
                                            <!--                                                <input type="text" name="vehicle_type" id="vehicle_type" hidden value="--><?php //echo $other_data[$i]->packageType ?><!--" />-->
                                            <!--                                                <button type="submit" class="delete" onclick="return confirmSubmit();">-->
                                            <!--                                                    <img src="--><?php //echo URLROOT ?><!--/images/trash-solid.svg" alt="">-->
                                            <!--                                                </button>-->
                                            <!--                                            </form>-->
                                        </div>
                                    </div>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <a class="tile">
                                    <div class="content">
                                        <div class="left" style="width:30%">
                                            Three Wheel
                                        </div>
                                        <div class="left" style="width:20%">
                                            <?php echo $other_data[0]->threeWheel?>
                                        </div>
                                        <div class="right">
                                            <form action="<?php echo URLROOT ?>/landCapacity/capacityUpdateForm" method="get">
                                                <input type="text" name="id" id="id" hidden value="<?php echo $data['id'] ?>" />
                                                <input type="text" name="name" id="name" hidden value="<?php echo $data['name'] ?>" />
                                                <input type="text" name="vehicle_type" id="vehicle_type" hidden value="threeWheel" />
                                                <button type="submit" class="edit">
                                                    <img src="<?php echo URLROOT ?>/images/edit-solid.svg" alt="">
                                                </button>
                                            </form>
                                            <!--                                            &nbsp;-->
                                            <!--                                            <form action="--><?php //echo URLROOT ?><!--/package/packageRemove" method="post">-->
                                            <!--                                                <input type="text" name="package_type" id="package_type" hidden value="--><?php //echo $other_data[$i]->name ?><!--" />-->
                                            <!--                                                <input type="text" name="id" id="id" hidden value="--><?php //echo $data['id'] ?><!--" />-->
                                            <!--                                                <input type="text" name="name" id="name" hidden value="--><?php //echo $data['name'] ?><!--" />-->
                                            <!--                                                <input type="text" name="vehicle_type" id="vehicle_type" hidden value="--><?php //echo $other_data[$i]->packageType ?><!--" />-->
                                            <!--                                                <button type="submit" class="delete" onclick="return confirmSubmit();">-->
                                            <!--                                                    <img src="--><?php //echo URLROOT ?><!--/images/trash-solid.svg" alt="">-->
                                            <!--                                                </button>-->
                                            <!--                                            </form>-->
                                        </div>
                                    </div>
                                </a>
                            </td>
                        </tr>
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
