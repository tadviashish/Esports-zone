<?php
require("database.php");
session_start();
//echo $_SESSION['user'];
//echo $_SESSION['mobile'];

if (isset($_SESSION["user"]) && $_SESSION["pass"]) {

    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
        $sql = "SELECT * FROM athelete_data WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $id =  $row['atheleteid'];


        // $sql1 = "SELECT * FROM bgmi WHERE atheleteid = '$id' LIMIT 1";
        // $result1 = mysqli_query($conn, $sql1);
        // $row1 = mysqli_fetch_assoc($result1);
        // $bgmiid =  $row1['bgmiid'];
        //echo $id;
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
    <link rel="stylesheet" href="athelete_profile.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->

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
                <a href="athelete_profile.php"><button class="active">Profile</button></a>
                <a href="athelete_edit-profile.php"><button class="nav-button">Edit Profile</button></a>
                <a href="upload.php"><button class="nav-button">Upload</button></a>
                <a href="games.php"><button class="nav-button">Games</button></a>
                <a href="search_org.php"><button class="nav-button">Search Org</button></a>
                <a href="inquiries.php"><button class="nav-button">Inquiries</button></a>
                <span class="logout">
                    <a href="logout.php"><button>LOGOUT</button></a>
                </span>
            </nav>
        </aside>

        <div class="profile2">
            <div class="userprofile">
                <div class="userinfo">
                    <img src="<?php echo $row['profile']; ?>" alt="">
                    <div class="name">
                        <p><?php echo $row['name']; ?></p>
                        <p><?php echo $row['username']; ?></p>
                    </div>
                </div>
                <div class="bio">
                    <p><b><?php echo $row['bio']; ?></b></p>
                </div>
            </div>
            <div class="game-details">
                <h2>Game Details</h2>
                <?php
                $games = ['bgmi', 'freefire', 'pokemon', 'valorant'];
                $row1 = null;

                foreach ($games as $game) {
                    $sql1 = "SELECT * FROM $game WHERE atheleteid = '$id' LIMIT 1";
                    $result1 = mysqli_query($conn, $sql1);

                    if ($result1 && mysqli_num_rows($result1) > 0) {
                        $row1 = mysqli_fetch_assoc($result1);
                        $detected_game = $game; // save the game table name
                        break; // stop after finding first available game
                    }
                }

                if (!$row1) {
                    echo "<p style='color:red; font-weight:bold;'>Game details not found for this player 😞</p>";
                    return;
                }
                ?>
                <p id='gametitle'><strong><?php echo strtoupper($detected_game); ?></strong></p>
                <?php if ($game === 'bgmi') { ?>
                    <div class="gameinfo">
                        <p><strong>BGMI ID:</strong> <?= $row1['gameid'] ?></p>
                        <p><strong>In-game Name:</strong> <?= $row1['ingamename'] ?></p>
                        <p><strong>Role:</strong> <?= $row1['role'] ?></p>
                        <p><strong>Finish Ratio:</strong> <?= $row1['fratio'] ?></p>
                        <p><strong>Win Ratio:</strong> <?= $row1['wratio'] ?></p>
                        <p><strong>Play Time:</strong> <?= $row1['playtime'] ?></p>
                        <p><strong>Average Time:</strong> <?= $row1['avgtime'] ?></p>
                        <p><strong>Previous Experience:</strong> <?= $row1['previousexp'] ?></p>
                    </div>

                <?php } elseif ($game === 'freefire') { ?>
                    <div class="gameinfo">
                        <p><strong>Free Fire ID:</strong> <?= $row1['ffgameid'] ?></p>
                        <p><strong>In-game Name:</strong> <?= $row1['ingamename'] ?></p>
                        <p><strong>Role:</strong> <?= $row1['role'] ?></p>
                        <p><strong>K/D Ratio:</strong> <?= $row1['kdratio'] ?></p>
                        <p><strong>Win Ratio:</strong> <?= $row1['wratio'] ?></p>
                        <p><strong>Average Damage:</strong> <?= $row1['avgdamage'] ?></p>
                        <p><strong>Average Time:</strong> <?= $row1['avgstime'] ?></p>
                        <p><strong>Active Time:</strong> <?= $row1['activetime'] ?></p>
                        <p><strong>Previous Experience:</strong> <?= $row1['previusexp'] ?></p>
                    </div>

                <?php } elseif ($game === 'pokemon') { ?>
                    <div class="gameinfo">
                        <p><strong>Trainer ID:</strong> <?= $row1['gameid'] ?></p>
                        <p><strong>Trainer Name:</strong> <?= $row1['ingamename'] ?></p>
                        <p><strong>Role:</strong> <?= $row1['role'] ?></p>
                        <p><strong>Average Points:</strong> <?= $row1['avgscore'] ?></p>
                        <p><strong>Win Rate:</strong> <?= $row1['wrate'] ?></p>
                        <p><strong>No. of Battles:</strong> <?= $row1['noofbattle'] ?></p>
                        <p><strong>Active Time:</strong> <?= $row1['activetime'] ?></p>
                        <p><strong>Previous Experience:</strong> <?= $row1['previousexp'] ?></p>
                    </div>

                <?php } elseif ($game === 'valorant') { ?>
                    <div class="gameinfo">
                        <p><strong>Game ID:</strong> <?= $row1['playerid'] ?></p>
                        <p><strong>In-game Name:</strong> <?= $row1['ingamename'] ?></p>
                        <p><strong>Role:</strong> <?= $row1['role'] ?></p>
                        <p><strong>Peak Rank:</strong> <?= $row1['peakrank'] ?></p>
                        <p><strong>ACS:</strong> <?= $row1['acs'] ?></p>
                        <p><strong>ADR:</strong> <?= $row1['adr'] ?></p>
                        <p><strong>K/D Ratio:</strong> <?= $row1['kdratio'] ?></p>
                        <p><strong>Active Hours:</strong> <?= $row1['activehour'] ?></p>
                        <p><strong>Previous Experience:</strong> <?= $row1['previousachiv'] ?></p>
                    </div>

                <?php } else { ?>
                    <p><strong>No valid game selected.</strong></p>
                <?php } ?>

            </div>


            <div class="socials">
                <div class="insta"><a href="<?php echo $row['instagram']; ?>"><img src="../img/Instagram_icon.png" alt=""></a></div>
                <div class="yt"><a href="<?php echo $row['youtube']; ?>"><img src="../img/youtube-logo-red-hd-13.png" alt=""></a></div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">

</script>

</html>