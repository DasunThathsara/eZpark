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
            <h1>Merchandiser Dashboard</h1>
            <div class="cards">
                <!-- Card 1 -->
                <div class="card">
                    <a href="#">
                        <table>
                            <tr>
                                <th>
                                    <img src="<?php echo URLROOT ?>/images/vehicle.svg" alt="">
                                </th>
                                <td>
                                    <p>0</p>
                                    <p>Today's Vehicle Entries</p>
                                </td>
                            </tr>
                        </table>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="card">
                    <a href="#">
                        <table>
                            <tr>
                                <th>
                                    <img src="<?php echo URLROOT ?>/images/vehicle.svg" alt="">
                                </th>
                                <td>
                                    <p>0</p>
                                    <p>Yesterday's Vehicle Entries</p>
                                </td>
                            </tr>
                        </table>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>