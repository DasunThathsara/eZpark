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
            <h1 class="title">Reports</h1>
            <p class="subtitle">Generate a report for your land</p>

    
            <div class="wrapper">
                <section class="chat-area">
                    <header>
                       
                    
                    <div class="content">
                    <a href="chat.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                        
                        <div class="details">
                            <span><?php echo $_SESSION['user_name'] ?></span>
                            <!-- <p><?php echo $row['status'] ?></p> -->
                        </div>
                    </div>
                
                    </header>
                    
                        
                       
                       
        

                    <div class="chat-box">
                        
                        
                    </div>

                    
                    <form action="#" class="typing-area" autocomplete="off">
                        <input type="text" name="outgoing_id" value="<?php echo $_SESSION['user_id']; ?>" hidden>
                        <input type="text" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                        <input type="text" name="message" class="input-field" placeholder="Type a message here...">
                        <button><i class="fab fa-telegram-plane"></i></button>

                    </form>
                </section>
            </div>
            <script src = "<?php echo URLROOT ?>/js/msg.js"></script>
        </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>