<?php
require("database.php");
session_start();

if (isset($_SESSION['user']) && $_SESSION['pass'])
{
    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
        $sql = "SELECT * FROM org_data WHERE contactno = '$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $id =  $row['orgid'];
    }


}
else
{
    header("Location:../index.php");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESport-Zone</title>
    <link rel="stylesheet" href="posts.css">
</head>

<body>
    <header>
        <h1>ESport-Zone</h1>
        <nav>
            <a href="../about.php">about</a> | <a href="../contact.php">contact</a>
        </nav>
    </header>

    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile">
                <img src="<?php echo $row['profile']; ?>" alt="Profile Image">
                <h2><?php echo $row['orgname']; ?></h2>
            </div>
            <nav class="menu">
                <a href="org_profile.php"><button class="nav-button">Profile</button></a>
                <a href="org_editprofile.php"><button class="nav-button">Edit Profile</button></a>
                <a href="recruit.css"><button class="active">Recruit</button></a>
                <a href="requests.php"><button class="nav-button">Requests</button></a>
                <span class="logout">
                    <a href="logout.php"><button>LOGOUT</button></a>
                </span>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="profile2">
            <h2>Athelete Posts</h2>

            <div class="box">
                <div class="org">
                    <a href="">Recruit</a>
                    <a href="org_visit.php">Profile</a>
                </div>
                <div class="socials">
                    <div class="insta"><a href=""><img src="../img/Instagram_icon.png" alt=""></a></div>
                    <div class="yt"><a href=""><img src="../img/youtube-logo-red-hd-13.png" alt=""></a></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>