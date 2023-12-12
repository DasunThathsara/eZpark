<!-- views/404.php -->
<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container" style="text-align: center; background-color: white; height: 100vh">
    <img class="error-img" style="width: 550px; margin-top: 30px;" src="<?php echo URLROOT ?>/images/404-img.jpg" alt="">
    <br><br>

<?php if (!empty($_SESSION['username'])){?>
    <a href="<?php echo URLROOT ?>/<?php echo $_SESSION['user_type'] ?>/index" class="error-btn">Go to home</a>
<?php }
else {?>
    <a href="<?php echo URLROOT ?>/pages/index" class="error-btn">Go to home</a>
<?php }?>

</div>

<script>
    document.body.style.backgroundColor = 'white';
</script>


<?php require APPROOT . '/views/inc/footer.php'; ?>
