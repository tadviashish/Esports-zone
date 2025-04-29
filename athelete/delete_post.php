<?php
require('database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postid = $_POST['postid'];

    $query = "SELECT post FROM uploadpost WHERE postid = '$postid'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $filePath = $row['post'];

        // Delete file if exists
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete from DB
        mysqli_query($conn, "DELETE FROM uploadpost WHERE postid = '$postid'");
        echo "Deleted";
    } else {
        echo "Post not found";
    }
}
?>
