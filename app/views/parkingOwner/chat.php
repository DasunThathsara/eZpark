<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'dashboard';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1>Parking Owner</h1>

            <div class="chat-container" style="display: flex; justify-content: space-between; height: 70vh;">
                <div class="chat-list" style="border: 1px solid black; width: 30%;">
                    <?php foreach($data['chat_list'] as $chat) {?>
                        <a href="<?php echo URLROOT?>/chat/viewChat/<?php echo $chat->chatID?>">
                            <div class="chat-item" style="border: 1px solid black; padding: 5px;"><?php echo $chat->senderName;?></div>
                        </a>
                    <?php } ?>
                </div>
                <div class="chat-area" style="border: 1px solid black; width: 70%;">
                    <?php if (!empty($data['chat_history'])){?>
                        <div class="messaging-area" style="height: calc(70vh - 50px);overflow-y: auto;">
                            <?php foreach($data['chat_history'] as $message){
                                if($message->senderID == $_SESSION['user_id']){?>
                                    <div class="right"  style="background-color: #6e6c65; color: white; text-align: right; padding: 10px; border-radius: 10px; margin: 5px; max-width:  fit-content; word-wrap: break-word; margin-left: auto;"><?php echo $message->message?></div>
                                <?php } else{?>
                                    <div class="left" style="background-color: #dadada; color: black; text-align: left; padding: 10px; border-radius: 10px; margin: 5px; max-width:  fit-content; word-wrap: break-word; margin-right: auto;"><?php echo $message->message?></div>
                                <?php }
                                }?>
                        </div>
                        <div class="chat-send-area" style="display: flex; justify-content: space-between;">
                            <form action="<?php echo URLROOT?>/chat/sendMessage" style="display: flex; justify-content: space-between; width: 100%;" method="post">
                                <input required type="text" name="message" placeholder="Message..">
                                <input type="text" name="chatID" hidden value="<?php echo $data['chat_id']?>">
                                <input type="submit" value="Send">
                            </form>
                        </div>
                    <?php } else{?>
                        <div class="messaging-area">
                            hello
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>