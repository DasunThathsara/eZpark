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
            <h1 class="title">Make Reservation</h1>
            <p class="subtitle">Make reservation for the parking</p>

            <div class="view-parking-container">

                <div class="parking-details">
                    <div class="reservation-list" id="reservation-list">
                    </div>
                    <form id="reservation-form">
                        <input type="text" name="landID" hidden value="<?php echo $data['landID']?>" required>

                        <br>

                        <select name="vehicleType" id="vehicleType" class="district" required>
                            <option value="" disabled selected hidden>Select Vehicle Type</option>
                            <option value="Car">Car</option>
                            <option value="bike">Bike</option>
                            <option value="threeWheel">Three Wheel</option>
                        </select>

                        <br /><br />

                        <input type="date" name="reservationDate" id="reservationDate" required>

                        <br /><br />
                        <input type="submit" value="Find Reservations" style="width: calc(100% - 40px)">

                        <br /><br /><br /><br /><br />
                    </form>

                    <form action="<?php echo URLROOT?>/driver/makeReservation" method="post" style="border-top: 1px dotted rgba(0,0,0,0.27); width: calc(100% - 40px); padding-top: 40px">

                        <?php if (!empty($data['err'])){?>
                            <div class="error-msg">
                                <span class="form-invalid"><?php echo $data["err"] ?></span>
                            </div>
                        <?php } ?>

                        <input type="text" name="landID" hidden value="<?php echo $data['landID']?>" required>

                        <div class="reservation-title" style="font-size: 25px; color: #818181">
                            Make Reservation
                        </div>

                        <br><br>

                        <select name="vehicleNumber" id="vehicleNumber" class="district" required>
                            <option value="" disabled selected hidden>Select Vehicle</option>
                            <?php foreach($data['vehicles'] as $vehicle){?>
                                <option value="<?php echo $vehicle->vehicleNumber?>" <?php if ( $data['vehicleNumber'] == $vehicle->vehicleNumber) echo 'selected' ?>><?php echo $vehicle->vehicleNumber?></option>
                            <?php }?>
                        </select>

                        <br><br>

                        Start Date and Time:
                        <input type="date" name="reservationSDate" id="reservationSDate" required value="<?php echo $data['startDate']?>">
                        <input type="time" name="reservationSTime" id="reservationSTime" required value="<?php echo $data['startTime']?>">

                        <br><br>

                        End Date and Time:
                        <input type="date" name="reservationEDate" id="reservationEDate" required value="<?php echo $data['endDate']?>">
                        <input type="time" name="reservationETime" id="reservationETime" required value="<?php echo $data['endTime']?>">


                        <br><br>
                        <input type="submit" value="Make Reservation">
                        <br><br>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    document.getElementById('reservation-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Serialize form data
        const formData = new FormData(this);

        // Send POST request using fetch
        fetch('<?php echo URLROOT?>/driver/findReservation', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Update reservation list
                updateReservationList(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    // Function to update reservation list based on returned data
    function updateReservationList(data) {
        console.log(data);
        // Assuming 'reservation' property exists in the returned data
        const reservationListElement = document.getElementById('reservation-list');
        reservationListElement.innerHTML = ''; // Clear previous content
        if (data.reservations) {
            const reservationElement = document.createElement('div');
            reservationElement.classList.add('reservation');
            reservationElement.innerHTML = `
                    <div id="reservation-title" style="padding-top: 20px; padding-bottom: 10px;">Reservation list</div>
                `;
            reservationListElement.appendChild(reservationElement);

            let count = 1;

            data.reservations.forEach(reservation => {
                const reservationElement = document.createElement('div');
                reservationElement.classList.add('reservation');
                reservationElement.innerHTML = `
                    <div class="reservation" style="width: calc(100% - 60px); background-color: rgba(128,128,128,0.16); display: flex; justify-content: space-between; padding: 10px; border-radius: 10px; margin-top: 5px;">
                        <div>Reservation: ${count}</div>
                        <div>Start Time: ${reservation.startTime}</div>
                        <div>End Time: ${reservation.expectedEndTime}</div>
                    </div>
                `;
                reservationListElement.appendChild(reservationElement);

                count += 1;
            });
        } else {
            reservationListElement.textContent = 'No reservations';
        }
    }
</script>



<?php require APPROOT.'/views/inc/footer.php'; ?>
