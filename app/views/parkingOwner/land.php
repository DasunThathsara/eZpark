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
                        <?php for ($i = 0; $i < sizeof($other_data) - 1; $i++) {
                            if($data['id'] == $other_data[$i]->id){
                                $parking_index = $i;
                                continue;
                            }?>     
                            <a href="<?php echo URLROOT ?>/parkingOwner/gotoLand/<?php echo $other_data[$i]->id ?>/<?php echo $other_data[$i]->name ?>"><?php echo $other_data[$i]->name ?></a>  
                        <?php } ?>
                    </div>
                </div>

                <!-- Toggle Button -->
                <label class="switch">
                    <input type="checkbox" id="toggleButton" checked>
                    <span class="slider round"></span>
                </label>

                <!-- Card Set -->
                <div class="cards">
                    <!-- Card 1 -->
                    <a class="card-link" href="<?php echo URLROOT ?>/deeds/<?php echo $other_data[$parking_index]->deed?>">
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
                                        <div class="bottom-row"><?php echo $data['land_count'] ?></div>
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
                                <div style="transform: translateY(-20px)" class="right-col">
                                    <p style="font-size: 15px">Monthly Income</p>
                                    <h3 style="color: rgba(0,0,0,0.62); font-size: 20px">Rs. 100000</h3>
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
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#toggleButton').change(function () {
                var isChecked = $(this).prop('checked');
                console.log("Checkbox is checked: " + isChecked);

                $.ajax({
                    url: '<?php echo URLROOT?>/land/changeAvailability/<?php echo $data["id"]?>',
                    method: 'GET',
                    data: { isChecked: isChecked },
                    success: function (response) {
                        console.log("AJAX success:", response);
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX error:", xhr.responseText);
                    }
                });
            });
        });
    </script>


<?php require APPROOT.'/views/inc/footer.php'; ?>