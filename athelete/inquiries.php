<?php
require("database.php");
session_start();
// echo $_SESSION['user'];
// echo $_SESSION['mobile'];
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $sql = "SELECT * FROM athelete_data WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id =  $row['atheleteid'];
    // echo $id;
}

?>

!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESport-Zone</title>
    <link rel="stylesheet" href="inquiries.css">
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
            <h2>Inquiries</h2>
            <div class="box">
                <?php
                $sql = "SELECT DISTINCT receiver_id FROM messages WHERE sender_type='athelete' AND sender_id = '$id'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    // echo "Receiver ID: " . $row['receiver_id'] . "<br>";
                    $orgid = $row['receiver_id'];
                    $sql1 = "SELECT * FROM org_data WHERE orgid='$orgid'";
                    $result1 = mysqli_query($conn, $sql1);
                    $data = mysqli_fetch_assoc($result1);

                ?>
                    <div class="box1">
                        <img src="../organization/<?php echo $data['profile']; ?>" alt="">
                        <a href="chat.php?senderid=<?php echo $id; ?>&receiverid=<?php echo $data['orgid']; ?>&sender_type=athelete"><?php echo $data['orgname']; ?></a>
                    </div>

                <?php
                }
                ?>

            </div>
        </div>
    </div>
</body>

</html>