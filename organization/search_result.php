<?php
require("database.php");
session_start();

if (isset($_SESSION['user']) && $_SESSION['pass']) {
    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
        $sql = "SELECT * FROM org_data WHERE contactno = '$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row['orgid'];
    }

    if (isset($_GET['submit'])) {
        $search = $_GET['searchinfo'];
        $games = $_GET['games'];
        $game1 = strtolower(str_replace(' ', '', $games));
        $_SESSION['search'] = $search;
        $_SESSION['game'] = $game1;
        // echo $search;
        echo $game1;
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
    <link rel="stylesheet" href="search_org.css">
    <link rel="stylesheet" href="search_result.css">
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
                <h2><?php echo $row['orgname']; ?></h2>
            </div>
            <nav class="menu">
                <a href="org_profile.php"><button class="nav-button">Profile</button></a>
                <a href="org_editprofile.php"><button class="nav-button">Edit Profile</button></a>
                <a href="recruit.php"><button class="active">Recruit</button></a>
                <a href="requests.php"><button class="nav-button">Requests</button></a>
                <span class="logout">
                    <a href="logout.php"><button>LOGOUT</button></a>
                </span>
            </nav>
        </aside>

        <div class="profile2">
            <div class="search-bar">
                <h3>Search an Athelete</h3>
                <form action="search_result.php" method="get">
                    <select name="games" id="game">
                        <option value="OPTION">SELECT GAME</option>
                        <option value="BGMI">BGMI</option>
                        <option value="FREE FIRE">FREE FIRE</option>
                        <option value="VALORANT">VALORANT</option>
                        <option value="POKEMON">POKEMON</option>
                    </select>
                    <input type="text" id="search" name="searchinfo" placeholder="Enter Athelete Name">
                    <input id="searchbutton" type="submit" name="submit">
                </form>

                <div class="content">
                    <?php
                    $search = $_SESSION['search'];
                    $game = $_SESSION['game'];
                    if ($game != 'option') {
                    $sql = "SELECT a.atheleteid, a.name, a.profile, a.username 
                    FROM athelete_data a 
                    JOIN $game g ON a.atheleteid = g.atheleteid 
                    WHERE a.name LIKE '%$search%'
                    GROUP BY a.atheleteid";
                    $rows = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($rows) > 0) {
                        foreach ($rows as $row): ?>
                            <div class="result">
                                <div class="atheleteinfo">
                                    <img src="../athelete/<?php echo $row['profile']; ?>" alt="Profile image">
                                    <li>
                                    <a href="userprofile.php?athelete=<?php echo $row['atheleteid']; ?>&game=<?php echo $game; ?>">
                                            <b><?php echo $row['name']; ?></b>
                                            <b><?php echo $row['username']; ?></b>
                                        </a>
                                    </li>
                                </div>
                            </div> 
                    <?php
                        endforeach;
                    } else {
                        echo "<b>User not found. Try another name or username.</b>";
                    }

                }
                else{
                    $sql2 = "SELECT * FROM org_data WHERE orgname LIKE '%$search%'";
                    $orgs = mysqli_query($conn, $sql2);
                
                    if (!$orgs) {
                        die("Query Failed: " . mysqli_error($conn));
                    }
                    if (mysqli_num_rows($orgs) > 0) {
                        while ($org = mysqli_fetch_assoc($orgs)) {
                            echo "<div class='orgresult'>";
                            ?>
                            <div class="result">
                                <div class="orginfo">
                                    <img src="<?php echo $org['profile']; ?>" alt="Profile image">
                                    <li>
                                    <a href="orgresult.php?org=<?php echo $org['orgid']; ?>&orgname=<?php echo $org['orgname']; ?>">
                                            <b><?php echo $org['orgname']; ?></b>
                                            <b><?php echo $org['ownername']; ?></b>
                                        </a>
                                    </li>
                                </div>
                            </div> 
                            <?php
                        }
                    } else {
                        echo "<p>No organization found for '$search' 😔</p>";
                    }
                }
                    ?>
                </div>
            </div>
        </div>
</body>

</html>