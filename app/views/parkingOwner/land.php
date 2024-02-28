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

                <!-- Dropdown Menu -->
                <div class="dropdown">
                    <button class="dropbtn">Select Parking</button>
                    <div class="dropdown-content">
                    <?php $parking_index = 0?>
                    <a href="<?php echo URLROOT ?>/parkingOwner/index">Main Dashboard</a>
                        <?php for ($i = 0; $i < sizeof($other_data['lands']) - 1; $i++) {
                            if($data['id'] == $other_data['lands'][$i]->id){
                                $parking_index = $i;
                                continue;
                            }?>     
                            <a href="<?php echo URLROOT ?>/parkingOwner/gotoLand/<?php echo $other_data['lands'][$i]->id ?>"><?php echo $other_data['lands'][$i]->name ?></a>
                        <?php } ?>
                    </div>
                </div>

                <!-- Toggle Button -->
                <div class="toggle-title">
                    Availability
                </div>

                <label class="switch">
                    <?php if($data['availability'] == 1){?>
                        <input type="checkbox" id="toggleButton" checked>
                    <?php } else {?>
                        <input type="checkbox" id="toggleButton">
                    <?php }?>
                    <span class="slider round"></span>
                </label>

                <!-- Card Set -->
                <div class="cards">
                    <!-- Card 1 -->
                    <a class="card-link" href="<?php echo URLROOT ?>/deeds/<?php echo $other_data['lands'][$parking_index]->deed?>">
                        <div class="card">
                            <div class="row">
                                <div class="left-col">
                                    <div class="sub-row">
                                        <div class="top-row">
                                            <img style="transform: translateY(7px)" src="<?php echo URLROOT ?>/images/deed.svg" alt="">
                                        </div>
                                        <div class="bottom-row"></div>
                                    </div>
                                </div>
                                <div style="transform: translateY(5px)" class="right-col">Deed</div>
                            </div>
                        </div>
                    </a>

                    <!-- Card 2 -->
                    <a class="card-link" href="<?php echo URLROOT ?>/LandCapacity/viewCapacity/<?php echo $data['id']?>">
                        <div class="card">
                            <div class="row">
                                <div class="left-col">
                                    <div class="sub-row">
                                        <div class="top-row">
                                            <img src="<?php echo URLROOT ?>/images/vehicle.svg" alt="">
                                        </div>
                                        <div class="bottom-row"><?php echo $data['capacity'] ?></div>
                                    </div>
                                </div>
                                <div class="right-col">Parking<br />Capacity</div>
                            </div>
                        </div>
                    </a>

                    <!-- Card 3 -->
                    <a class="card-link" href="<?php echo URLROOT ?>/land/prices/<?php echo $data['id'] ?>">
                        <div class="card">
                            <div class="row">
                                <div class="left-col">
                                    <div class="sub-row">
                                        <div class="top-row">
                                        <img style="transform: translateY(10px)" src="<?php echo URLROOT ?>/images/price.svg" alt="">
                                        </div>
                                        <div class="bottom-row"></div>
                                    </div>
                                </div>
                                <div style="transform: translateY(7px)" class="right-col">Price Rate</div>
                            </div>
                        </div>
                    </a>

                    <!-- Card 4 -->
                    <a class="card-link" href="<?php echo URLROOT ?>/package/viewPackages/<?php echo $data['id'] ?>">
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

                    <!-- Card 5 -->
                    <a class="card-link" href="<?php echo URLROOT ?>/parkingOwner/securities/<?php echo $data['id'] ?>">
                        <div class="card">
                            <div class="row">
                                <div class="left-col">
                                    <div class="sub-row">
                                        <div class="top-row">
                                            <img src="<?php echo URLROOT ?>/images/security-officer.svg" alt="">
                                        </div>
                                        <div class="bottom-row"><?php echo $data['security_count'] ?></div>
                                    </div>
                                </div>
                                <div class="right-col">Security<br />Officers</div>
                            </div>
                        </div>
                    </a>

                    <!-- Card 6 -->
                    <a class="card-link" href="">
                        <div class="card">
                            <div class="row">
                                <div class="left-col">
                                    <div class="sub-row">
                                        <div class="top-row">
                                            <img style="transform: translateY(5px)" src="<?php echo URLROOT ?>/images/dollar.svg" alt="">
                                        </div>
                                        <div class="bottom-row"></div>
                                    </div>
                                </div>
                                <div style="transform: translateY(-20px)" class="right-col" id="monthly-income">
                                    <p style="font-size: 15px">Monthly Income</p>
                                    <h3 style="color: rgba(0,0,0,0.62); font-size: 20px">Rs. <?php echo $data['total_income']?></h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="charts">
                    <h2>Analysis</h2>
                    <div class="chart-container">
                        <div class="chart">
                            <canvas id="lineChart1" style="width:100%;max-width:600px"></canvas>
                        </div>
                        <div class="chart">
                            <canvas id="lineChart2" style="width:100%;max-width:600px"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="open-side-cards-btn" onclick="closeRightCard()">View Transaction</div>

            <div id="side-cards-container" class="side-cards">
                <div class="close-btn" onclick="closeRightCard()">X</div>
                <h2>Recent Transaction</h2>
                <p><span>&#9632;</span>Today</p>
                <?php foreach ($data['today_transactions'] as $transaction): ?>
                    <div class="side-card">
                        <div class="date-time">
                            <?php
                            $dateTime = new DateTime($transaction->transactionTime);
                            $time = $dateTime->format('H:i:s');
                            echo $time;
                            ?>
                        </div>
                        <div class="vehicle-type">
                            <?php if($transaction->vehicleType == 'bike'): ?>
                                <img style="width: 30px;" src="<?php echo URLROOT ?>/images/motor-sports.png" alt="">
                            <?php elseif($transaction->vehicleType == 'car'): ?>
                                <img style="width: 30px;" src="<?php echo URLROOT ?>/images/car-c.png" alt="">
                            <?php elseif($transaction->vehicleType == 'threeWheel'): ?>
                                <img style="width: 30px;" src="<?php echo URLROOT ?>/images/tuk-tuk.png" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="vehicle"><?php echo $transaction->vehicleNumber?></div>
                        <?php if($transaction->status == 1): ?>
                            <div class="transaction-type in">In</div>
                        <?php else: ?>
                            <div class="transaction-type out">Out</div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <script>
        // --------------------------------------- Real time update transaction box ---------------------------------------
        function refreshSideCard() {
            // Fetch updated content via AJAX
            fetch('<?php echo URLROOT?>/ParkingOwner/gotoLand/<?php echo $data["id"]?>')
                .then(response => response.text())
                .then(data => {
                    // Replace only the content inside the side-cards container
                    document.getElementById('side-cards-container').innerHTML =
                        document.createRange().createContextualFragment(data).querySelector('.side-cards').innerHTML;
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Refresh every 1 second
        setInterval(refreshSideCard, 1000);


        // --------------------------------------- Real time update income card ---------------------------------------
        function refreshMonthlyIncome() {
            // Fetch updated content via AJAX
            fetch('<?php echo URLROOT?>/ParkingOwner/gotoLand/<?php echo $data["id"]?>') // Update URL to your controller method
                .then(response => response.text())
                .then(data => {
                    // Extract the monthly income value from the returned data
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const updatedIncome = doc.getElementById('monthly-income').querySelector('h3').textContent;

                    // Update the value inside the h3 tag
                    document.getElementById('monthly-income').querySelector('h3').textContent = updatedIncome;
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Refresh every 1 second
        setInterval(refreshMonthlyIncome, 1000);



        // ---------------------------------------------- Chart.js ----------------------------------------------
        const xValues = ['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov', 'dec'];
        const yValues = [7,8,8,9,9,9,10,11,14,14,15];

        var xValues2 = ["Italy", "France", "Spain", "USA", "Argentina"];
        var yValues2 = [55, 49, 44, 24, 15];
        var barColors = ["red", "green","blue","orange","brown"];

        new Chart("lineChart1", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgb(0,0,0)",
                    borderColor: "rgb(252,212,38)",
                    data: yValues
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                    yAxes: [{ticks: {min: 6, max:16}}],
                }
            }
        });



        // Create a new chart with a different id for the second canvas
        new Chart("lineChart2", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {display: false},
                title: {
                    display: true,
                    text: "Vehicle Count"
                }
            }
        });



        // ---------------------------------------------- Toggle button ----------------------------------------------
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('toggleButton').addEventListener('change', function () {
                var isChecked = this.checked;
                console.log("Checkbox is checked: " + isChecked);

                fetch('<?php echo URLROOT?>/land/changeAvailability/<?php echo $data["id"]?>?isChecked=' + isChecked, {
                    method: 'GET',
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(data => {
                        console.log("Fetch success:", data);
                    })
                    .catch(error => {
                        console.error("Fetch error:", error);
                    });
            });
        });
    </script>

<?php require APPROOT.'/views/inc/footer.php'; ?>