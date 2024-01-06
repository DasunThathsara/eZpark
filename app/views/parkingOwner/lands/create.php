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
            <h1 class="title">Add a New Land</h1>
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

                    <!-- Address -->
                    <div class="form-input-title">Address:</div>
                    <input type="text" name="address" id="address" required value="<?php echo $data['address'] ?>" />

                    <br><br>

                    <!-- Street -->
                    <div class="form-input-title">Street:</div>
                    <input type="text" name="street" id="street" required value="<?php echo $data['street'] ?>" />

                    <br><br>

                    <!-- City -->
                    <div class="form-input-title">City:</div>
                    <input type="text" name="city" id="city" required value="<?php echo $data['city'] ?>" />

                    <br><br>

                    <!-- District -->
                    <div class="form-input-title">District:</div>
                    <select name="district" id="district" required>
                        <option value="" disabled selected>Select District</option>
                        <option value="Ampara" <?php if ($data['district'] == 'Ampara') echo 'selected' ?>>Ampara</option>
                        <option value="Anuradhapura" <?php if ($data['district'] == 'Anuradhapura') echo 'selected' ?>>Anuradhapura</option>
                        <option value="Badulla" <?php if ($data['district'] == 'Badulla') echo 'selected' ?>>Badulla</option>
                        <option value="Batticaloa" <?php if ($data['district'] == 'Batticaloa') echo 'selected' ?>>Batticaloa</option>
                        <option value="Colombo" <?php if ($data['district'] == 'Colombo') echo 'selected' ?>>Colombo</option>
                        <option value="Galle" <?php if ($data['district'] == 'Galle') echo 'selected' ?>>Galle</option>
                        <option value="Gampaha" <?php if ($data['district'] == 'Gampaha') echo 'selected' ?>>Gampaha</option>
                        <option value="Hambantota" <?php if ($data['district'] == 'Hambantota') echo 'selected' ?>>Hambantota</option>
                        <option value="Jaffna" <?php if ($data['district'] == 'Jaffna') echo 'selected' ?>>Jaffna</option>
                        <option value="Kandy" <?php if ($data['district'] == 'Kandy') echo 'selected' ?>>Kandy</option>
                        <option value="Kalutara" <?php if ($data['district'] == 'Kalutara') echo 'selected' ?>>Kalutara</option>
                        <option value="Kegalle" <?php if ($data['district'] == 'Kegalle') echo 'selected' ?>>Kegalle</option>
                        <option value="Kilinochchi" <?php if ($data['district'] == 'Kilinochchi') echo 'selected' ?>>Kilinochchi</option>
                        <option value="Kurunegala" <?php if ($data['district'] == 'Kurunegala') echo 'selected' ?>>Kurunegala</option>
                        <option value="Mannar" <?php if ($data['district'] == 'Mannar') echo 'selected' ?>>Mannar</option>
                        <option value="Matara" <?php if ($data['district'] == 'Matara') echo 'selected' ?>>Matara</option>
                        <option value="Matale" <?php if ($data['district'] == 'Matale') echo 'selected' ?>>Matale</option>
                        <option value="Monaragala" <?php if ($data['district'] == 'Monaragala') echo 'selected' ?>>Monaragala</option>
                        <option value="Mullaitivu" <?php if ($data['district'] == 'Mullaitivu') echo 'selected' ?>>Mullaitivu</option>
                        <option value="Nuwara Eliya" <?php if ($data['district'] == 'Nuwara Eliya') echo 'selected' ?>>Nuwara Eliya</option>
                        <option value="Polonnaruwa" <?php if ($data['district'] == 'Polonnaruwa') echo 'selected' ?>>Polonnaruwa</option>
                        <option value="Puttalam" <?php if ($data['district'] == 'Puttalam') echo 'selected' ?>>Puttalam</option>
                        <option value="Ratnapura" <?php if ($data['district'] == 'Ratnapura') echo 'selected' ?>>Ratnapura</option>
                        <option value="Trincomalee" <?php if ($data['district'] == 'Trincomalee') echo 'selected' ?>>Trincomalee</option>
                        <option value="Vavuniya" <?php if ($data['district'] == 'Vavuniya') echo 'selected' ?>>Vavuniya</option>
                    </select>

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

        <div class="open-side-cards-btn" onclick="closeRightCardInForm()">View Instructions</div>

        <div class="side-cards">
            <div class="close-btn" onclick="closeRightCardInForm()">X</div>
            <h2>Instructions</h2>

            <br>

            <p><span>&#9632;</span>Sample image</p>

            <div style="display: flex; justify-content: center;">
                <div class="instruction-img" style="width: 90%;">
                    <img style="width: 100%; border-radius: 20px;" src="<?php echo URLROOT ?>/public/images/parking_bg1.jpg" alt="land-register-1">
                </div>
            </div>

            <br><br>

            <p><span>&#9632;</span>Sizes</p>
            <div style="margin-left: 30px; font-size: 13px;">
                <div style="margin-top: 10px;">Car: 4x5</div>
                <div style="margin-top: 10px;">Bike: 2x4</div>
                <div style="margin-top: 10px;">Three Wheel: 3x4</div>
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
