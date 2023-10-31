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
            <h1>Parkings</h1>

            <br><br>
            <a href="<?php echo URLROOT ?>/merchandiser/landRegister" style="font-weight: 1000; font-size: 20px">+</a>

            <?php if (sizeof($data) == 0) {?>
                <div class="emptyLand">You have no any registered parkings</div>
            <?php }
            else {?>
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th>Parking Name</th>
                            <th>City</th>
                            <th>Street</th>
                            <th>Deed</th>
                            <th>No. of Cars</th>
                            <th>No. of Bikes</th>
                            <th>No. of Three Wheels</th>
                            <th>Contact No.</th>
                            <th width="60px"></th>
                        </tr>
                        <?php for ($i = 0; $i < sizeof($data); $i++) {?>
                            <tr>
                                <td>
                                    <?php echo $data[$i]->name ?>
                                </td>
                                <td>
                                    <?php echo $data[$i]->city ?>
                                </td>
                                <td>
                                    <?php echo $data[$i]->street ?>
                                </td>
                                <td>
                                    <?php echo $data[$i]->deed ?>
                                </td>
                                <td>
                                    <?php echo $data[$i]->car ?>
                                </td>
                                <td>
                                    <?php echo $data[$i]->bike ?>
                                </td>
                                <td>
                                    <?php echo $data[$i]->threeWheel ?>
                                </td>
                                <td>
                                    <?php echo $data[$i]->contactNo ?>
                                </td>
                                <td style="text-align: center">
                                    <form action="<?php echo URLROOT ?>/merchandiser/landUpdateForm" method="post">
                                        <input type="text" name="name" id="name" hidden value="<?php echo $data[$i]->name ?>" />
                                        <input type="text" name="city" id="city" hidden value="<?php echo $data[$i]->city ?>" />
                                        <input type="text" name="street" id="street" hidden value="<?php echo $data[$i]->street ?>" />
                                        <input type="text" name="deed" id="deed" hidden value="<?php echo $data[$i]->deed ?>" />
                                        <input type="number" name="car" id="car" hidden value="<?php echo $data[$i]->car ?>" />
                                        <input type="number" name="bike" id="bike" hidden value="<?php echo $data[$i]->bike ?>" />
                                        <input type="number" name="threeWheel" id="threeWheel" hidden value="<?php echo $data[$i]->threeWheel ?>" />
                                        <input type="number" name="contactNo" id="contactNo" hidden value="<?php echo $data[$i]->contactNo ?>" />
                                        <input type="submit" class="sub-option" value="Update"/>
                                    </form>
                                    <form action="<?php echo URLROOT ?>/merchandiser/landRemove" method="post">
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
        return confirm("Are you sure you want to delete this parking?");
    }
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
