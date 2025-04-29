<?php
require("database.php") ;
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
    <link rel="stylesheet" href="search_org.css">
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
                <label for="search">Search an Org :</label>
                <form action="search_result.php" method="get">
                <select name="games" id="game">
                        <option value="OPTION">SELECT GAME</option>
                        <option value="BGMI">BGMI</option>
                        <option value="FREE FIRE">FREE FIRE</option>
                        <option value="VALORANT">VALORANT</option>
                        <option value="POKEMON">POKEMON</option>
                    </select>
                    <input type="text" id="search" name="searchinfo" placeholder="Enter organization name">
                    <input id="searchbutton" type="submit" name="search">
                </form>
                <h3>Suggestions</h3>
            </div>
            <div class="organizations">
                <div class="org">
                    <img src="..//img/Soul.png" alt="">
                    <h4>Soul Esports</h4>
                </div>
                <div class="org2">
                    <p><b>Request them to make a visit on your profile</b></p>
                    <a href="">Request</a>
                    <!-- <a href="">Visit Profile</a> -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>