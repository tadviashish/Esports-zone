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

    if (isset($_GET['athelete'])) {
        $aid = $_GET['athelete'];
    }

    if (isset($_GET['game'])) {
        $game = $_GET['game'];
        echo $game;
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
    <link rel="stylesheet" href="userprofile.css">
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
                <h3>Athelete Profile</h3>
                <div class="content">
                    <?php
                    $search = $_SESSION['search'];
                    $game = $_SESSION['game'];
                    $sql = "SELECT * FROM athelete_data WHERE atheleteid = '$aid'";
                    $rows = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($rows) > 0) {
                        foreach ($rows as $row): ?>
                            <div class="result">
                                <div class="atheletedata">
                                    <div class="userprofile">
                                        <img src="../athelete/<?php echo $row['profile']; ?>" alt="Profile image">
                                        <li>
                                            
                                                <span style="font-weight: bold; color: black;"><?php echo $row['name']; ?></span>
                                                <span style="font-weight: bold; color: black;"><?php echo $row['username']; ?></span>
                                            
                                        </li>
                                    </div>
                                    <div class="bio">
                                        <p><?php echo $row['bio']; ?></p>
                                    </div>
                                </div>
                        <?php
                        endforeach;
                    } else {
                        // echo "<b>" . "User Not found try another name or username" . "</b>";
                    }

                        ?>
                        <div class="post">
                            <?php
                            $sql = "SELECT * FROM uploadpost WHERE atheleteid = '$aid'";
                            $image = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($image) > 0) {
                                foreach ($image as $img): ?>

                                    <div class="image-box" onclick="openPopup('../athelete/<?php echo $img['post']; ?>')">
                                        <img src="../athelete/<?php echo $img['post']; ?>" alt="post image">
                                    </div>
                            <?php
                                endforeach;
                            } else {
                                echo "<b>" . "User Not found try another name or username" . "</b>";
                            }

                            ?>
                        </div>

                        <h2>Game Details</h2>
                        <p id="gametitle"><strong><?php echo strtoupper($game); ?></strong></p>
                        <?php
                        $sql1 = "SELECT * FROM $game WHERE atheleteid = '$aid' LIMIT 1";
                        $result1 = mysqli_query($conn, $sql1);
                        $row1 = mysqli_fetch_assoc($result1);
                        ?>

                        <?php if ($game == 'bgmi') { ?>
                            <div class="gameinfo">
                                <p><strong>BGMI ID:</strong> <?php echo $row1['gameid']; ?></p>
                                <p><strong>In-game Name:</strong> <?php echo $row1['ingamename']; ?></p>
                                <p><strong>Role:</strong> <?php echo $row1['role']; ?></p>
                                <p><strong>Finish Ratio:</strong> <?php echo $row1['fratio']; ?></p>
                                <p><strong>Win Ratio:</strong> <?php echo $row1['wratio']; ?></p>
                                <p><strong>Play Time:</strong> <?php echo $row1['playtime']; ?></p>
                                <p><strong>Average Time:</strong> <?php echo $row1['avgtime']; ?></p>
                                <p><strong>Previous Experience:</strong> <?php echo $row1['previousexp']; ?></p>
                            </div>

                        <?php } elseif ($game == 'freefire') { ?>
                            <div class="gameinfo">
                                <p><strong>Free Fire ID:</strong> <?php echo $row1['ffgameid']; ?></p>
                                <p><strong>In-game Name:</strong> <?php echo $row1['ingamename']; ?></p>
                                <p><strong>Role</strong> <?php echo $row1['role']; ?></p>
                                <p><strong>K/D Ratio:</strong> <?php echo $row1['kdratio']; ?></p>
                                <p><strong>Win Ratio:</strong> <?php echo $row1['wratio']; ?></p>
                                <p><strong>Average Damage</strong> <?php echo $row1['avgdamage']; ?></p>
                                <p><strong>Average Time</strong> <?php echo $row1['avgstime']; ?></p>
                                <p><strong>Active Time</strong> <?php echo $row1['activetime']; ?></p>
                                <p><strong>Previous Experience</strong> <?php echo $row1['previusexp']; ?></p>
                            </div>

                        <?php } elseif ($game == 'pokemon') { ?>
                            <div class="gameinfo">
                                <p><strong>Trainer ID:</strong> <?php echo $row1['gameid']; ?></p>
                                <p><strong>Trainer Name:</strong> <?php echo $row1['ingamename']; ?></p>
                                <p><strong>Role</strong> <?php echo $row1['role']; ?></p>
                                <p><strong>average Points:</strong> <?php echo $row1['avgscore']; ?></p>
                                <p><strong>Win Rate</strong> <?php echo $row1['wrate']; ?></p>
                                <p><strong>No. Of Battle</strong> <?php echo $row1['noofbattle']; ?></p>
                                <p><strong>Active Time</strong> <?php echo $row1['activetime']; ?></p>
                                <p><strong>Previous Experience</strong> <?php echo $row1['previousexp']; ?></p>
                            </div>

                        <?php } elseif ($game == 'valorant') { ?>
                            <div class="gameinfo">
                                <p><strong>Game ID:</strong> <?php echo $row1['playerid']; ?></p>
                                <p><strong>Ingame Name</strong> <?php echo $row1['ingamename']; ?></p>
                                <p><strong>Role</strong> <?php echo $row1['role']; ?></p>
                                <p><strong>Peak Rank</strong> <?php echo $row1['peakrank']; ?></p>
                                <p><strong>ACS</strong> <?php echo $row1['acs']; ?></p>
                                <p><strong>ADR</strong> <?php echo $row1['adr']; ?></p>
                                <p><strong>K/D Ratio</strong> <?php echo $row1['kdratio']; ?></p>
                                <p><strong>Active Hours</strong> <?php echo $row1['activehour']; ?></p>
                                <p><strong>Previous Experience</strong> <?php echo $row1['previousachiv']; ?></p>
                            </div>
                        <?php } else { ?>
                            <p>No valid game selected.</p>
                        <?php } ?>

                            </div>

                            <p id="gametitle"><strong>Social Handles</strong></p>
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

        <div id="popup" onclick="closePopup()">
            <span class="close-btn" onclick="closePopup()">×</span>
            <img id="popup-img" src="" alt="Full Image">
        </div>


        <script>
            function openPopup(src) {
                document.getElementById("popup-img").src = src;
                document.getElementById("popup").style.display = "flex";
            }

            function closePopup() {
                document.getElementById("popup").style.display = "none";
            }

            function closePopup() {
                document.getElementById("popup").style.display = "none";
            }
        </script>

</body>

</html>