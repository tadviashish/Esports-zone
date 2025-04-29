<?php
require("database.php");
session_start();

if(isset($_SESSION["user"]) && $_SESSION["pass"])
{

    if(isset($_SESSION['user']))
            {
                $username = $_SESSION['user'];
                $sql = "SELECT * FROM athelete_data WHERE username = '$username'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $id =  $row['atheleteid'];
            }

    if (isset($_GET['org'])) {
        $oid = $_GET['org'];
    }

    if (isset($_GET['orgname'])) {
        $oname = $_GET['orgname'];
        echo $oname;
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
    <!-- <link rel="stylesheet" href="search_org.css"> -->
    <!-- <link rel="stylesheet" href="search_result.css"> -->
    <!-- <link rel="stylesheet" href="userprofile.css"> -->
    <link rel="stylesheet" href="orgresult.css">
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
                <a href="search_org.php"><button class="active">Search Org</button></a>
                <a href="inquiries.php"><button class="nav-button">Inquiries</button></a>
                <span class="logout">
                    <a href="logout.php"><button>LOGOUT</button></a>
                </span>
            </nav>
        </aside>

        <div class="profile2">
            <div class="search-bar">
                <h3>Organization Profile</h3>
                <div class="content">
                    <?php
                    $sql = "SELECT * FROM org_data WHERE orgid = '$oid'";
                    $rows = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($rows) > 0) {
                        foreach ($rows as $row): ?>
                            <div class="result">
                                <div class="atheletedata">
                                    <div class="userprofile">
                                        <img src="../organization/<?php echo $row['profile']; ?>" alt="Profile image">
                                        <li>
                                            <span style="font-weight: bold; color: black;"><?php echo $row['orgname']; ?></span>
                                        </li>
                                    </div>
                                    <div class="bio">
                                        <p><?php echo $row['bio']; ?></p>
                                    </div>
                                    <a href="msg.php?senderid=<?php echo $id; ?>&receiverid=<?php echo $row['orgid']; ?>&sender_type=athelete">MESSAGE</a>
                                    <div class="orgdata">
                                            <p><strong>Owner : <?php echo $row['ownername']; ?></strong></p>
                                            <p><strong>Email : <?php echo $row['email']; ?></strong></p>
                                            <p><strong>Discord : <?php echo $row['discord']; ?></strong></p>
                                    </div>

                                </div>
                        <?php
                        endforeach;
                    } else {
                        echo "<b>" . "User Not found try another name or username" . "</b>";
                    }
                        ?>
                            </div>
                            <p id="social"><strong>Social Handles</strong></p>
                            <div class="social">
                                <a href="<?php echo  $row['instagram']; ?>" target="_blank">
                                    <img src="../img/instagram.png" alt="Instagram">
                                </a>
                                <a href="<?php echo  $row['youtube']; ?>" target="_blank">
                                    <img src="../img/youtube1.png" alt="Youtube">
                                </a>
                            </div>
                </div>
            </div>
        </div>

       

</body>

</html>