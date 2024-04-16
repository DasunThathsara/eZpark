<?php require APPROOT . '/views/inc/header.php'; ?>

<!--  TOP NAVIGATION  -->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'reports';
require APPROOT . '/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1 class="title">Reports</h1>
            <!-- <p class="subtitle"  style="margin-bottom:10px">Generate a report for your land</p> -->


            <div class="report-container">
                <div class="report-img">
                    <img src="<?php echo URLROOT ?>/images/report-pic.png" alt="logo">
                    <p class="text-heading">Select Date Range</p>
                    <input type="date" name="start_date" id="start_date" onchange="selectDate()" />
                    -
                    <input type="date" name="end_date" id="end_date" onchange="selectDate()" />

                    <div class="gen-area">
                        <p class="text-warning" id="message"></p>
                        <!-- <button class="gen-btn" id="gen" onclick="generatePDF()"><a class="gen-btn" href="<?php echo URLROOT ?>/report/viewReport/2"></a>Generate Report</button> -->
                        <button class="gen-btn" id="gen" onclick="generatePDF()">Generate Report</button>
                        <div class="dropdown">
                            <button class="dropbtn">Select Parking</button>
                            <div class="dropdown-content">
                                <?php
                                
                                foreach ($data['lands'] as $key => $value) {
                                    ?>


                                    <p onclick="selectPark(<?= $value->id ?>)">
                                        
                                        <?= $value->name ?> 
                                        <!-- - <?= $value->id ?> -->
                                    </p>

                                    <?php
                                } ?>

                            </div>
                        </div>
                        
                        <button class="view-btn" id="view" onclick="viewPDF()" style="display: none;">View</button>
                        <button class="download-btn" id="down" onclick="downloadBlob()"
                            style="display: none;">Download</button>
                    </div>
                </div>

                <div class="report-des">
                    <h1 class="title">How to Generate</h1>
                    <h1 class="title" style="color: #626262; transform: translateY(-35px)">Your Report</h1>

                    <div class="report-ins">
                        <ul>
                            <li>Select the parking you want to get the Report</li>
                            <li>Select the preferred Date Range for the Report</li>
                            <li>Click “Generate Report”</li>
                            <li>Report will be Automatically Downloaded</li>
                            <li>Use Adobe PDF Viewer or any other suitable software to view the report</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://unpkg.com/jspdf-invoice-template@latest/dist/index.js" type="text/javascript"></script>

<script>

    let lands = [];
    var backendData = <?php echo json_encode($data['lands']); ?>;

    lands = backendData.map(land => {
        return { id: land.id, name: land.name, car: land.car, bike: land.bike, threeWheel: land.threeWheel, city: land.city};
    });

    console.log(lands)



    //pdf generate code
    //Generate pdf
    var pdfObject; //outputType: jsPDFInvoiceTemplate.OutputType.Blob,

    
    landId = null;
    genarateData = null;
    data_length = null;  
    var sDate = null;
    var eDate = null;
    var total = null;
                             


    function selectPark(chooseId) {

        landId  = chooseId;
        return landId;
        // console.log(landId);
    }

    function selectDate() {
        sDate = document.getElementById('start_date').value;
        eDate = document.getElementById('end_date').value;
        
    
    }

   
    

    
    /* generate pdf */
    
    function generatePDF() {
        


        $.ajax({
            url: '<?php echo URLROOT ?>/report/viewReport',
            method: 'POST',
            data: { landID: landId ,startDate : sDate , endDate:eDate},
            success: function (response) {
                res =JSON.parse(response);
        
                genarateData = res;
                data_length = genarateData.length;
                console.log(landId);
                console.log(sDate);
                console.log(eDate);
                console.log("genarateData:", genarateData);
                

                
                for (let i = 0; i < data_length; i++) {
                    total += parseFloat(genarateData[i]['cost']);
                }
                
                
                
                const selectId = document.getElementsByClassName("dropdown-content");
                

                var props = {
                    outputType: jsPDFInvoiceTemplate.OutputType.Blob,
                    returnJsPDFDocObject: true,
                    fileName: "Invoice 2024",
                    orientationLandscape: false,
                    compress: true,
                    logo: {
                    src: "<?php echo URLROOT ?>/images/logo.png",
                    type: 'PNG', //optional, when src= data:uri (nodejs case)
                    width: 53.33, //aspect ratio = width/height
                    height: 26.66,
                    margin: {
                        top: 0, //negative or positive num, from the current position
                        left: 0 //negative or positive num, from the current position
                    }
                    },
                    stamp: {
                    inAllPages: true, //by default = false, just in the last page
                    src: "https://raw.githubusercontent.com/edisonneza/jspdf-invoice-template/demo/images/qr_code.jpg",
                    type: 'JPG', //optional, when src= data:uri (nodejs case)
                    width: 20, //aspect ratio = width/height
                    height: 20,
                    margin: {
                        top: 0, //negative or positive num, from the current position
                        left: 0 //negative or positive num, from the current position
                    }
                    },
                    business: {
                        name: "eZpark",
                        address: "Sri Lanka",
                        phone: "0776202215",
                        email: "dasun.thathsara.sri@gmail.com",
                        website: "www.ezpark.lk",
                    },
                    contact: {
                        label: "  ",
                        name: "Revenue Report",
                        address: "Land ID :" + genarateData[0]['landID'].toString(),
                        phone: "  ",
                        email: " ",
                        otherInfo: "   ",
                    },
                    invoice: {
                        label: "",
                        // num: 19,
                        invDate: "Payment Date: 01/01/2021 18:12",
                        invGenDate: "Invoice Date: 02/02/2021 10:17",
                        headerBorder: false,
                        tableBodyBorder: false,
                        header: [
                            {
                                title: "#",
                                style: {
                                width: 10,
                                height: 20,
                                backgroundColor: '#f2f2f2', // Background color for header cell
                                textAlign: 'center', // Center align text
                                fontWeight: 'bold' // Bold font weight for header cell
                            }
                            },
                            
                            {
                                title: "Driver ID",
                                style: {
                                width: 20,
                                height: 20,
                                backgroundColor: '#f2f2f2', // Background color for header cell
                                textAlign: 'center', // Center align text
                                fontWeight: 'bold' // Bold font weight for header cell
                            }
                            },
                            { 
                                title: "Vehicle Type",
                                style: {
                                width: 25,
                                height: 20,
                                backgroundColor: '#f2f2f2', // Background color for header cell
                                textAlign: 'center', // Center align text
                                fontWeight: 'bold' // Bold font weight for header cell
                            }
                            },
                            { 
                                title: "Start Time",
                                style: {
                                width: 40,
                                height: 20,
                                backgroundColor: '#f2f2f2', // Background color for header cell
                                textAlign: 'center', // Center align text
                                fontWeight: 'bold' // Bold font weight for header cell
                            }
                            },
                            { 
                                title: "End Time",
                                style: {
                                width: 40,
                                height: 20,
                                backgroundColor: '#f2f2f2', // Background color for header cell
                                textAlign: 'center', // Center align text
                                fontWeight: 'bold' // Bold font weight for header cell
                            }
                            },
                            { 
                                title: "Total time",
                                style: {
                                width: 30,
                                height: 20,
                                backgroundColor: '#f2f2f2', // Background color for header cell
                                textAlign: 'center', // Center align text
                                fontWeight: 'bold' // Bold font weight for header cell
                            }
                            },
                            { 
                                title: "Charge",
                                style: {
                                width: 30,
                                height: 20,
                                backgroundColor: '#f2f2f2', // Background color for header cell
                                textAlign: 'center', // Center align text
                                fontWeight: 'bold' // Bold font weight for header cell
                            }
                            },
                            // { 
                            //     title: "Payement\nStatus",
                            //     style: {
                            //     width: 20,
                            //     height: 20,
                            //     backgroundColor: '#f2f2f2', // Background color for header cell
                            //     textAlign: 'center', // Center align text
                            //     fontWeight: 'bold' // Bold font weight for header cell
                            // }
                            // }
                        ],
                        table:Array.from(Array(data_length), (item, index) => ([
                            index + 1,
                            genarateData[index]['driverID'],
                            genarateData[index]['vehicleType'],
                            genarateData[index]['startTime'],
                            genarateData[index]['endTime'],
                            // (genarateData[index]['status'] === 0) ? 'IN' : 'OUT' ,
                            genarateData[index]['endTime'] - genarateData[index]['startTime'],
                            genarateData[index]['cost'],
                            // (genarateData[index]['paymentStatus'] === 0) ? 'payed' : 'unpaid' 
                          
                        ])),
                          

                            
                        style: {
                            margin: { top: 30 },
                            tableWidth: 'auto',
                            headerRowHeight: 30,
                            bodyRowHeight: 20,
                            fontSize: 10,
                            cellPadding: 5,
                            textAlign: 'center',
                            backgroundColor:'red'
                        },
                        
                        
                        additionalRows: [{
                            col1: 'Total:',
                            col2: total.toString()+'.00',
                            col3: 'ALL',
                            style: {
                                fontSize: 14 //optional, default 12
                            }
                        },
                        {
                            col1: 'VAT:',
                            col2: '20',
                            col3: '%',
                            style: {
                                fontSize: 10 //optional, default 12
                            }
                        },
                        {
                            col1: 'SubTotal:',
                            col2: (total * 0.8).toString()+'.00' ,
                            col3: 'ALL',
                            style: {
                                fontSize: 10 //optional, default 12
                            }
                        }],
                        // invDescLabel: "Invoice Note",
                        // invDesc: "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.",
                    },
                    footer: {
                        text: "The invoice is created on a computer and is valid without the signature and stamp.",
                    },
                    pageEnable: true,
                    pageLabel: "Page ",
                };                
                pdfObject = jsPDFInvoiceTemplate.default(props);
                console.log("Object generated: ", pdfObject);
            },
            error: function (xhr, status, error) {
            console.error("AJAX error:", xhr.responseText);
            }
        });
        document.getElementById('message').textContent = 'Your report is generated!';
        document.getElementById('gen').style.display = 'none';
        document.getElementById('view').style.display = 'inline-block';
        document.getElementById('down').style.display = 'inline-block';
    }

    /* view pdf */
    function viewPDF() {
        console.log("genarateData:", genarateData);
        console.log(pdfObject);
        if (!pdfObject) {
            return console.log('No PDF Object');
        }

        var fileURL = URL.createObjectURL(pdfObject.blob);
        window.open(fileURL, '_blank');
    }

    /* download pdf */
    function downloadBlob() {
        if (!pdfObject) {
            return console.log('No PDF Object');
        }

        const fileURL = URL.createObjectURL(pdfObject.blob);
        const link = document.createElement('a');
        link.href = fileURL;
        link.download = "Invoice" + new Date() + ".pdf";
        link.click();
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
 
<?php require APPROOT . '/views/inc/footer.php'; ?>