<div class="topnav">
    <a class="active" href="">Home</a>
    <?php if (empty($_SESSION['user_id'])){ ?>
        <a href="<?php echo URLROOT ?>/users/login">Login</a>
        <a href="<?php echo URLROOT ?>/users/register">Register</a>
    <?php
    }else{ ?>
        <a href="<?php echo URLROOT ?>/users/logout">Logout</a>
        <a href=""><?php echo $_SESSION['user_name'] ?></a>
    <?php } ?>
</div>