<?php
require("database.php");
session_start();

if (isset($_SESSION['user']) && $_SESSION['pass']) {
    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
        $sql = "SELECT * FROM org_data WHERE contactno = '$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $id =  $row['orgid'];
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
    <link rel="stylesheet" href="recruit.css">
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
            <div class="box">
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
                <h3>Suggestions</h3>
                <?php
                $sql = "SELECT * FROM athelete_data ORDER BY RAND() LIMIT 1";
                $result = mysqli_query($conn, $sql);

                if ($row = mysqli_fetch_assoc($result)) {
                    $img = $row['profile']; // e.g. stored as 'rega.jpg'
                    $name = $row['name'];
                    $id = $row['atheleteid'];
                ?>
                    <div class="atheletes">
                        <div class="org">
                            <img src="../athelete/<?php echo $img; ?>" alt="profile">
                            <h4><?php echo $name; ?></h4>
                        </div>
                        <div class="org2">
                            <p><b>Ask Athelete to join your Organization</b></p>
                            <!-- <a href="recruit.php?athelete=<?php echo $id; ?>">Recruitt</a> -->
                            <a href="userprofile.php?athelete=<?php echo $id; ?>">Visit Profile</a>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
    </div>
</body>

</html>