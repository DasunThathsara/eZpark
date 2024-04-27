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
            <h1>Update Capacity</h1>

            <?php if (!empty($data['err'])){?>
                <div class="error-msg">
                    <span class="form-invalid"><?php echo $data["err"] ?></span>
                </div>
            <?php } ?>

            <br><br>
            <?php if (sizeof($data) == 0) {?>
                <div class="emptyLand">You have no any registered lands</div>
            <?php }
            else {?>
            <?php if ($_SESSION['user_type'] == 'parkingOwner'){ ?>
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th width="60px">
                                <div class="content" style="display:flex;">
                                    <div class="left" style="width:45%">
                                        Vehicle Type
                                    </div>
                                    <div class="left" style="width:18%;">
                                        Capacity
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <td width="70%">
                                <a class="tile">
                                    <div class="content"> 
                                        <form action="<?php echo URLROOT ?>/landCapacity/capacityUpdate" style="display:flex; width: 100%" method="POST">
                                            <input type="text" name="id" id="id" hidden value="<?php echo $data['id'] ?>" />
                                            <div class="left" style="padding-top: 20px;">
                                                <input type="text" name="vehicle_type" id="vehicle_type" hidden value="<?php echo $data['vehicle_type'] ?>" />
                                                <?php echo $data['vehicle_type'] ?>
                                            </div>
                                            <div class="left">
                                                <input type="text" name="capacity" id="capacity"  value="<?php echo $data['capacity'] ?>" style="margin: 0; padding: 5px; width: 80%; border: 1px solid #ccc; border-radius: 5px; max-width: 80px; text-align: center;" />
                                                <input type="text" name="requestedCapacity" id="requestedCapacity"  hidden value="<?php echo $data['requestedCapacity'] ?>" style="margin: 0; padding: 5px; width: 80%; border: 1px solid #ccc; border-radius: 5px; max-width: 80px; text-align: center;" />
                                            </div>
                                            
                                                <div class="right">
                                                    <button type="submit" class="edit">
                                                        <img src="<?php echo URLROOT ?>/images/tick.svg" alt="Edit" style="width: 25px; margin-right: 10px"> 
                                                    </button>
                                                </div>
                                        </form>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php }else if($_SESSION['user_type'] == 'security'){ ?>
                <!-- <?php print_r($data) ?> -->
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th width="60px">
                                <div class="content" style="display:flex;">
                                    <div class="left" style="width:28%">
                                        Vehicle Type
                                    </div>
                                    <div class="left" style="width:28%;">
                                        Capacity
                                    </div>
                                    <div class="left" style="width:18%; text-align: center;">
                                        Request Capacity
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <td width="70%">
                                <a class="tile">  
                                    <div class="content"> 
                                            <form action="<?php echo URLROOT ?>/landCapacity/requestCapacityUpdate" style="display:flex; width: 100%" method="POST">
                                                <input type="text" name="id" id="id" hidden value="<?php echo $data['id'] ?>" />
                                                <!-- <input type="text" name="requestedCapacity" id="requestedCapacity" value="<?php echo $data['capacity'] ?>" /> -->
                                                <div class="left" style="padding-top: 20px;">
                                                    <input type="text" name="vehicle_type" id="vehicle_type" hidden value="<?php echo $data['vehicle_type'] ?>" />
                                                    <?php echo $data['vehicle_type'] ?>
                                                </div>
                                                <div class="left" style="padding-top: 20px;">
                                                    <input type="text" name="capacity" id="capacity" hidden value="<?php echo $data['capacity'] ?>" />
                                                    <?php echo $data['capacity'] ?>
                                                </div>
                                                
                                                <div class="left">
                                                    <?php if($data['requestedCapacity'] == -1) {?>
                                                        <input type="text" name="requestedCapacity" id="requestedCapacity" value="<?php echo $data['capacity'] ?>" style="margin: 0; padding: 5px; width: 80%; border: 1px solid #ccc; border-radius: 5px; max-width: 80px; text-align: center;" />
                                                        <input type="text" name="capacity" id="capacity" hidden value="<?php echo $data['capacity'] ?>" style="margin: 0; padding: 5px; width: 80%; border: 1px solid #ccc; border-radius: 5px; max-width: 80px; text-align: center;" />
                                                    <?php } else{?>
                                                        <input type="text" name="requestedCapacity" id="requestedCapacity" value="<?php echo $data['requestedCapacity'] ?>" style="margin: 0; padding: 5px; width: 80%; border: 1px solid #ccc; border-radius: 5px; max-width: 80px; text-align: center;" />
                                                        <input type="text" name="capacity" id="capacity" hidden value="<?php echo $data['capacity'] ?>" style="margin: 0; padding: 5px; width: 80%; border: 1px solid #ccc; border-radius: 5px; max-width: 80px; text-align: center;" />
                                                    <?php }?>  
                                                </div>
                                            
                                                <div class="right">
                                                <!-- <?php print_r($data) ?>  -->
                                                    <!-- <button type="submit" class="edit">
                                                        <img src="<?php echo URLROOT ?>/images/request.png" alt="Edit" style="width: 25px; margin-right: 10px"> 
                                                    </button> -->
                                                    <button type="submit" class="edit" onclick="confirmSubmit()">
                                                        <?php if ($data['requestedCapacity'] == -1){?>
                                                            <img id="dynamicImage" src="<?php echo URLROOT ?>/images/tick.svg" alt="">
                                                        <?php } else {?>   
                                                            <img id="dynamicImage" src="<?php echo URLROOT ?>/images/pending.svg" alt="">
                                                        <?php }?>    
                                                    </button>
                                                </div>
                                            </form>  
                                    </div>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php } ?>  
            <?php } ?>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
