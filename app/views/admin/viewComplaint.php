<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'complaints';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1 class="title">View Complaint</h1>
            <p class="subtitle">View the complaint details</p>
            <?php if(isset($_GET['error'])){?>
                <div style="color: red; background-color: rgba(255,0,0,0.05); border-radius: 10px; padding: 5px; width: calc(100% - 30px); text-align: center; border: 1px solid rgba(255,0,0,0.1); margin-top: 30px; font-size: 13px;">
                    You have no any free vehicle to enter the parking
                </div>
            <?php }?>
            <div class="view-parking-container " style="">
                <div class="parking-cover-container">
                    <img class="parking-cover" src="<?php echo URLROOT ?>/images/parking_bg1.jpg" alt="Phone">
                </div>

                <div class="parking-details">
                    <div class="main-area">
                        <div class="parking-about">
                            <div class="parking-name"><?php echo $data->name?></div>
                            <div class="parking-address"><?php echo ucwords($data->address)?>, <?php echo ucwords($data->street)?>, <?php echo ucwords($data->city)?></div>
                            <div class="parking-open-time">Open Hours: 8.30 AM - 9.30 PM</div>
                        </div>
                        <div class="parking-directions">
                            <form action="<?php echo URLROOT ?>/admin/banParking" method="post" class="request-form" id="request-form">
                                <input type="text" name="landID" id="landID" hidden value="<?php echo $other_data['complaint_details']->complaineeID?>" />
                                <input type="text" name="id" id="id" hidden value="<?php echo $other_data['complaint_details']->complaintID?>" />
                                <input type="text" name="ownerID" id="ownerID" hidden value="<?php echo $other_data['complaint_details']->ownerID?>" />
                                <button type="submit" style="border: none; background-color: rgb(250,202,5); color: white; border-radius: 10px; padding: 10px 10px; display: flex; justify-content: space-between; align-items: center; width: 150px;" onclick="confirmSubmit()">
                                    Ban Parking
                                </button>
                            </form>

                            <form action="<?php echo URLROOT ?>/admin/banUser" method="post" class="request-form-2" id="request-form-2">
                                <input type="text" name="id" id="id" hidden value="<?php echo $other_data['complaint_details']->complaintID?>" />
                                <input type="text" name="ownerID" id="ownerID" hidden value="<?php echo $other_data['complaint_details']->ownerID?>" />
                                <button type="submit" style="border: none; background-color: rgb(250,202,5); color: white; border-radius: 10px; padding: 10px 10px; display: flex; justify-content: space-between; align-items: center; margin-top: 5px; width: 150px;" onclick="confirmSubmit()">
                                    Ban Parking Owner
                                </button>
                            </form>
                        </div>
                    </div>

                    <div style="background-color: #ffffff; border: 3px dotted red; padding: 15px; border-radius: 10px; margin-top: 30px; width: calc(100% - 70px);">
                        <div class="complaint-complainer">
                            Complainer: <?php echo $other_data['complaint_details']->complainerName?>
                        </div>
                        <div class="complaint-complaint-message" style="margin-top: 20px;">
                            Message: <?php echo $other_data['complaint_details']->message?>
                        </div>
                    </div>

                    <div class="slot-area">
                        <p style="color: gray; font-size: 14px;">Real-Time Availability</p>
                        <div class="slot-cards">
                            <div class="slot-card">
                                <div class="slot-card-title">
                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/motor-sports.png" alt="" class="vehicle-image">
                                </div>
                                <div class="slot-card-value"><?php echo $data->car?></div>
                            </div>
                            <div class="slot-card">
                                <div class="slot-card-title">
                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/car-c.png" alt="" class="vehicle-image">
                                </div>
                                <div class="slot-card-value"><?php echo $data->bike?></div>
                            </div>
                            <div class="slot-card">
                                <div class="slot-card-title">
                                    <img style="width: 30px;" src="<?php echo URLROOT ?>/images/tuk-tuk.png" alt="" class="vehicle-image">
                                </div>
                                <div class="slot-card-value"><?php echo $data->threeWheel?></div>
                            </div>
                        </div>
                    </div>

                    <div class="location-area">
                        <div class="map-section">
                            <div id="map" style="border-radius: 20px 0 0 20px; height: 100%"></div>
                        </div>
                        <div class="address-section">
                            <div class="address">
                                <div style="display: grid">
                                    <div style="color: #6b6b6b; font-size: 15px; width: 100%;">Address</div>
                                    <div style="color: #000000; font-size: 15px; width: 100%; margin-top: 5px"><?php echo ucwords($data->address)?>,<br /><?php echo ucwords($data->street)?>, <?php echo ucwords($data->city)?></div>
                                </div>
                            </div>
                            <div class="contact-no">
                                <div style="display: grid">
                                    <div style="color: #6b6b6b; font-size: 15px; width: 100%;">Contact Number</div>
                                    <div style="color: #000000; font-size: 15px; width: 100%; margin-top: 5px"><?php echo ucwords($data->contactNo)?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br><br>
                </div>
            </div>
        </div>
    </section>
</main>


<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GMAP;?>"></script>
<script>
    function initMap() {
        // Specify the latitude and longitude coordinates of the location
        var latitude = <?php echo $data->latitude?>;
        var longitude = <?php echo $data->longitude?>;

        // Create a new map centered on the location
        var location = { lat: latitude, lng: longitude };
        var map = new google.maps.Map(document.getElementById('map'), {
            center: location,
            zoom: 15
        });

        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: '<?php echo $data->name?>'
        });
    }

    // Initialize the map when the page loads
    initMap();
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const requestForm = document.getElementById("request-form");

        if (requestForm) {
            const submitButton = requestForm.querySelector("button[type='submit']");

            if (submitButton) {
                submitButton.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent the form from submitting

                    // Use SweetAlert for confirmation
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are going to accept this registration land request.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f8c806',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, accept it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            requestForm.submit();
                        }
                    });
                });
            }
        }
    });


    document.addEventListener("DOMContentLoaded", function () {
        const requestForm = document.getElementById("request-form-2");

        if (requestForm) {
            const submitButton = requestForm.querySelector("button[type='submit']");

            if (submitButton) {
                submitButton.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent the form from submitting

                    // Use SweetAlert for confirmation
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are going to reject this registration land request.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f8c806',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, reject it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            requestForm.submit();
                        }
                    });
                });
            }
        }
    });
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>

