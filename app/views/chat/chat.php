
<?php require APPROOT.'/views/inc/header.php'; ?>

<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'chats';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1 class="title">Chats</h1>
            

            <div class="wrapper">
            <section class="users">
                <header>
                
                    <div class="content">
                        <!-- <img src="php/images/<?php echo $row['img']?>" alt=""> -->
                        <div class="details">
                            <span><?php echo $_SESSION['user_name'] ?></span>
                            <!-- <p><?php echo $row['status'] ?></p> -->
                        </div>
                    </div>
                    
                </header>
                <div class="search">
                    <span class="text">Select an user to strat chat</span>
                    <input type="text" name="searchTerm" placeholder="Enter name to search...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="users-list">
                    

                </div>
            </section>

        </div>
        <!-- <?php var_dump($data) ?> -->

        <script src = "<?php echo URLROOT ?>/js/chat.js"></script>
        
  
    </section>
</main>


<?php require APPROOT.'/views/inc/footer.php'; ?>