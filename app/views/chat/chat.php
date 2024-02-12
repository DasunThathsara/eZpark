
<?php require APPROOT.'/views/inc/header.php'; ?>

<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'reports';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1 class="title">Reports</h1>
            <p class="subtitle">Generate a report for your land</p>

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
                    <a href="php/logout.php?logout_id=<?php echo $row['unique_id']?>" class="logout">Logout</a>
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

        <script src = "<?php echo URLROOT ?>/js/chat.js"></script>
        
  
    </section>
</main>


<?php require APPROOT.'/views/inc/footer.php'; ?>
