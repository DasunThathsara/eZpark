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
            <h1>Update Price</h1>

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
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th width="60px">
                                <div class="content" style="display:flex;">
                                    <div class="left" style="width:31%">
                                        Vehicle Type
                                    </div>
                                    <div class="left" style="width:18%;">
                                        Hour Price
                                    </div>
                                    <div class="left" style="width:20%; padding-left:45px;">
                                        Additional Hour Price
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <?php for ($i = 0; $i < sizeof($other_data); $i++) {
                            if($other_data[$i]->hourPrice == 0 or $data['vehicle_type'] != $other_data[$i]->vehicleType){
                                continue;
                            }?>
                            <tr>
                                <td width="70%">
                                    <a class="tile">
                                        <div class="content">
                                            <form action="<?php echo URLROOT ?>/landprice/priceUpdate" style="display:flex; width: 100%" method="POST">
                                                <input type="text" name="id" id="id" hidden value="<?php echo $data['id'] ?>" />
                                                <input type="text" name="name" id="name" hidden value="<?php echo $data['name'] ?>" />
                                                <div class="left" style="padding-top: 20px;">
                                                    <input type="text" name="vehicle_type" id="vehicle_type" hidden value="<?php echo $other_data[$i]->vehicleType ?>" />
                                                    <?php echo $other_data[$i]->vehicleType ?>
                                                </div>
                                                <div class="left">
                                                    <input type="text" name="hour_price" id="hour_price"  value="<?php echo $other_data[$i]->hourPrice ?>" style="margin: 0; padding: 5px; width: 80%; border: 1px solid #ccc; border-radius: 5px; max-width: 80px; text-align: center;" />
                                                </div>
                                                <div class="left">
                                                    <input type="text" name="additional_hour_price" id="additional_hour_price"  value="<?php echo $other_data[$i]->additionalHourPrice ?>" style="margin: 0; padding: 5px; width: 80%; border: 1px solid #ccc; border-radius: 5px; max-width: 80px; text-align: center;" />
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
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </section>
</main>
<script>
    function confirmSubmit() {
        return confirm("Are you sure you want to delete this land?");
    }
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
