<?php
include 'database.php';

if (isset($_POST['username'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $sql = "SELECT username FROM athelete_data WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    echo mysqli_num_rows($result) > 0 ? "taken" : "available";
}
?>
