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
            <form action="<?php echo URLROOT ?>/package/packageRegisterForm" method="POST">
                <input type="text" name="pname" id="pname" hidden required value="<?php echo $data['Pname'] ?>">
                <button type="submit" style="font-weight: 1000; font-size: 20px">+</button>
            </form>

            <?php if (sizeof($data) == 1) {?>
                <div class="emptyVehicle">You have no any registered vehicles</div>
            <?php }
            else {?>
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th>Package Name</th>
                            <th>Price</th>
                            <th>Package Type</th>
                            <th width="60px"></th>
                        </tr>
                        <?php for ($i = 0; $i < sizeof($data); $i++) {?>
                            <tr>
                                <td>
                                    <?php echo $data[$i]->name ?>
                                </td>
                                <td>
                                    <?php echo $data[$i]->price ?>
                                </td>
                                <td>
                                    <?php echo $data[$i]->packageType ?>
                                </td>
                                <td style="text-align: center; display: flex">
                                    <form action="<?php echo URLROOT ?>/package/packageUpdateForm" method="post">
                                        <input type="text" name="name" id="name" hidden value="<?php echo $data[$i]->name ?>" />
                                        <input type="text" name="price" id="price" hidden value="<?php echo $data[$i]->price ?>" />
                                        <input type="text" name="package_type" id="package_type" hidden value="<?php echo $data[$i]->packageType ?>" />
                                        <input type="submit" class="sub-option" value="Update"/>
                                    </form>
                                    &nbsp;
                                    <form action="<?php echo URLROOT ?>/package/packageRemove" method="post">
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
        return confirm("Are you sure you want to delete this vehicle?");
    }
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
