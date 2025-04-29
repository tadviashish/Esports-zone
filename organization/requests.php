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
    <link rel="stylesheet" href="requests.css">
</head>

<body>
    <header>
        <h1>ESport-Zone</h1>
        <nav>
            <a href="../about.php">about</a> | <a href="../about.php">contact</a>
        </nav>
    </header>

    <div class="container">
        <aside class="sidebar">
            <div class="profile">
                <img src="<?php echo $row['profile']; ?>" alt="Profile Image">
                <h2><?php echo $row['orgname']; ?></h2>
            </div>
            <nav class="menu">
                <a href="org_profile.php"><button class="nav-button">Profile</button></a>
                <a href="org_editprofile.php"><button class="nav-button">Edit Profile</button></a>
                <a href="recruit.php"><button class="nav-button">Recruit</button></a>
                <a href="requests.php"><button class="active">Requests</button></a>
                <span class="logout">
                    <a href="logout.php"><button>LOGOUT</button></a>
                </span>
            </nav>
        </aside>

        <div class="profile2">
            <h2>Inquiries</h2>
            <div class="box">
                <?php
                $sql = "SELECT DISTINCT sender_id FROM messages WHERE sender_type='athelete' AND receiver_id = '$id'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    // echo "Receiver ID: " . $row['receiver_id'] . "<br>";
                    $aid = $row['sender_id'];
                    $sql1 = "SELECT * FROM athelete_data WHERE atheleteid='$aid'";
                    $result1 = mysqli_query($conn, $sql1);
                    $data = mysqli_fetch_assoc($result1);
                ?>
                    <div class="box1">
                        <img src="../athelete/<?php echo $data['profile']; ?>" alt="">
                        <a href="chatorg.php?senderid=<?php echo $id; ?>&receiverid=<?php echo $data['atheleteid']; ?>&sender_type=org"><?php echo $data['name']; ?></a>
                    </div>

                <?php
                }
                ?>

            </div>
        </div>
    </div>
</body>

</html>