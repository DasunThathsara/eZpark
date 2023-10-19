<!-- views/404.php -->
<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container" style="text-align: center">
    <img class="error-img" style="width: 550px; margin-top: 30px;" src="<?php echo URLROOT ?>/images/404-img.jpg" alt="">
    <br><br>
    <a href="<?php echo URLROOT ?>/<?php echo $_SESSION['user_type'] ?>/index" class="error-btn">Go to home</a>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
