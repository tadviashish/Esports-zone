<?php
require("database.php");
session_start();

if (isset($_SESSION["user"]) && $_SESSION["pass"]) 
{

    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
        $sql = "SELECT * FROM athelete_data WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $id =  $row['atheleteid'];
    }

   
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id']; 
    $tables = ['bgmi', 'freefire', 'pokemon', 'valorant'];
    $alreadyEntered = false;
    foreach ($tables as $table) {
        $query = "SELECT * FROM $table WHERE atheleteid = '$id'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $alreadyEntered = true;
            break;
        }
    }

    if ($alreadyEntered) {
        echo "<script>alert('Already entered game details!'); window.location.href='./athelete_profile.php';</script>";
        exit();
    }
}
    
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $playerid = $_POST['playerid'];
        $ingamename = $_POST['ingamename'];
        $role = $_POST['role'];
        $finish = $_POST['finish'];
        $win = $_POST['win'];
        $playtime = $_POST['playtime'];
        $avest = $_POST['avest'];
        $bio = $_POST['bio'];
        $sql = "INSERT INTO bgmi(atheleteid,gameid, ingamename, role, fratio, wratio, playtime, avgtime, previousexp)
                        VALUES ('$id', '$playerid', '$ingamename', '$role', '$finish', '$win', '$playtime', '$avest', '$bio')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "Data entered";
            header("Location:./athelete/athelete_profile.php");
        }
    }
} else {
    header("Location:./athelete/athelete_profile.php");
}

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESport-Zone</title>
    <link rel="stylesheet" href="games.css">
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
                <a href="games.php"><button class="active">Games</button></a>
                <a href="search_org.php"><button class="nav-button">Search Org</button></a>
                <a href="inquiries.php"><button class="nav-button">Inquiries</button></a>
                <span class="logout">
                    <a href="logout.php"><button>LOGOUT</button></a>
                </span>
            </nav>
        </aside>

        <div class="profile2">
            <div class="games">
                <a href="games.php"><button class="bt1">BGMI</button></a>
                <a href="valorant.php"><button class="bt2">Valorant</button></a>
                <a href="freefire.php"><button class="bt2">Free Fire</button></a>
                <a href="pokemon.php"><button class="bt2">Pokemon Unite</button></a>
            </div>
            <div class="form-container">
                <h1>Enter your game details</h1>
                <form method="post" action="games.php">

                    <input type="text" name="id" value="<?php echo $row['atheleteid']; ?>" hidden>
                    <label for="pid">Player ID</label>
                    <input type="number" id="pid" name="playerid" placeholder="Enter Player ID">

                    <label for="pname">In game Name</label>
                    <input type="text" id="pname" name="ingamename" placeholder="Enter game Name">

                    <label for="prole">Role</label>
                    <input type="text" id="prole" name="role" placeholder="Enter your role">

                    <label for="fratio">Finish Ratio</label>
                    <input type="number" step="any" id="fratio" name="finish" placeholder="Enter your Finish Ratio">

                    <label for="wratio">Win Ratio</label>
                    <input type="number" step="any" id="wratio" name="win" placeholder="Enter Win Ratio">

                    <label for="ptime">Playing Time</label>
                    <input type="text" id="ptime" name="playtime" placeholder="Playing Time in hours">

                    <label for="ast">Average Survive Time</label>
                    <input type="text" id="ast" name="avest" placeholder="Your Avg survive time">

                    <label for="win">If Any Previous Tournment which you won or Dominated Add those details here !!!</label>
                    <textarea id="win" name="bio" rows="4" placeholder="Your Achivements..."></textarea>

                    <input class="btn" type="submit" name="submit">
                </form>
            </div>
        </div>
    </div>
</body>

</html>