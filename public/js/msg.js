const form = document.querySelector(".typing-area");
inputField = form.querySelector(".input-field");
sendBtn = form.querySelector("button");
chatBox = document.querySelector(".chat-box");


form.onsubmit = (e) =>{
    e.preventDefault();//preventing form from submitting
}

sendBtn.onclick = ()=>{
    // Start Ajax
    let xhr = new XMLHttpRequest(); // Creating XML object
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                inputField.value = ""; //once value input to the db then leave blank in the input field
            }
        }
    }

    // Have to send form data through Ajax to PHP
    let formData = new FormData(form); // Creating new FormData object
    xhr.send(formData); // Sending the form data
}

setInterval(()=>{
    // Start Ajax
    let xhr = new XMLHttpRequest(); // Creating XML object
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
               
            }
        }
    }
    // Have to send form data through Ajax to PHP
    let formData = new FormData(form); // Creating new FormData object
    xhr.send(formData); // Sending the form data
    
},500);//this function will run frequently after 500ms