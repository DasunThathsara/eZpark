<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<!-- <?php require APPROOT.'/views/inc/components/topnavbar.php'; ?> -->

<!--  SIDE NAVIGATION  -->
<?php
$section = 'dashboard';
require APPROOT.'/views/inc/components/sidenavbar.php';?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1 id="requestheader">Reviews And Complaints</h1>

            <br><br>

            <div class="table-container" id="tcontainer">   

            <h1 id="ttitle">Reviews</h1>
            <?php if (sizeof($other_data) == 1) {?> 
            <div class="emptyVehicle">This land has no any reviews</div>
            <?php }
            else {?>
                    <table class="requesttable" >
                        <tr>
                            <th >
                                <div class="content" id="theader">
                                    <div class="left" style="width:35%">
                                        Review Name
                                    </div>
                                    <div class="left" style="width:33%; padding-left:5px">
                                        Message
                                    </div>
                                    <div class="left" style="width:33%; padding-left:5px">
                                        Date & Time
                                    </div>
                                </div>
                            </th>
                        </tr>

                        <?php for ($i = 0; $i < sizeof($other_data); $i++){ ?>
                            <tr>
                                <td>
                                    <div class="content" id="content">
                                        <div class="left" style="width:33%">
                                            <?php echo $other_data[$i]->reviewerName ?>
                                        </div>
                                        <div class="left" style="width:33%">
                                            <?php echo $other_data[$i]->Message ?>
                                        </div>
                                        <div class="left" style="width:33%">
                                            <?php echo $other_data[$i]->date ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
            <?php }?>

            <?php if (sizeof($data) == 0) {?>
            <div class="emptyVehicle">This land has no any complaints</div>
            <?php }
            else {?>
                    <h1 id="ttitle">Complaints</h1>
                    <table class="requesttable" >
                        <tr>
                            <th >
                                <div class="content" id="theader">
                                    <div class="left" style="width:35%">
                                        Review Name
                                    </div>
                                    <div class="left" style="width:33%; padding-left:15px">
                                        Message
                                    </div>
                                    <div class="left" style="width:33%; padding-left:15px">
                                        Data & Time
                                    </div>
                                </div>
                            </th>
                        </tr>

                        <?php for ($i = 0; $i < sizeof($data); $i++){ ?>
                            <tr>
                                <td>
                                    <div class="content" id="content">
                                        <div class="left" style="width:33%">
                                            <?php echo $data[$i]->complainerName ?>
                                        </div>
                                        <div class="left" style="width:33%">
                                            <?php echo $data[$i]->message ?>
                                        </div>
                                        <div class="left" style="width:33%">
                                            <?php echo $data[$i]->date ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                
                <?php }?>
            </div>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
