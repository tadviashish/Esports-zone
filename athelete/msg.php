<?php
require("database.php");
session_start();

if (isset($_SESSION["user"]) && $_SESSION["pass"]) {

    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
        $sql = "SELECT * FROM athelete_data WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $id =  $row['atheleteid'];
    }

    if (isset($_GET['senderid']) && isset($_GET['receiverid'])) {
        $senderid = $_GET['senderid'];
        $receiverid = $_GET['receiverid'];
        $sendertype = $_GET['sender_type'];
        echo $senderid;
        echo $receiverid;
        echo $sendertype;
    }
} else {
    header("Location:../index.php");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESport-Zone</title>
    <link rel="stylesheet" href="orgresult.css">
    <link rel="stylesheet" href="chat.css">
</head>

<body>
    <header>
        <h1>ESport-Zone</h1>
        <nav>
            <a href="../about.php">about</a> | <a href="../contact.php">contact</a>
        </nav>
    </header>

    <div class="container">
        <aside class="sidebar">
            <div class="profile">
                <img src="<?php echo $row['profile']; ?>" alt="Profile Image">
                <h2><?php echo $row['name']; ?></h2>
            </div>
            <nav class="menu">
                <a href="athelete_profile.php"><button class="nav-button">Profile</button></a>
                <a href="athelete_edit-profile.php"><button class="nav-button">Edit Profile</button></a>
                <a href="upload.php"><button class="nav-button">Upload</button></a>
                <a href="games.php"><button class="nav-button">Games</button></a>
                <a href="search_org.php"><button class="nav-button">Search Org</button></a>
                <a href="inquiries.php"><button class="active">Inquiries</button></a>
                <span class="logout">
                    <a href="logout.php"><button>LOGOUT</button></a>
                </span>
            </nav>
        </aside>

        <div class="profile2">
            <div class="chat-container">
                <?php
                $sql = "SELECT * FROM org_data where orgid='$receiverid'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result)
                ?>
                <div class="chat-header">
                    <img src="../organization/<?php echo $row['profile']; ?>" alt="profile">
                    <h5><?php echo $row['orgname']; ?></h5>
                </div>
                <div class="chat-messages" id="chatBox">
                    <div class="message sender"></div>
                    <div class="message receiver"></div>
                </div>

                <div class="chat-input">
                    <input type="text" id="messageInput" placeholder="Type a message... 😂🔥">
                    <button id="sendButton">Send</button>
                </div>
            </div>
        </div>
        <script>
            document.getElementById("messageInput").addEventListener("keypress", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                    sendMessage();
                }
            });

            document.getElementById("sendButton").addEventListener("click", function() {
                sendMessage();
            });
            function sendMessage() {
                let message = document.getElementById('messageInput').value;
                let senderid = "<?php echo $senderid; ?>";
                let receiverid = "<?php echo $receiverid; ?>";
                let sender_type = "<?php echo $sendertype; ?>";

                if (message.trim() !== "") {
                    fetch("send_message.php", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `senderid=${senderid}&receiverid=${receiverid}&message=${encodeURIComponent(message)}&sender_type=${sender_type}`
                    }).then(res => res.text()).then(() => {
                        document.getElementById('messageInput').value = "";
                        loadMessages();
                    });
                }
            }
            let previousMessages = "";

            function loadMessages() {
                let senderid = "<?php echo $senderid; ?>";
                let receiverid = "<?php echo $receiverid; ?>";

                fetch(`fetch_messages.php?senderid=${senderid}&receiverid=${receiverid}`)
                    .then(res => res.text())
                    .then(data => {
                        if (data !== previousMessages) {
                            document.getElementById('chatBox').innerHTML = data;
                            document.getElementById('chatBox').scrollTop = document.getElementById('chatBox').scrollHeight;
                            previousMessages = data;
                        }
                    });
            }

            setInterval(loadMessages, 200);
            window.onload = loadMessages;
        </script>


</body>

</html>