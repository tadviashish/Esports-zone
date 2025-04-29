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
    <link rel="stylesheet" href="admin.css">
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
            <h2>Atheletes</h2>
            <div class="search-bar">
                <label for="search">Search</label>
                <input type="text" id="search" placeholder="Search Athlete">
            </div>
            <form action="delete_multiple.php" method="POST">
            <input type="submit" name="delete_btn" value="Delete Selected" class="delete-button">
                <ul class="athlete-list" id="athlete-results">
                    <?php
                    $sql = "SELECT * FROM athelete_data";
                    $rows = mysqli_query($conn, $sql);
                    foreach ($rows as $row) {
                    ?>
                        <li class="athlete-item">
                            <input type="checkbox" name="delete_ids[]" value="<?php echo $row['atheleteid']; ?>">
                            <span class="athlete-name"><?php echo $row['name']; ?></span>
                            <a href="admin_view_athelete.php?id=<?php echo $row['atheleteid']; ?>">View Details</a>
                            <a href="deleteathelete.php?id=<?php echo $row['atheleteid']; ?>">Delete</a>
                        </li>
                    <?php } ?>
                </ul>
            </form>

            <div class="pagination" id="pagination">
                <?php
                $total_sql = "SELECT COUNT(*) FROM athelete_data";
                $result = mysqli_query($conn, $total_sql);
                $row = mysqli_fetch_row($result);
                $total_records = $row[0];
                $limit = 5;
                $total_pages = ceil($total_records / $limit);

                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a href='?page=$i'><button class='page-button'>$i</button></a> ";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("search").addEventListener("keyup", function() {
            let query = this.value;
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "search_athelete.php?q=" + encodeURIComponent(query), true);
            xhr.onload = function() {
                if (this.status == 200) {
                    document.getElementById("athlete-results").innerHTML = this.responseText;
                }
            };
            xhr.send();
        });
    </script>

</body>

</html>
