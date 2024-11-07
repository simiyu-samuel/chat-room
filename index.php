<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>

</head>
<body>

<div class="chat-container">
    <div class="chat-header">Live Chat Room</div>
    
    <div id="chatBox"></div>

    <div class="chat-input">
        <input type="text" id="username" placeholder="Your Name" required>
        <input type="text" id="message" placeholder="Type your message..." required>
        <button id="sendBtn">Send</button>
    </div>
</div>

<script>
document.getElementById("sendBtn").onclick = sendMessage;
setInterval(loadMessages, 1000); // Refresh chat every second

function sendMessage() {
    const username = document.getElementById("username").value.trim();
    const message = document.getElementById("message").value.trim();
    if (!username || !message) return alert("Please enter your name and a message");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "chat.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=send&username=" + encodeURIComponent(username) + "&message=" + encodeURIComponent(message));
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById("message").value = ""; // Clear input after sending
            loadMessages(); // Refresh chat immediately
        }
    };
}

function loadMessages() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "chat.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=load");
    xhr.onload = function() {
        if (xhr.status === 200) {
            const chatBox = document.getElementById("chatBox");
            chatBox.innerHTML = xhr.responseText;
            chatBox.scrollTop = chatBox.scrollHeight; // Scroll to bottom
            
            // Add animation class to new messages
            const messages = chatBox.querySelectorAll(".chat-message");
            messages.forEach((message, index) => {
                message.style.animationDelay = `${index * 0.1}s`; // Staggered effect
            });
        }
    };
}
</script>

</body>
</html>
