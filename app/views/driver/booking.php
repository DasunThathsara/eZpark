<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'booking';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1>Booking History</h1>

            <?php if(empty($data)){?>
                <div class="emptyVehicle">Empty</div>
            <?php } else {?>
                <table class="table">
                    <tr>
                        <td>
                            <div class="content-title">
                                <div class="left" style="width:30%;">Parking</div>
                                <div class="left" style="width:15%;">Vehicle</div>
                                <div class="left" style="width:20%;">Status</div>
                                <div class="left" style="width:25%; text-align: center;">Time</div>
                            </div>
                        </td>
                        <td width="40px"></td>
                    </tr>
                    <?php for ($i = 0; $i < sizeof($data); $i++) {?>
                        <tr>
                            <td>
                                <a class="tile">
                                    <div class="content" style="padding-bottom: 30px;">
                                        <div class="left" style="width:30%;">
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
                                            <div class="cost" style="transform: translateY(15px);">
                                                LKR <?php echo $data[$i]->cost ?>
                                            </div>
                                        </div>
                                        <div class="left" style="width:25%; text-align: center; transform: translateY(15px);">
                                            <?php echo $date = date('Y-m-d', strtotime($data[$i]->startTime)); ?>
                                        </div>
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
        return confirm("Are you sure you want to delete this booking?");
    }
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
