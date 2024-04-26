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
                    <div>
                    <img src="<?php echo URLROOT ?>/images/report-pic.png" alt="logo">
                    </div>
                    
                    <div class="gen-area">
                        <div class="form-input-title">Select Parking:</div>
                        <select name="parking" id="district" required onchange="selectPark(this.value)">
                            <option value="" disabled selected>Select Parking</option>
                            <?php
                            foreach ($data['lands'] as $parking) {
                                ?>
                                <option value="<?= $parking->id ?>"><?= $parking->name ?></option>
                                <?php
                            }
                            ?>
                        </select>

                        <p class="form-input-title">Select Date Range:</p>
                        <input type="date" name="start_date" id="start_date" onchange="selectDate()" style="color: #8a8a8a;"/>
                        -
                        <input type="date" name="end_date" id="end_date" onchange="selectDate()" style="color: #8a8a8a;"/>

                        <p class="text-warning" id="message"></p>
                        <!-- <button class="gen-btn" id="gen" onclick="generatePDF()"><a class="gen-btn" href="<?php echo URLROOT ?>/report/viewReport/2"></a>Generate Report</button> -->
                        <button class="gen-btn" id="gen" onclick="generatePDF()">Generate Report</button>
                        

                        
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
                            <li>Select the preferred date range for the Report</li>
                            <li>Click “Generate Report”</li>
                            <li>Report will be Automatically Generated</li>
                            <li>Use Adobe PDF Viewer or any other suitable software to view the report</li>
                            <li>Click “Download” to download the report</li>
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
    // var total = null;
    var carCount = 0;
    var bikeCount = 0;
    var threeWheelCount = 0;
                             


    function selectPark(chooseId) {

        landId  = chooseId;
        return landId;
        // console.log(landId);
    }


    function selectDate() {
        sDate = document.getElementById('start_date').value;
        eDate = document.getElementById('end_date').value;

        var startDate = new Date(sDate);
        var endDate = new Date(eDate);
        var currentDate = new Date();
        startDate.setHours(0, 0, 0, 0);
        endDate.setHours(0, 0, 0, 0);
        currentDate.setHours(0, 0, 0, 0);

        // Check if start date is greater than current date
        if (startDate > currentDate ) {
            alert("Start date cannot be greater than current date");
            document.getElementById("start_date").value = "";
            return;
        }

        // Check if end date is greater than current date
        if (endDate > currentDate) {
            alert("End date cannot be greater than current date");
            document.getElementById("end_date").value = "";
            return;
        }

        // Check if end date is less than start date
        if (endDate < startDate ) {
            alert("End date cannot be less than start date");
            document.getElementById("end_date").value = "";
            return;
        }
        
    
    }

   
    

    
    /* generate pdf */
    
    function generatePDF() {
        
        if (!landId) {
        alert("Please select a parking");
        return;
        }
        if (!sDate || !eDate) {
            alert("Please select both start date and end date");
            return;
        }

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
                

                
                // for (let i = 0; i < data_length; i++) {
                //     total += parseFloat(genarateData[i]['cost']);
                // }


                for(let i = 0; i < data_length ;i++){
                    if(genarateData[i]['vehicleType'] == 'car'){
                        carCount++;
                    }
                    else if(genarateData[i]['vehicleType'] == 'bike'){
                        bikeCount++;
                    }
                    else if(genarateData[i]['vehicleType'] == 'threeWheel'){
                        threeWheelCount++;
                    }
                }
                
                
                //const selectId = document.getElementsByClassName("dropdown-content");
                
                
                console.log(data_length);
                if (data_length > 0) {
                    document.getElementById('message').textContent = 'Your report is generated!';
                    document.getElementById('gen').style.display = 'none';
                    document.getElementById('view').style.display = 'inline-block';
                    document.getElementById('down').style.display = 'inline-block';
                } 
                else {
                    document.getElementById('message').textContent = 'No vehicles parked during the selected date range';
                    document.getElementById('gen').style.display = 'inline-block';
                    document.getElementById('view').style.display = 'none';
                    document.getElementById('down').style.display = 'none';
                    
                    
                }
  

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
                        invDate: "From Date:" + sDate,
                        invGenDate: "To Date:" + eDate,
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
                                fontWeight: 'bold'// Bold font weight for header cell
                            }
                            },
                            
                            {
                                title: "Vehicle Number ",
                                style: {
                                width: 35,
                                height: 20,
                                backgroundColor: '#f2f2f2', // Background color for header cell
                                textAlign: 'center', // Center align text
                                fontWeight: 'bold' // Bold font weight for header cell
                            }
                            },
                            { 
                                title: "Vehicle Type",
                                style: {
                                width: 30,
                                height: 20,
                                backgroundColor: '#f2f2f2', // Background color for header cell
                                textAlign: 'center', // Center align text
                                fontWeight: 'bold' // Bold font weight for header cell
                            }
                            },
                            { 
                                title: "Arrival Time",
                                style: {
                                width: 45,
                                height: 20,
                                backgroundColor: '#f2f2f2', // Background color for header cell
                                textAlign: 'center', // Center align text
                                fontWeight: 'bold' // Bold font weight for header cell
                            }
                            },
                            { 
                                title: "Departure Time",
                                style: {
                                width: 45,
                                height: 20,
                                backgroundColor: '#f2f2f2', // Background color for header cell
                                textAlign: 'center', // Center align text
                                fontWeight: 'bold' // Bold font weight for header cell
                            }
                            },
                            { 
                                title: "Total time ",
                                style: {
                                width: 30,
                                height: 20,
                                backgroundColor: '#f2f2f2', // Background color for header cell
                                textAlign: 'center', // Center align text
                                fontWeight: 'bold' // Bold font weight for header cell
                            }
                            },
                            // { 
                            //     title: "Charge(Rs.)",
                            //     style: {
                            //     width: 30,
                            //     height: 20,
                            //     backgroundColor: '#f2f2f2', // Background color for header cell
                            //     textAlign: 'center', // Center align text
                            //     fontWeight: 'bold' // Bold font weight for header cell
                            // }
                            // },
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
                            "\n"+(index + 1)+"\n",
                            "\n"+genarateData[index]['vehicleNumber']+"\n",
                            "\n"+genarateData[index]['vehicleType']+"\n",
                            "\n"+genarateData[index]['startTime']+"\n",
                            "\n"+genarateData[index]['endTime']+"\n",
                            // (genarateData[index]['status'] === 0) ? 'IN' : 'OUT' ,
                            "\n"+Math.floor((new Date(genarateData[index]['endTime']).getTime() - new Date(genarateData[index]['startTime']).getTime())/ (1000 * 60 * 60))+"h "+Math.floor((new Date(genarateData[index]['endTime']).getTime() - new Date(genarateData[index]['startTime']).getTime())% (1000 * 60 * 60) / (1000 * 60)) + "m"+"\n",
                            // genarateData[index]['cost'],
                            // (genarateData[index]['paymentStatus'] === 0) ? 'payed' : 'unpaid' 
                          
                        ])),
                          

                        
                        additionalRows: [{
                            col1: ' ',
                            col2: 'Car Count :  ' + carCount.toString(),
                            col3: ' ',
                            style: {
                                fontSize: 13 //optional, default 12
                            }
                        },
                        {
                            col1: ' ',
                            col2: 'Bike Count :  '+ bikeCount.toString(),
                            col3: ' ',
                            style: {
                                fontSize: 13 //optional, default 12
                            }
                        },
                        {
                            col1: ' ',
                            col2: 'Threewheel Count :  ' + threeWheelCount.toString(),
                            col3: ' ',
                            style: {
                                fontSize: 13 //optional, default 12
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