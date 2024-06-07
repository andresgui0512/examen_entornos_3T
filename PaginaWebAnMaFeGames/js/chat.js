function sendMessage() {
        var mensaje = document.getElementById("mensaje");
        var message = mensaje.value.trim();
        
        if (message === "") {
            return;
        }
        
        var chatContainer = document.getElementById("chatContainer");
        var messageDiv = document.createElement("div");
        messageDiv.className = "message";
        messageDiv.textContent = message;
        chatContainer.insertBefore(messageDiv, chatContainer.firstChild);
        
        mensaje.value = "";
    }
    