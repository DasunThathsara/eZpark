<?php require APPROOT.'/views/inc/header.php'; ?>

<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'reports';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
           
            <div class="generate-reports">
            
            <div class="form-container" style="margin-top: 5vh"><!--change margin-top to 5vh-->
            <h1>Report Type Selection</h1>    <!--newly added-->
            <?php if (!empty($data['err'])){?>
            <div class="error-msg">
                <span class="form-invalid"><?php echo $data["err"] ?></span>
            </div>
            <?php } ?>

            <div class="type-select">
                <a href="<?php echo URLROOT ?>/parkingowner/report">
                    <div class="type-select-btn">
                    Occupancy Summary Report
                    </div>
                </a>

                <a href="<?php echo URLROOT ?>/parkingowner/report">
                    <div class="type-select-btn">
                    Revenue Report
                    </div>
                </a>

                <a href="<?php echo URLROOT ?>/parkingowner/report">
                    <div class="type-select-btn">
                        Type 03
                    </div>
                </a>

                <a href="<?php echo URLROOT ?>/parkingowner/report">
                    <div class="type-select-btn">
                        Type 04
                    </div>
                </a>

                <a href="<?php echo URLROOT ?>/parkingowner/report">
                    <div class="type-select-btn">
                        Type 05
                    </div>
                </a>
            </div>

            
        </div>

           
        </div>
    </section>
</main>


<?php require APPROOT.'/views/inc/footer.php'; ?>
