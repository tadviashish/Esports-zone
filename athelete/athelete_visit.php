<?php
require("database.php") ;
session_start();
// echo $_SESSION['user'];
// echo $_SESSION['mobile'];
if(isset($_SESSION['user']))
{
    $username = $_SESSION['user'];
    $sql = "SELECT * FROM athelete_data WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id =  $row['atheleteid'];
    // echo $id;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESport-Zone</title>
    <link rel="stylesheet" href="athelete_visit.css">
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
            <div class="userprofile">
                <img src="../img/Soul.png" alt="">
                <div class="userinfo">
                    <h3>Soul Esports</h3>
                    <p><b>Soul Esports is a competitive esports organization dedicated to building
                            elite teams and dominating the gaming scene. We provide a professional
                            environment for players to grow, compete, and achieve greatness. Join us
                            and be part of the next generation of champions!</b></p>
                </div>
            </div>
            <div class="org-details">
                <h3>Organization Details</h3>
                <div class="socials">
                    <div class="insta"><a href=""><img src="../img/Instagram_icon.png" alt=""></a></div>
                    <div class="yt"><a href=""><img src="../img/youtube-logo-red-hd-13.png" alt=""></a></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>