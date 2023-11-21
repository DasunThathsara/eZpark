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

            <div class="dropdown">
                <button class="dropbtn">Select Parking</button>
                <div class="dropdown-content">
                    <?php for ($i = 0; $i < sizeof($other_data); $i++) {?>
                        <a href="<?php echo URLROOT ?>/parkingOwner/gotoLand/<?php echo $other_data[$i]->id ?>/<?php echo $other_data[$i]->name ?>"><?php echo $other_data[$i]->name ?></a>
                    <?php } ?>
                </div>
            </div>

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
                                    <div class="bottom-row"><?php echo $data['land_count'] ?></div>
                                </div>
                            </div>
                            <div class="right-col">Total Lands</div>
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
                            <div class="right-col">Total Capacity</div>
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
                <link href="https://unpkg.com/singledivui/dist/singledivui.min.css" rel="stylesheet" />
                <script src="https://unpkg.com/singledivui/dist/singledivui.min.js"></script>

                <h1>Analysis</h1>

                <div class="row">
                    <div class="cell">
                        <h2>Monthly Income</h2>
                        <div id="chart1"></div>
                    </div>
                    <div class="cell">
                        <h2>Income Distribution</h2>
                        <div id="chart2"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="side-cards">
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

    <script>
        const { Chart } = SingleDivUI;

        const options = {
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                series: {
                    points: [15, 9, 25, 18, 31, 25]
                }
            },
            height: 200,
            width: 400
        };

        new Chart('#chart1',  {
            type: 'line',
            ...options
        });

        new Chart('#chart2',  {
            type: 'bar',
            ...options
        });

        new Chart('#chart3',  {
            type: 'area',
            ...options
        });
    </script>

<?php require APPROOT.'/views/inc/footer.php'; ?>