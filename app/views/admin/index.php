<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="300">
    <title><?php echo SITENAME ?></title>

    <!-- External CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/style.css">

    <!-- External js -->
    <script src="<?php echo URLROOT ?>/js/script.js" defer></script>

    <!-- AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>
<body>

<!-- Loading screen -->
<div class="loader-wrapper">
    <div class="logo-container">
        <img src="<?php echo URLROOT ?>/images/logo.png" alt="">
    </div>
    <div class="loader"></div>
</div>

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
            <h1>Admin</h1>

            <div class="cards">
                <!-- Card 1 -->
                <a class="card-link" href="<?php echo URLROOT ?>/admin/viewRegistrationRequests">
                    <div class="card">
                        <div class="row">
                            <div class="left-col">
                                <div class="sub-row">
                                    <div class="top-row">
                                        <img src="<?php echo URLROOT ?>/images/parking.svg" alt="">
                                    </div>
                                    <div class="bottom-row"><?php echo $data['request_count'] ?></div>
                                </div>
                            </div>
                            <div class="right-col">Registration Requests</div>
                        </div>
                    </div>
                </a>

                <!-- Card 2 -->
                <a class="card-link" href="<?php echo URLROOT ?>/parkingOwner/parkingCapacity">
                    <div class="card">
                        <div class="row">
                            <div class="left-col">
                                <div class="sub-row">
                                    <div class="top-row">
                                        <img src="<?php echo URLROOT ?>/images/vehicle.svg" alt="">
                                    </div>
                                    <div class="bottom-row">20</div>
                                </div>
                            </div>
                            <div class="right-col">Complaints</div>
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
                                        <img src="<?php echo URLROOT ?>/images/dollar.svg" alt="">
                                    </div>
                                    <div class="bottom-row"></div>
                                </div>
                            </div>
                            <div class="right-col">Total Income</div>
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

        <div class="side-cards">
            <div class="close-btn" onclick="closeRightCard()">X</div>
            <h2>Recent Transaction</h2>

            <p><span>&#9632;</span>Today</p>

            <!--
            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Nolimit</div>
                <div class="transaction-type in">In</div>
            </div>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Keels</div>
                <div class="transaction-type out">Out</div>
            </div>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Nolimit</div>
                <div class="transaction-type in">In</div>
            </div>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Keels</div>
                <div class="transaction-type out">Out</div>
            </div>

            <p><span>&#9632;</span>Yesterday</p>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Nolimit</div>
                <div class="transaction-type in">In</div>
            </div>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Keels</div>
                <div class="transaction-type out">Out</div>
            </div>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Nolimit</div>
                <div class="transaction-type in">In</div>
            </div>

            <div class="side-card">
                <div class="date-time">2023.11.22</div>
                <div class="parking">Keels</div>
                <div class="transaction-type out">Out</div>
            </div>
                    -->
            <?php foreach ($data['all_today_total_transactions'] as $transaction): ?>
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
                    <div class="vehicle"><?php echo $transaction->name?></div>
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
            fetch('<?php echo URLROOT?>/Admin/index')
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
            fetch('<?php echo URLROOT?>/Admin/index') // Update URL to your controller method
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
 



    const xValues = ['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov', 'dec'];
    const yValues = [<?php echo $data['all_total_income_distribution']->January?>, <?php echo $data['all_total_income_distribution']->February?>, <?php echo $data['all_total_income_distribution']->March?>, <?php echo $data['all_total_income_distribution']->April?>, <?php echo $data['all_total_income_distribution']->May?>, <?php echo $data['all_total_income_distribution']->June?>, <?php echo $data['all_total_income_distribution']->July?>, <?php echo $data['all_total_income_distribution']->August?>, <?php echo $data['all_total_income_distribution']->September?>, <?php echo $data['all_total_income_distribution']->October?>, <?php echo $data['all_total_income_distribution']->November?>, <?php echo $data['all_total_income_distribution']->December?>];

    var xValues2 = ['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov', 'dec'];
    var yValues2 = [<?php echo $data['all_total_vehicle_distribution']->January?>, <?php echo $data['all_total_vehicle_distribution']->February?>, <?php echo $data['all_total_vehicle_distribution']->March?>, <?php echo $data['all_total_vehicle_distribution']->April?>, <?php echo $data['all_total_vehicle_distribution']->May?>, <?php echo $data['all_total_vehicle_distribution']->June?>, <?php echo $data['all_total_vehicle_distribution']->July?>, <?php echo $data['all_total_vehicle_distribution']->August?>, <?php echo $data['all_total_vehicle_distribution']->September?>, <?php echo $data['all_total_vehicle_distribution']->October?>, <?php echo $data['all_total_vehicle_distribution']->November?>, <?php echo $data['all_total_vehicle_distribution']->December?>];
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
            //scales: {
                //yAxes: [{ticks: {min: 6, max:16}}],
                title: {
                    display: true,
                    text: "Income Distribution"
            }
        }
    });

    // Create a new chart with a different id for the second canvas
    new Chart("lineChart2", {
        type: "bar",
        data: {
            labels: xValues2,
            datasets: [{
                backgroundColor: barColors,
                data: yValues2
            }]
        },
        options: {
            legend: {display: false},
            title: {
                display: true,
                text: "Vehicle Distribution"
            }
        }
    });
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>