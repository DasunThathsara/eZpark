<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'transactions';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1>Parking History</h1>

            <?php if(empty($data)){?>
                <div class="emptyVehicle">Empty</div>
            <?php } else {?>
                <table class="table">
                    <tr>
                        <td>
                            <div class="content-title">
                                <div class="left" style="width:20%;">Parking</div>
                                <div class="left" style="width:25%;">Vehicle</div>
                                <div class="left" style="width:20%;">Status</div>
                                <div class="left" style="width:20%;">Cost( LKR  )</div>
                                <div class="left" style="width:25%; text-align: center;">Start Time</div>
                                <div class="left" style="width:25%; text-align: center;">End Time</div>
                            </div>
                        </td>
                        <td width="40px"></td>
                    </tr>
                    <?php for ($i = 0; $i < sizeof($data); $i++) {?>
                        <tr>
                            <td>
                                <a class="tile">
                                    <div class="content" style="padding-bottom: 30px;">
                                        <div class="left" style="width:15%;">
                                            <div class="parking-name">
                                                <a href="<?php echo URLROOT?>/driver/gotoland/<?php echo $data[$i]->landID?>"><?php echo $data[$i]->name ?></a>
                                            </div>
                                            <div class="parking-location" style="color: #6b6b6b; font-size: 15px; transform: translateY(10px);">
                                                <?php echo $data[$i]->city ?>
                                            </div>
                                        </div>

                                        <div class="left" style="width:15%;">
                                            <div class="vehicle-type" style="transform: translateY(10px);">
                                                <?php if($data[$i]->vehicleType == 'bike'): ?>
                                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/motor-sports.png" alt="">
                                                <?php elseif($data[$i]->vehicleType == 'car'): ?>
                                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/car-c.png" alt="">
                                                <?php elseif($data[$i]->vehicleType == 'threeWheel'): ?>
                                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/tuk-tuk.png" alt="">
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="left" style="width:20%; font-size: 14px;">
                                            <div class="status" style="transform: translateY(10px);">
                                                <?php if($data[$i]->status == 0){
                                                    echo "<div style='color: #00bb00'>Completed</div>";
                                                } else if($data[$i]->status == 1){
                                                    echo "<div style='color: #ff9900'>On going</div>";
                                                }?>
                                            </div>
                                        </div>
                                        <div class="cost" style="width:12%; transform: translateY(15px);">
                                            <?php echo $data[$i]->cost ?>
                                        </div>
                                        <div class="left" style="width:15%; text-align: center; transform: translateY(15px);">
                                            <?php echo $data[$i]->startTime ; ?>
                                        </div>
                                        <div class="left" style="width:15%; text-align: center; transform: translateY(15px);">
                                            <?php echo $data[$i]->endTime ; ?>
                                        </div>
                                        <form style="padding-top:35px "action="<?php echo URLROOT ?>/driver/updateRecentTransaction" method="post">
                                            <input type="text" name="driverID" id="driverID" hidden value="<?php echo $data[$i]->driverID ?>" />
                                            <input type="text" name="landID" id="landID" hidden value="<?php echo $data[$i]->landID ?>" />
                                            <input type="text" name="startTime" id="startTime" hidden value="<?php echo $data[$i]->startTime ?>" />
                                            <button style="background-color:white; border:none; outline:none"type="submit" class="delete" onclick="return confirmSubmit();">
                                                <img style="width:20px; height:20px "src="<?php echo URLROOT ?>/images/transaction.png" alt="">
                                            </button>
                                        </form>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>

            <br><br>
        </div>
    </section>
</main>
<script>
    function confirmSubmit() {
        return confirm("Are you sure pay now");
    }
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
