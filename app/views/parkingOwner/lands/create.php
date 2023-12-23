<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'lands';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1 class="title">Add New Land</h1>
            <p class="subtitle">Fill up the information correctly for your new land</p>

            <div class="form-container land-register-form">
                <br>
                <?php if (!empty($data['err'])){?>
                    <div class="error-msg">
                        <span class="form-invalid"><?php echo $data["err"] ?></span>
                    </div>
                <?php } ?>

                <form action="<?php echo URLROOT ?>/land/landRegister" method="post" enctype="multipart/form-data">
                    <!-- Name -->
                    <div class="form-input-title">Name of the parking:</div>
                    <input type="text" name="name" id="name" required value="<?php echo $data['name'] ?>" />

                    <br><br>

                    <!-- City -->
                    <div class="form-input-title">City:</div>
                    <input type="text" name="city" id="city" required value="<?php echo $data['city'] ?>" />

                    <br><br>

                    <!-- Street -->
                    <div class="form-input-title">Street:</div>
                    <input type="text" name="street" id="street" required value="<?php echo $data['street'] ?>" />

                    <br><br>

                    <!-- Deed -->
                    <div class="form-input-title">Deed:</div>
                    <div class="file-upload-container">
                        <label class="file-upload" for="deed">Upload File</label>
                        <input type="file" name="deed" id="deed" hidden />
                        <div class="description">*Upload deed in PDF format</div>
                    </div>

                    <br><br>

                    <!-- Car -->
                    <div class="form-input-title">Number of available car parking slots:</div>
                    <input type="text" name="car" id="car" required value="<?php echo $data['car'] ?>" />

                    <br><br>

                    <!-- Bike -->
                    <div class="form-input-title">Number of available bike parking slots:</div>
                    <input type="text" name="bike" id="bike" required value="<?php echo $data['bike'] ?>" />

                    <br><br>

                    <!-- Three Wheel -->
                    <div class="form-input-title">Number of available threewheel parking slots:</div>
                    <input type="text" name="threeWheel" id="threeWheel" required value="<?php echo $data['threeWheel'] ?>" />

                    <br><br>

                    <!-- contactNo -->
                    <div class="form-input-title">Contact Number:</div>
                    <input type="text" name="contactNo" id="contactNo" required value="<?php echo $data['contactNo'] ?>" />

                    <br><br>

                    <!-- Submit -->
                    <input type="submit" value="Next">
                </form>
            </div>
        </div>

        <div class="open-side-cards-btn" onclick="closeRightCardInForm()">View Transaction</div>

        <div class="side-cards">
            <div class="close-btn" onclick="closeRightCardInForm()">X</div>
            <div class="close-btn" onclick="closeRightCardInForm()">X</div>
            <div class="close-btn" onclick="closeRightCardInForm()">X</div>
            <div class="close-btn" onclick="closeRightCardInForm()">X</div>
            <div class="close-btn" onclick="closeRightCardInForm()">X</div>
            <div class="close-btn" onclick="closeRightCardInForm()">X</div>
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
    function closeRightCardInForm(){
        var screenWidth = window.innerWidth;
        var element1, element2, element3;

        if (screenWidth <= 720){
            element1 = document.querySelector('.side-cards');
            element1.classList.toggle("side-cards-active");

            element2 = document.querySelector('.open-side-cards-btn');
            element2.classList.toggle("open-side-cards-btn-hide");
        }
        else {
            element1 = document.querySelector('.side-cards');
            element1.classList.toggle("side-cards-hide");

            element2 = document.querySelector('.open-side-cards-btn');
            element2.classList.toggle("open-side-cards-btn-active");

            element3 = document.querySelector('.land-register-form');
            element3.classList.toggle("land-register-form-expand");
        }
    }
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
