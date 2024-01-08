<div class="sidenav">
    <div class="container">
        <div class="logo"><img src="<?php echo URLROOT ?>/images/logo.png" alt=""></div>
        <a class="sidenav-close-btn" onclick="navToggleClose()">X</a>
        <div class="items">
            <a href="<?php echo URLROOT ?>/<?php echo $_SESSION['user_type'] ?>/index">
                <?php if ($section == 'dashboard'){?>
                    <div class="item selected"><img style="transform: translateY(2px)" src="<?php echo URLROOT ?>/images/home.svg" alt="">Dashboard</div>
                <?php }
                else{ ?>
                    <div class="item"><img style="transform: translateY(2px)" src="<?php echo URLROOT ?>/images/home.svg" alt="">Dashboard</div>
                <?php } ?>
            </a>

            <!--------------------------------------------- Driver --------------------------------------------->
            <?php if ($_SESSION['user_type'] == 'driver'){ ?>
                <a href="<?php echo URLROOT ?>/driver/booking">
                    <?php if ($section == 'booking'){?>
                        <div class="item selected"><img src="<?php echo URLROOT ?>/images/booking.svg" alt="">Bookings</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img src="<?php echo URLROOT ?>/images/booking.svg" alt="">Bookings</div>
                    <?php } ?>
                </a>

                <a href="<?php echo URLROOT ?>/driver/search">
                    <?php if ($section == 'search'){?>
                        <div class="item selected"><img src="<?php echo URLROOT ?>/images/search.svg" alt="">Search Parking</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img src="<?php echo URLROOT ?>/images/search.svg" alt="">Search Parking</div>
                    <?php } ?>
                </a>

                <a href="<?php echo URLROOT ?>/driver/history">
                    <?php if ($section == 'history'){?>
                        <div class="item selected"><img src="<?php echo URLROOT ?>/images/history.svg" alt="">Parking History</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img src="<?php echo URLROOT ?>/images/history.svg" alt="">Parking History</div>
                    <?php } ?>
                </a>

                <a href="<?php echo URLROOT ?>/driver/packages">
                    <?php if ($section == 'packages'){?>
                        <div class="item selected"><img src="<?php echo URLROOT ?>/images/package.svg" alt="">Packages</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img src="<?php echo URLROOT ?>/images/package.svg" alt="">Packages</div>
                    <?php } ?>
                </a>

                <a href="<?php echo URLROOT ?>/driver/vehicles">
                    <?php if ($section == 'vehicles'){?>
                        <div class="item selected"><img src="<?php echo URLROOT ?>/images/vehicle.svg" alt="">Vehicles</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img src="<?php echo URLROOT ?>/images/vehicle.svg" alt="">Vehicles</div>
                    <?php } ?>
                </a>

                <a href="<?php echo URLROOT ?>/driver/rating">
                    <?php if ($section == 'rating'){?>
                        <div class="item selected"><img src="<?php echo URLROOT ?>/images/rating.svg" alt="">Rating</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img src="<?php echo URLROOT ?>/images/rating.svg" alt="">Rating</div>
                    <?php } ?>
                </a>
            <?php } ?>

            <!------------------------------------------ Merchandiser ------------------------------------------>
            <?php if ($_SESSION['user_type'] == 'merchandiser'){ ?>
                <a href="<?php echo URLROOT ?>/merchandiser/lands">
                    <?php if ($section == 'lands'){?>
                        <div class="item selected"><img src="<?php echo URLROOT ?>/images/parking.png" alt="">Parkings</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img src="<?php echo URLROOT ?>/images/parking.png" alt="">Parkings</div>
                    <?php } ?>
                </a>
            <?php } ?>

            <!------------------------------------------ Parking owner ----------------------------------------->
            <?php if ($_SESSION['user_type'] == 'parkingOwner'){ ?>
                <a href="<?php echo URLROOT ?>/parkingOwner/lands">
                    <?php if ($section == 'lands'){?>
                        <div class="item selected"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/parking.png" alt="">Lands</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/parking.png" alt="">Lands</div>
                    <?php } ?>
                </a>

                <a href="<?php echo URLROOT ?>/parkingOwner/viewReport">
                    <?php if ($section == 'reports'){?>
                        <div class="item selected"><img style="transform: translateY(4px)" src="<?php echo URLROOT ?>/images/deed.svg" alt="">Reports</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(4px)" src="<?php echo URLROOT ?>/images/deed.svg" alt="">Reports</div>
                    <?php } ?>
                </a>
            <?php } ?>

            <!-------------------------------------------- Security -------------------------------------------->
            <?php if ($_SESSION['user_type'] == 'security'){ ?>
                <a href="<?php echo URLROOT ?>/security/viewRequests">
                    <?php if ($section == 'security'){?>
                        <div class="item selected"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/parking.svg" alt="">Parking Requests</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/parking.svg" alt="">Parking Requests</div>
                    <?php } ?>
                </a>
            <?php }?>


            <a href="<?php echo URLROOT ?>/users/viewProfile">
                <?php if ($section == 'profile'){?>
                    <div class="item selected"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/profile.svg" alt="">Profile</div>
                <?php }
                else{ ?>
                    <div class="item"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/profile.svg" alt="">Profile</div>
                <?php } ?>
            </a>


            <div class="logout"><a href="<?php echo URLROOT ?>/users/logout">Logout</a></div>
        </div>
    </div>
</div>
