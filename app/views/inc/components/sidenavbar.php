<div class="sidenav">
    <div class="container">
        <div class="logo"><img src="<?php echo URLROOT ?>/images/logo.png" alt="">
        <!-- <h7 style="font-size: 14px; position: absolute; left: 30px; top: 140px; font-weight: bold"><?php echo $_SESSION['user_type'] ?></h7> -->
        </div>
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
                        <div class="item selected"><img src="<?php echo URLROOT ?>/images/booking.svg" alt="">Reservations</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img src="<?php echo URLROOT ?>/images/booking.svg" alt="">Reservations</div>
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
            <?php } ?>

            <!------------------------------------------ Merchandiser ------------------------------------------>
            <?php if ($_SESSION['user_type'] == 'merchandiser'){ ?>
                <a href="<?php echo URLROOT ?>/merchandiser/lands">
                    <?php if ($section == 'lands'){?>
                        <div class="item selected"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/parking.png" alt="">Lands</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/parking.png" alt="">Lands</div>
                    <?php } ?>
                </a>

                <a href="<?php echo URLROOT ?>/merchandiser/viewReport">
                    <?php if ($section == 'reports'){?>
                        <div class="item selected"><img style="transform: translateY(4px)" src="<?php echo URLROOT ?>/images/deed.svg" alt="">Reports</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(4px)" src="<?php echo URLROOT ?>/images/deed.svg" alt="">Reports</div>
                    <?php } ?>
                </a>

                <a href="<?php echo URLROOT ?>/chat/viewChat">
                    <?php if ($section == 'chat'){?>
                        <div class="item selected"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/chat.svg" alt="">Chat</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/chat.svg" alt="">Chat</div>
                    <?php } ?>
                </a>

                <a href="<?php echo URLROOT ?>/merchandiser/findParking">
                    <?php if ($section == 'findParking'){?>
                        <div class="item selected"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/chat.svg" alt="">Find Parking</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/chat.svg" alt="">Find Parking</div>
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

                <a href="<?php echo URLROOT ?>/chat/viewChat">
                    <?php if ($section == 'chat'){?>
                        <div class="item selected"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/chat.svg" alt="">Chat</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/chat.svg" alt="">Chat</div>
                    <?php } ?>
                </a>
                
            <?php } ?>      

            <!-------------------------------------------- Security -------------------------------------------->
            <?php if ($_SESSION['user_type'] == 'security'){ ?>
                <a href="<?php echo URLROOT ?>/security/viewRequests">
                    <?php if ($section == 'parkingRequest'){?>
                        <div class="item selected"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/parking.svg" alt="">Parking Requests</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/parking.svg" alt="">Parking Requests</div>
                    <?php } ?>
                </a>
            <?php }?>

            
            <!-------------------------------------------- Admin-------------------------------------------->
            <?php if ($_SESSION['user_type'] == 'admin'){ ?>
                <a href="<?php echo URLROOT ?>/admin/complaints">
                    <?php if ($section == 'complaints'){?>
                        <div class="item selected"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/chat.svg" alt="">Complaints</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/chat.svg" alt="">Complaints</div>
                    <?php } ?>
                </a>

                <a href="<?php echo URLROOT ?>/admin/viewRegistrationRequests">
                    <?php if ($section == 'registrationRequests'){?>
                        <div class="item selected"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/request.png" alt="">Registration Requests</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/request.png" alt="">Registration Requests</div>
                    <?php } ?>
                </a>
            <?php }?>


            <!-------------------------------------------- Admin-------------------------------------------->
            <?php if ($_SESSION['user_type'] == 'superAdmin'){ ?>
                <a href="<?php echo URLROOT ?>/superAdmin/complaints">
                    <?php if ($section == 'complaints'){?>
                        <div class="item selected"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/chat.svg" alt="">Complaints</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/chat.svg" alt="">Complaints</div>
                    <?php } ?>
                </a>

                <a href="<?php echo URLROOT ?>/superAdmin/viewRegistrationRequests">
                    <?php if ($section == 'registrationRequests'){?>
                        <div class="item selected"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/request.png" alt="">Registration Requests</div>
                    <?php }
                    else{ ?>
                        <div class="item"><img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/request.png" alt="">Registration Requests</div>
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


            <div class="logout"><a id="logout" href="<?php echo URLROOT ?>/users/logout" onclick="confirmLogout(event)">Logout</a></div>

        </div>
    </div>
</div>

<script>
    function confirmLogout(event) {
        event.preventDefault(); // Prevent the default link behavior

        // Use SweetAlert for confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to logout.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the logout URL
                window.location.href = event.target.href;
            }
        });
    }
</script>
