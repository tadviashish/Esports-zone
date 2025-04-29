    <?php

    require("database.php");
    session_start();

    header('Content-Type: text/html');

    if (!isset($_SESSION['user'])) {
        echo "<script>alert('Error: User not logged in');</script>";
        exit();
    }

    $user = $_SESSION['user'];

    if (empty($_FILES) || !isset($_FILES['image']) || !isset($_POST['athleteID'])) {
        echo "<script>alert('Error: Invalid request. No file or athlete ID received.');</script>";
        exit();
    }

    $athleteID = intval($_POST['athleteID']);
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
    $sql = "UPDATE athelete_data SET profile = '$targetFilePath' WHERE atheleteid = '$athleteID'";
    $result = mysqli_query($conn, $sql);
    header("refresh:1;url=athelete_profile.php");

    if (!$result) {
        echo "<script>alert('Error: Database update failed. " . mysqli_error($conn) . "');</script>";
        exit();
    }

    echo '<script>alert("Profile updated successfully!");</script>';

    exit();
    ?>
