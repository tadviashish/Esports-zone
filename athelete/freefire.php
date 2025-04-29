<?php
require("database.php");
session_start();

if (isset($_SESSION["user"]) && $_SESSION["pass"]) {

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
        $atheleteid    = $_POST['id'];
        $playerid      = $_POST['playerid'];
        $playername    = $_POST['playername'];
        $role          = $_POST['role'];
        $kd            = $_POST['kd'];
        $winrate       = $_POST['win'];
        $avgdamage     = $_POST['damage'];
        $avgsurvive    = $_POST['survive'];
        $activetime    = $_POST['active'];
        $previousachiv = $_POST['bio'];

        $sql = "INSERT INTO freefire(atheleteid, ffgameid, ingamename, role, kdratio, wratio, avgdamage, avgstime, activetime, previusexp) VALUES ('$atheleteid','$playerid','$playername','$role','$kd','$winrate','$avgdamage','$avgsurvive','$activetime','$previousachiv')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "Data entered";
            header("Location:athelete_profile.php");
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
    <link rel="stylesheet" href="freefire.css">
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
                <a href="games.php"><button class="bt2">BGMI</button></a>
                <a href="valorant.php"><button class="bt2">Valorant</button></a>
                <a href="freefire.php"><button class="bt1">Free Fire</button></a>
                <a href="pokemon.php"><button class="bt2">Pokemon Unite</button></a>
            </div>
            <div class="form-container">
                <h1>Enter your game details</h1>
                <form action="freefire.php" method="post">
                    <input type="text" name="id" value="<?php echo $row['atheleteid']; ?>" hidden>

                    <label for="pid">Player ID</label>
                    <input type="number" id="pid" name="playerid" placeholder="Enter Player ID">

                    <label for="pname">Player Name</label>
                    <input type="text" id="pname" name="playername" placeholder="Enter Player Name">

                    <label for="prole">Role</label>
                    <input type="text" id="prole" name="role" placeholder="Enter your role">

                    <label for="kdr">K.D Ratio</label>
                    <input type="text" id="kdr" name="kd" placeholder="Your K.D Ratio">

                    <label for="wrate">Win Rate</label>
                    <input type="number" id="wrate" name="win" placeholder="Enter Win Rate">

                    <label for="avgdmg">Average Damage</label>
                    <input type="number" id="avgdmg" name="damage" placeholder="Enter Avg Damage">


                    <label for="survivetime">Average Survive Time</label>
                    <input type="text" id="survivetime" name="survive" placeholder="Average Survive Time">


                    <label for="activetime">Active Time</label>
                    <input type="text" id="activetime" name="active" placeholder="Your Active Time in Game">

                    <label for="win">If Any Previous Tournment which you won or Dominated Add those details here !!!</label>
                    <textarea id="win" name="bio" rows="4" placeholder="Your Achivements..."></textarea>

                    <input class="btn" type="submit" name="submit">
                </form>
            </div>
        </div>
    </div>
</body>

</html>