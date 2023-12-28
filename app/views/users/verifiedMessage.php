<?php require APPROOT.'/views/inc/header.php'; ?>

<div class="form-container" style="text-align: center; padding: 20px 10px 50px 10px; transform: translateY(100px)">
    <h2 style="font-size: 30px">Registration Successful</h2>
    <p style="color: #8a8a8a">Now you can login to your account.</p>
    <br><br><br><br>
    <a href="<?php echo URLROOT?>/users/login" style="padding: 10px 60px 10px 60px; background-color: #fcd426; border-radius: 20px;">Go to login page</a>
</div>

<!--?xml version="1.0" standalone="no"?-->
<div class="svg">
    <img class="svg-1" src="<?php echo URLROOT ?>/images/svg-1.png" alt="">
    <img class="svg-2" src="<?php echo URLROOT ?>/images/svg-7.png" alt="">
</div>

<script>
    document.body.style.backgroundColor = 'white';
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
