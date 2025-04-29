<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>
<div id="chat-box" style="height:300px; overflow-y:scroll; border:1px solid #ccc; padding:10px;"></div>

<form id="chat-form">
    <input type="hidden" id="sender_id" value="1">
    <input type="hidden" id="receiver_id" value="5">
    <input type="text" id="message" placeholder="Type your message..." required>
    <button type="submit">Send</button>
</form>

<script>
function fetchMessages() {
    const sender = document.getElementById('sender_id').value;
    const receiver = document.getElementById('receiver_id').value;

    fetch(`fetch_messages.php?sender_id=${sender}&receiver_id=${receiver}`)
        .then(res => res.text())
        .then(data => {
            document.getElementById('chat-box').innerHTML = data;
            const box = document.getElementById('chat-box');
            box.scrollTop = box.scrollHeight; // Auto-scroll
        });
}

// Load messages every 1.5 seconds
setInterval(fetchMessages, 1500);
fetchMessages(); // Load initially

document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const message = document.getElementById('message').value;
    const sender = document.getElementById('sender_id').value;
    const receiver = document.getElementById('receiver_id').value;

    fetch('send_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `sender_id=${sender}&receiver_id=${receiver}&message=${encodeURIComponent(message)}`
    }).then(() => {
        document.getElementById('message').value = '';
        fetchMessages();
    });
});
</script>

</body>
</html>