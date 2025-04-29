<?php

require("database.php");
session_start();

header('Content-Type: text/html');

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Error: User not logged in');</script>";
    exit();
}

$user = $_SESSION['user'];

if (empty($_FILES) || !isset($_FILES['image']) || !isset($_POST['orgid'])) {
    echo "<script>alert('Error: Invalid request. No file or ORG ID received.');</script>";
    exit();
}

$orgid = intval($_POST['orgid']);
$targetDir = "uploads/";


if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$fileName = basename($_FILES['image']['tmp_name']);
$targetFilePath = $targetDir . $fileName;

if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
    echo "<script>" + "alert('Error: File upload failed.');" + "</script>";
    exit();
}
$sql = "UPDATE org_data SET profile = '$targetFilePath' WHERE orgid = '$orgid'";
$result = mysqli_query($conn, $sql);
header("refresh:1;url=org_profile.php");

if (!$result) {
    echo "<script>alert('Error: Database update failed. " . mysqli_error($conn) . "');</script>";
    exit();
}

echo '<script>alert("Profile updated successfully!");</script>';

exit();
?>
