<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'chat';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1 class="title">Chat</h1>

            <div class="content-body" style="width:80%;margin-left: auto;margin-right: auto;">
                <div class="chat-container"  >
                    
                    <div class="chat-list">
                    <div class="chat-list-header">
                        <input type="text" id="chatSearch" placeholder="Search chats...">
                    </div>

                        <?php foreach($data['chat_list'] as $chat) {?>
                            <a href="<?php echo URLROOT?>/chat/viewChat/<?php echo $chat->chatID?>" >
                                <div class="chat-item <?php echo ($data['chat_id'] == $chat->chatID) ? 'chat-selected' : ''; ?>" >
                                <img  src="<?php echo URLROOT ?>/images/userimg.png" alt="">
                                <div class="chat-item-text"><?php echo $chat->senderName;?></div>
                            </div>
                            </a>
                        <?php } ?> 
                    </div>
                    <div class="chat-area" >
                        <?php if (!empty($data['chat_history'])){?>
                            <div class="messaging-area" >
                                <?php foreach($data['chat_history'] as $message){
                                    if($message->senderID == $_SESSION['user_id']){?>
                                        <div class="chat-right" ><?php echo $message->message?></div>
                                    <?php } else{?>
                                        <div class="chat-left" ><?php echo $message->message?></div>
                                    <?php }
                                    }?>
                            </div>
                            <div class="chat-send-area" >
                                <form class = "chat-form" action="<?php echo URLROOT?>/chat/sendMessage" method="post">
                                    <input required  type="text" style=" width: 60%;resize: none;margin:auto;box-sizing: content-box;color:#363430;font-size:unset;" name="message" placeholder="Type a message..">
                                    <input type="text" name="chatID" hidden value="<?php echo $data['chat_id']?>">
                                    <input type="submit" style="width: 20%;padding: 14px 20px; height:40px;margin-block: auto;margin-right: 10px;" value="send">
                                </form>
                            </div>
                        <?php } else{?>
                            <div class="messaging-area">
                                
                                    <img class= chat-img src="<?php echo URLROOT ?>/images/chaaat.avif" alt="">
                                    <p class="chat-p">Hello</p>
                                
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>

<script>
    

    // Function to scroll to the bottom of the messaging area
    function scrollToBottom() {
        var messagingArea = document.querySelector('.messaging-area');
        messagingArea.scrollTop = messagingArea.scrollHeight;
    }

    // Call the scrollToBottom function whenever new messages are added
    
    scrollToBottom();

    document.addEventListener("DOMContentLoaded", function () {
    const chatSearchInput = document.getElementById("chatSearch");
    const chatItems = document.querySelectorAll(".chat-item");

    chatSearchInput.addEventListener("input", function () {
        const searchText = chatSearchInput.value.toLowerCase();

        chatItems.forEach(function (chatItem) {
            const senderName = chatItem.textContent.toLowerCase();
            if (senderName.includes(searchText)) {
                chatItem.style.display = "flex";
            } else {
                chatItem.style.display = "none";
            }

        });
    });
});



</script>