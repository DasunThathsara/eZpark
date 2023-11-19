<?php require APPROOT.'/views/inc/header.php'; ?>

<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'dashboard';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

    <main class="page-container">
        <section class="section" id="main">
            <div class="container">
                <h1><?php echo $data['name'] ?> Dashboard</h1>

                <div class="dropdown">
                    <button class="dropbtn">Select Parking</button>
                    <div class="dropdown-content">
                    <a href="<?php echo URLROOT ?>/parkingOwner/index">Main Dashboard</a>
                        <?php for ($i = 0; $i < sizeof($other_data); $i++) {
                            if($data['id'] == $other_data[$i]->id){
                                continue;
                            }?>     
                            <a href="<?php echo URLROOT ?>/parkingOwner/gotoLand/<?php echo $other_data[$i]->id ?>/<?php echo $other_data[$i]->name ?>"><?php echo $other_data[$i]->name ?></a>  
                        <?php } ?>
                    </div>
                </div>

                <div class="cards">
                    <!-- Card 1 -->
                    <a class="card-link" href="">
                        <div class="card">
                            <div class="row">
                                <div class="left-col">
                                    <div class="sub-row">
                                        <div class="top-row">
                                            <img src="<?php echo URLROOT ?>/images/vehicle.svg" alt="">
                                        </div>
                                        <div class="bottom-row">8</div>
                                    </div>
                                </div>
                                <div class="right-col">Total Lands</div>
                            </div>
                        </div>
                    </a>

                    <!-- Card 2 -->
                    <a class="card-link" href="">
                        <div class="card">
                            <div class="row">
                                <div class="left-col">
                                    <div class="sub-row">
                                        <div class="top-row">
                                            <img src="<?php echo URLROOT ?>/images/vehicle.svg" alt="">
                                        </div>
                                        <div class="bottom-row">8</div>
                                    </div>
                                </div>
                                <div class="right-col">Total Lands</div>
                            </div>
                        </div>
                    </a>

                    <!-- Card 3 -->
                    <a class="card-link" href="">
                        <div class="card">
                            <div class="row">
                                <div class="left-col">
                                    <div class="sub-row">
                                        <div class="top-row">
                                            <img src="<?php echo URLROOT ?>/images/vehicle.svg" alt="">
                                        </div>
                                        <div class="bottom-row">8</div>
                                    </div>
                                </div>
                                <div class="right-col">Total Lands</div>
                            </div>
                        </div>
                    </a>

                    <!-- Card 4 -->
                    <a class="card-link" href="<?php echo URLROOT ?>/LandCapacity/viewCapacity/<?php echo $data['id']?>/<?php echo $data['name']?>">
                        <div class="card">
                            <div class="row">
                                <div class="left-col">
                                    <div class="sub-row">
                                        <div class="top-row">
                                            <img src="<?php echo URLROOT ?>/images/vehicle.svg" alt="">
                                        </div>
                                        <div class="bottom-row"><?php echo $data['land_count'] ?></div>
                                    </div>
                                </div>
                                <div class="right-col">Parking Capacity</div>
                            </div>
                        </div>
                    </a>

                    <!-- Card 5 -->
                    <a class="card-link" href="<?php echo URLROOT ?>/land/prices/<?php echo $data['id'] ?>/<?php echo $data['name'] ?>">
                        <div class="card">
                            <div class="row">
                                <div class="left-col">
                                    <div class="sub-row">
                                        <div class="top-row">
                                        <img src="<?php echo URLROOT ?>/images/price.svg" alt="">
                                        </div>
                                        <div class="bottom-row"></div>
                                    </div>
                                </div>
                                <div class="right-col">Price Rate</div>
                            </div>
                        </div>
                    </a>

                    <!-- Card 6 -->
                    <a class="card-link" href="<?php echo URLROOT ?>/package/viewPackages/<?php echo $data['id'] ?>/<?php echo $data['name'] ?>">
                        <div class="card">
                            <div class="row">
                                <div class="left-col">
                                    <div class="sub-row">
                                        <div class="top-row">
                                            <img src="<?php echo URLROOT ?>/images/package.svg" alt="">
                                        </div>
                                        <div class="bottom-row"><?php echo $data['package_count'] ?></div>
                                    </div>
                                </div>
                                <div class="right-col">Packages</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </main>

<?php require APPROOT.'/views/inc/footer.php'; ?>