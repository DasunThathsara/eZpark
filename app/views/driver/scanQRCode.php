<?php require APPROOT . '/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = '';
require APPROOT . '/views/inc/components/sidenavbar.php';
?>
<main class="page-container">
    <style>
        #my-qr-reader {
            border: 1.5px solid #b2b2b2 !important;
        }

        #html5-qrcode-anchor-scan-type-change {
            text-decoration: none !important;
            color: #ffffff;
        }

        video {
            width: 100% !important;
            border: 1px solid #b2b2b2 !important;
            border-radius: 0.25em;
        }

        button {
            padding: 10px 20px;
            border: 1px solid #b2b2b2;
            outline: none;
            border-radius: 0.25em;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin-top: 15px;
            margin-bottom: 10px;
            background-color: #008000ad;
            transition: 0.3s background-color;
        }

        button:hover {
            background-color: #008000;
        }

    </style>
    <section class="section" id="main">
        <div class="container" style="width:width: 80%; min-width: 500px; max-width: 700px; margin-top: 40px; display: flex; justify-content: center; margin-right: auto; margin-left: auto">
            <div id="my-qr-reader">
            </div>
        </div>
    </section>
</main>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function domReady(fn) {
        if (
            document.readyState === "complete" ||
            document.readyState === "interactive"
        ) {
            setTimeout(fn, 1000);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    domReady(function () {

        // If found you qr code

        function onScanSuccess(decodeText, decodeResult) {
            // Show alert with decoded text and buttons
            var alertMessage = "You QR is: " + decodeText;

            // Show alert with buttons
            var result = confirm(alertMessage);

            // Handle button clicks
            if (result) {
                // User clicked 'Goto'
                // You can replace 'https://example.com' with the actual URL you want to open
                window.location.href = decodeText;
            } else {
                // User clicked 'Scan Again' or closed the alert
                // Nothing to do here, alert will be automatically closed
            }
        }



        let htmlscanner = new Html5QrcodeScanner(
            "my-qr-reader",
            { fps: 10, qrbos: 250 }
        );
        htmlscanner.render(onScanSuccess);
    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
