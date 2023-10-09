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
            <h1>Lands</h1>

            <br><br>
            <a href="<?php echo URLROOT ?>/parkingOwner/landRegister" style="font-weight: 1000; font-size: 20px">+</a>

            <?php if (sizeof($data) == 0) {?>
                <div class="emptyLand">You have no any registered lands</div>
            <?php }
            else {?>
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th>Land Name</th>
                            <th>City</th>
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
                                <td style="text-align: center">
                                    <form action="<?php echo URLROOT ?>/parkingOwner/landUpdateForm" method="post">
                                        <input type="text" name="name" id="name" hidden value="<?php echo $data[$i]->name ?>" />
                                        <input type="text" name="city" id="city" hidden value="<?php echo $data[$i]->city ?>" />
                                        <input type="submit" class="sub-option" value="Update"/>
                                    </form>
                                    <form action="<?php echo URLROOT ?>/parkingOwner/landRemove" method="post">
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
        return confirm("Are you sure you want to delete this land?");
    }
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
