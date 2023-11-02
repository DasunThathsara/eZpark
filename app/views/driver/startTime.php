<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h2>Independence Square Parking Lot - Colombo07</h2>
        </div>

        <div class="timer-group">
            <div class="timer hour">
                <div class="hand"><span></span></div>
                <div class="hand"><span></span></div>
            </div>
            <div class="timer minute">
                <div class="hand"><span></span></div>
                <div class="hand"><span></span></div>
            </div>
            <div class="timer second">
                <div class="hand"><span></span></div>
                <div class="hand"><span></span></div>
            </div>
            <div class="face">
                <p id="lazy">00:00:00</p>  
            </div>

            <script>
                var defaults = {}
                    , one_second = 1000
                    , one_minute = one_second * 60
                    , one_hour = one_minute * 60
                    , one_day = one_hour * 24
                    , startDate = new Date()
                    , face = document.getElementById('lazy');

                    // http://paulirish.com/2011/requestanimationframe-for-smart-animating/
                    var requestAnimationFrame = (function() {
                    return window.requestAnimationFrame       || 
                            window.webkitRequestAnimationFrame || 
                            window.mozRequestAnimationFrame    || 
                            window.oRequestAnimationFrame      || 
                            window.msRequestAnimationFrame     || 
                            function( callback ){
                            window.setTimeout(callback, 1000 / 60);
                            };
                    }());

                    tick();

                    function tick() {

                    var now = new Date()
                        , elapsed = now - startDate
                        , parts = [];

                    parts[0] = '' + Math.floor( elapsed / one_hour );
                    parts[1] = '' + Math.floor( (elapsed % one_hour) / one_minute );
                    parts[2] = '' + Math.floor( ( (elapsed % one_hour) % one_minute ) / one_second );

                    parts[0] = (parts[0].length == 1) ? '0' + parts[0] : parts[0];
                    parts[1] = (parts[1].length == 1) ? '0' + parts[1] : parts[1];
                    parts[2] = (parts[2].length == 1) ? '0' + parts[2] : parts[2];

                    face.innerText = parts.join(':');
                    
                    requestAnimationFrame(tick);
                }
            </script>    
        </div>

        <div class="container">        
            <a href="<?php echo URLROOT ?>/driver/scanQRCodeToExit">
                <button>Scan QR to Exit</button>
            </a>
        </div>        
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>