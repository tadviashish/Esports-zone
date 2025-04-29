<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESport-Zone</title>
    <link rel="stylesheet" href="admin_msg.css">
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
                <a href="admin.php"><button class="nav-button">Atheletes</button></a>
                <a href="admin_org.php"><button class="nav-button">Organozations</button></a>
                <a href="admin_msg.php"><button class="active">Messages</button></a>
                <span class="logout">
                    <a href="logout.php"><button>LOGOUT</button></a>
                </span>
            </nav>
        </aside>

        <div class="profile2">
            <h2>Messages</h2>

        </div>
    </div>
</body>

</html>