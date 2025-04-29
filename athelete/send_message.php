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

    // if (isset($_GET['senderid']) && isset($_GET['receiverid'])) {
    //     $senderid = $_GET['senderid'];
    //     $receiverid = $_GET['receiverid'];
    //     echo $senderid;
    //     echo $receiverid;
    // }

    $sender = $_POST['senderid'];
    $receiver = $_POST['receiverid'];
    $message = $_POST['message'];
    $sender_type = $_POST['sender_type']; // 'athlete' or 'organization'
    
    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message, sender_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $sender, $receiver, $message, $sender_type);
        $stmt->execute();
        echo "Message sent";
    } else {
        echo "Empty message";
    }
    
} else {
    header("Location:../index.php");
}
