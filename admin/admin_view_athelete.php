<?php
require("database.php");
session_start();

if (isset($_SESSION["user"]) && $_SESSION["pass"]) {
    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
        $sql = "SELECT * FROM admin WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $id =  $row['adminid'];
    }

    if (isset($_GET['id'])) {
        $aid = $_GET['id'];
    }
} else {
    header("Location:../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESport-Zone</title>
    <link rel="stylesheet" href="admin_view_athelete.css">
</head>

<body>
    <header>
        <h1>ESport-Zone</h1>
        <nav>
            <a href="admin.php">HOME</a>
        </nav>
    </header>

    <div class="container">
        <aside class="sidebar">
            <div class="profile">
                <img src="../img/admin.png" alt="Profile Image">
                <h2>Admin</h2>
            </div>
            <nav class="menu">
                <a href="admin.php"><button class="active">Atheletes</button></a>
                <a href="admin_org.php"><button class="nav-button">Organozations</button></a>
                <a href="admin_msg.php"><button class="nav-button">Messages</button></a>
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
                        echo "<b>" . "User Not found try another name or username" . "</b>";
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
                        <?php
                        $allowed_games = ['bgmi', 'freefire', 'pokemon', 'valorant'];
                        $game = 'bgmi'; 
                        if (isset($_GET['game']) && in_array($_GET['game'], $allowed_games)) {
                            $game = $_GET['game'];
                        }

                        $id = $_GET['id'] ?? ''; 

                        echo "<p id='gametitle'><strong>" . strtoupper($game) . "</strong></p>";

                        $sql1 = "SELECT * FROM $game WHERE atheleteid = '$id' LIMIT 1";
                        $result1 = mysqli_query($conn, $sql1);
                        $row1 = mysqli_fetch_assoc($result1);
                        ?>

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