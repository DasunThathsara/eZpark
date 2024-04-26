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

            <?php if (!empty($data['err'])){?>
                <div class="error-msg">
                    <span class="form-invalid"><?php echo $data["err"] ?></span>
                </div>
            <?php } ?>

            <br><br>
            <?php if ($data['requestedCapacity'] == -1) {?>
                <div class="emptyLand">You have already received the response for that notification.</div>
            <?php }
            else {?>
            <h1>Update Capacity</h1>
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th width="60px">
                                <div class="content" style="display:flex;">
                                    <div class="left" style="width:26%">
                                        Vehicle Type
                                    </div>
                                    <div class="left" style="width:26%;">
                                        Capacity
                                    </div>
                                    <div class="left" style="width:20%; text-align: center;">
                                        Requested Capacity
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <td width="70%">
                                <a class="tile">
                                    <div class="content" style="display:flex; justify-content: space-between; align-items: center;"> 

                                        <div class="left" style="padding-top: 20px;">
                                            <input type="text" name="vehicle_type" id="vehicle_type" hidden value="<?php echo $data['vehicle_type'] ?>" />
                                            <?php echo $data['vehicle_type'] ?>
                                        </div>
                                        <div class="left">
                                            <input type="text" name="capacity" id="capacity" hidden value="<?php echo $data['capacity'] ?>" style="margin: 0; padding: 5px; width: 80%; border: 1px solid #ccc; border-radius: 5px; max-width: 80px; text-align: center;" />
                                            <?php echo $data['capacity'] ?>
                                        </div>  
                                        <div class="left">
                                            <input type="text" name="requestedCapacity" id="requestedCapacity" hidden value="<?php echo $data['requestedCapacity'] ?>" style="margin: 0; padding: 5px; width: 80%; border: 1px solid #ccc; border-radius: 5px; max-width: 80px; text-align: center;" />
                                            <?php echo $data['requestedCapacity'] ?>
                                        </div>  

                                        <form action="<?php echo URLROOT ?>/landCapacity/acceptRequestedCapacity" method="POST">
                                            <input type="text" name="id" id="id" hidden value="<?php echo $data['id'] ?>" />
                                            <input type="text" name="vehicle_type" id="vehicle_type" hidden value="<?php echo $data['vehicle_type'] ?>" />
                                            <input type="text" name="requestedCapacity" id="requestedCapacity" hidden value="<?php echo $data['requestedCapacity'] ?>" style="margin: 0; padding: 5px; width: 80%; border: 1px solid #ccc; border-radius: 5px; max-width: 80px; text-align: center;" />
                                
                                            <button type="submit" class="edit" style="background-color: white; outline: none; border: none;">
                                                <img src="<?php echo URLROOT ?>/images/tick.svg" alt="Edit" style="width: 25px; margin-right: 10px; transform: translate(-15px, 10px);"> 
                                            </button>
                                        </form>
                                        
                                        <form action="<?php echo URLROOT ?>/landCapacity/rejectRequestedCapacity" method="POST">
                                            <input type="text" name="id" id="id" hidden value="<?php echo $data['id'] ?>" />
                                            <input type="text" name="vehicle_type" id="vehicle_type" hidden value="<?php echo $data['vehicle_type'] ?>" />
                                            <input type="text" name="requestedCapacity" id="requestedCapacity" hidden value="<?php echo $data['requestedCapacity'] ?>" style="margin: 0; padding: 5px; width: 80%; border: 1px solid #ccc; border-radius: 5px; max-width: 80px; text-align: center;" />
                                
                                                <div class="right">
                                                    <button type="submit" class="edit">
                                                            <img src="<?php echo URLROOT ?>/images/xmark-solid.svg" alt="Edit" style="width: 25px; margin-right: 10px; transform: translateX(20px);"> 
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
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
