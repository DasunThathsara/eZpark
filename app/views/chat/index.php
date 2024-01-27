<?php require APPROOT.'/views/inc/header.php'; ?>

    <div id ="wrapper">

        <div id="right_pannel">
            <div id="header">Ezpark Chat</div>
            <div id="container" style="display: flex;">

               
                <div id="inner_left_pannel">

                    
                    <!-- <div id="inner_inner_left" >
                        
                        <label id="label_chat" for="redio_chat">Chat<img src="<?php echo URLROOT ?>/images/chat.png"></label>
                        <label id="label_contacts" for="redio_contacts">Contacts<img src="<?php echo URLROOT ?>/images/contacts.png"></label>
                        <label id="label_settings" for="redio_settings">Settings<img src="<?php echo URLROOT ?>/images/settings.png"></label>
                    
                    </div> -->
                </div>

                <!-- <input type = "radio" id="redio_chat" name="myradio" style="display:none;">
                <input type = "radio" id="redio_contacts" name="myradio" style="display:none;">
                <input type = "radio" id="redio_settings" name="myradio" style="display:none;"> -->

                <div id="inner_right_pannel">

                    <div class="chat-container">

                        <div class="chat-header">
                            <h2>Contact Name</h2>
                            <p id="online-status">Online</p>
                        </div>

                        <ul class="chat-messages" id="chat-messages">
                            <!-- Messages will be appended here -->
                        </ul>
                        <div class="chat-input">
                            <input type="text" id="message-input" placeholder="Type a message...">
                            <button id="send-button">Send</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



<script type="text/javascript">

    

    document.getElementById("send-button").addEventListener("click", function() {
        var messageInput = document.getElementById("message-input");
        var message = messageInput.value.trim();
        
        if (message !== "") {
            sendMessage(message);
            messageInput.value = "";
        }
    });

    document.getElementById("message-input").addEventListener("keydown", function(event) {
        var messageInput = document.getElementById("message-input");
        var message = messageInput.value.trim();
        
        if (event.keyCode === 13) {
            if (message !== "") {
            sendMessage(message);
            messageInput.value = "";
        } 
        }
    });

    function sendMessage(message) {
        var chatMessages = document.getElementById("chat-messages");
        var li = document.createElement("li");
        li.classList.add("message");
        li.classList.add("sender");
        var p = document.createElement("p");
        p.textContent = message;
        li.appendChild(p);
        chatMessages.appendChild(li);

        // Scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    

</script>


    <?php require APPROOT.'/views/inc/footer.php'; ?>