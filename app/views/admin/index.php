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
            <h1>Dashboard</h1>

            <div class="cards">
                <!-- Card 1 -->
                <a class="card-link" href="<?php echo URLROOT ?>/parkingOwner/lands">
                    <div class="card">
                        <div class="row">
                            <div class="left-col">
                                <div class="sub-row">
                                    <div class="top-row">
                                        <img src="<?php echo URLROOT ?>/images/parking.svg" alt="">
                                    </div>
                                    <div class="bottom-row"></div>
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
        </div>
    </section>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script>
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


    // Side card close button
    function closeRightCard(){
        var screenWidth = window.innerWidth;
        var element1, element2, element3, element4;

        if (screenWidth <= 720){
            element1 = document.querySelector('.side-cards');
            element1.classList.toggle("side-cards-active");

            element2 = document.querySelector('.open-side-cards-btn');
            element2.classList.toggle("open-side-cards-btn-hide");
        }
        else {
            element1 = document.querySelector('.side-cards');
            element1.classList.toggle("side-cards-hide");

            element2 = document.querySelector('.cards');
            element2.classList.toggle("cards-active");

            element3 = document.querySelector('.charts');
            element3.classList.toggle("charts-active");

            element4 = document.querySelector('.open-side-cards-btn');
            element4.classList.toggle("open-side-cards-btn-active");
        }
    }
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>