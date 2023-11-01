<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'rating';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
        <img class="mechandiserParkingImage" src="<?php echo URLROOT ?>/images/parkingForMerchandiser.jpg" alt="Phone">
        <h2>Independence Square Parking Lot - Colombo07</h2>

            <div class="cards">
                <!-- Card 1 -->
                    <div class="card">
                        <a href="#">
                        <h2>Available Parkings</h2>
                            <ul>
                                <li>Car : 15</li>
                                <li>Bike : 30</li>
                                <li>Three Wheel : 20</li>
                            </ul>
                        </a>
                    </div>

                    <!-- Card 2 -->
                    <div class="card">
                        <a href="#">
                        <h2>Open</h2>
                            
                        <img class="ratingStar" src="<?php echo URLROOT ?>/images/ratingStar.png" alt="rating">
                        </a>
                    </div>  
            </div>  
        
            <div class="container1">
                <ul>
                    <li>Security not available</li>
                    <li>Parking at your own risk</li>
                </ul>
            </div> 

            <div class="container2">
                <a href="#">
                    <button>Packages</button>
                </a>

                <a href="#">
                    <button>Direction</button>
                </a>
            </div> 
        </div>      
    </section>
</main>
<?php require APPROOT.'/views/inc/footer.php'; ?>
