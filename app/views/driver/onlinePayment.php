<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1>Independence Square Parking Lot - Colombo07</h1>
        </div>

        <div class="container">
            <div id="payment-stripe" class="container">
                <div class="row text-left">
                    
                    <div class="form-group">   
                        <p>
                            <input type="radio" name="creditCard" id="visa" required checked>
                            <label for="visa">Visa</label>

                            <input type="radio" name="creditCard" id="mastercard" required>
                            <label for="mastercard">MasterCard</label>

                            <input type="radio" name="creditCard" id="amex" required>
                            <label for="amex">AmericanExpress</label>
                        </p>
                    </div>
                    <div class="col-sm-12">
                    <div class="form-group">
                        <label for="cc-number" class="control-label">Credit Card Number <small class="text-muted">[<span data-payment="cc-brand"></span>]</small></label>
                        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>                                    
                        <input id="cc-number" type="tel" class="input-lg form-control cc-number" autocomplete="cc-number" placeholder="1234-5678-1346-4679 " data-payment='cc-number' required>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-8">
                    <div class="form-group">
                        <label>Expiration (MM/YYYY)</label>
                        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input id="cc-exp" type="tel" class="input-lg form-control cc-exp" autocomplete="cc-exp" placeholder="05 / 2027" data-payment='cc-exp' required>
                        </div>
                    </div>
                    </div>        
                    <div class="col-sm-4">
                    <div class="form-group">
                        <label>CVC Code</label>
                        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input id="cc-cvc" type="tel" class="input-lg form-control cc-cvc" autocomplete="off" placeholder="123" data-payment='cc-cvc' required>
                        </div>
                    </div>
                    </div>
                </div>

                    <a href="<?php echo URLROOT ?>/driver/paymentSuccessful">
                        <button class="btn btn-primary" type="button" id="validate">Pay</button>
                    </a>
        </div>        
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>