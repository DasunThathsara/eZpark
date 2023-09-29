<div class="topnav">
    <div class="container">
        <div class="items">
            <?php if (empty($_SESSION['user_id'])){ ?>
                <a class="item" href="<?php echo URLROOT ?>/users/login">Login</a>
                <a class="item" href="<?php echo URLROOT ?>/users/register">Register</a>
            <?php }else{ ?>
                <a class="item logo" onclick="navToggle()"><img style="width: 20px" src="<?php echo URLROOT ?>/images/menu.svg" alt=""></i></a>
                <a class="item" href=""><?php echo $_SESSION['user_name'] ?></a>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    function navToggle() {
        console.log("pushed")
        var element;
        element = document.querySelector('.sidenav');
        element.classList.toggle("sidenav-toggled");
    }
</script>