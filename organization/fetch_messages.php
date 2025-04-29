<?php
require("database.php");
session_start();

if (isset($_SESSION['user']) && $_SESSION['pass']) {
    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
        $sql = "SELECT * FROM org_data WHERE contactno = '$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row['orgid'];
    }

    $sender = $_GET['senderid'];
    $receiver = $_GET['receiverid'];

    $sql = "SELECT * FROM messages 
    WHERE (sender_id = $sender AND receiver_id = $receiver) 
       OR (sender_id = $receiver AND receiver_id = $sender) 
    ORDER BY created_at ASC";

    $result = $conn->query($sql);
    $messages = "";

    while ($row = mysqli_fetch_assoc($result)) {
        $msg = $row['message'];
        $time = date("h:i A", strtotime($row['created_at'])); // Format: 02:15 PM

        if ($row['sender_id'] == $sender) {
            echo '<div class="message sender">';
            echo '<p>' . $msg . '</p>';
            echo '<span class="time">' . $time . '</span>';
            echo '</div>';
        } else {
            echo '<div class="message receiver">';
            echo '<p>' . $msg . '</p>';
            echo '<span class="time">' . $time . '</span>';
            echo '</div>';
        }
    }

    echo $messages;
} else {
    header("Location:../index.php");
}
