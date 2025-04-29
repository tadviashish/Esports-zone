<?php
require("database.php");
session_start();

if (isset($_SESSION['user']) && $_SESSION['pass']) {

    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
        $contact = $_SESSION['mobile'];
        $sql = "SELECT * FROM org_data WHERE contactno = '$contact'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $id =  $row['orgid'];
    }


    if (isset($_POST['submit'])) {
        $orgid = $_POST['id']; // Hidden org ID
        $password = $_POST['password']; // Hidden org ID
        $orgname = $_POST['name'];
        $ownername = $_POST['username'];
        $discord = $_POST['discord'];
        $contactno = $_POST['mobile'];
        $email = $_POST['email'];
        $instagram = $_POST['instagram'];
        $youtube = $_POST['youtube'];
        $bio = $_POST['bio'];
        echo $contactno;
        $sql = "UPDATE org_data SET orgname='$orgname', ownername='$ownername', discord='$discord', contactno='$contactno', email='$email', instagram='$instagram', youtube='$youtube', bio='$bio' WHERE orgid='$orgid'";
        $result = mysqli_query($conn, $sql);
        $_SESSION['user'] = $contactno;
        $_SESSION['pass'] = $password;
        if ($result) {
            header("Location:org_profile.php");
        } else {
            echo mysqli_error($conn);
        }
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
    <link rel="stylesheet" href="org_editprofile.css">
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
                <a href="org_editprofile.php"><button class="active">Edit Profile</button></a>
                <a href="recruit.php"><button class="nav-button">Recruit</button></a>
                <a href="requests.php"><button class="nav-button">Requests</button></a>
                <span class="logout">
                    <a href="logout.php"><button>LOGOUT</button></a>
                </span>
            </nav>
        </aside>

        <div class="profile2">
            <img id="profileImage" src="<?php echo $row['profile']; ?>" alt="Profile Image">
            <input type="file" id="fileInput" accept="image/*" style="display: none;">
            <p><b>Change Profile Picture</b></p>
            
            <div class="form-container">
                <form action="org_editprofile.php" method="post">

                    <input type="text" id="oid" name="id" value="<?php echo $row['orgid']; ?>" hidden>
                    <input type="text" id="oid" name="password" value="<?php echo $row['password']; ?>" hidden>


                    <label for="name">Change Org-Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['orgname']; ?>" placeholder="Enter your org-name">

                    <label for="username">Change Owner Name</label>
                    <input type="text" id="username" name="username" value="<?php echo $row['ownername']; ?>" placeholder="Enter your owner name">

                    <label for="discord">Change Discord</label>
                    <input type="text" id="discord" name="discord" value="<?php echo $row['discord']; ?>" placeholder="Enter your Discord Server">

                    <label for="mobile">Change Contact</label>
                    <input type="text" id="mobile" name="mobile" value="<?php echo $row['contactno']; ?>" placeholder="Enter your contact number">


                    <label for="email">Change E-mail</label>
                    <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" placeholder="Enter your email">

                    <label for="instagram">Add Instagram Link</label>
                    <input type="url" id="instagram" name="instagram" value="<?php echo $row['instagram']; ?>" placeholder="Enter Instagram link">

                    <label for="youtube">Add YouTube Link</label>
                    <input type="url" id="youtube" name="youtube" value="<?php echo $row['youtube']; ?>" placeholder="Enter YouTube link">

                    <label for="bio">Change or Add Bio</label>
                    <textarea id="bio" name="bio" rows="4" value="<?php echo $row['bio']; ?>" placeholder="Write your bio here..."><?php echo $row['bio']; ?></textarea>

                    <input class="btn" type="submit" name="submit" value="submit">
                </form>
            </div>
        </div>
    </div>

    <script>
        let orgid = <?php echo $row['orgid']; ?>; // Change this to dynamic athlete ID

        document.getElementById("profileImage").addEventListener("click", function() {
            document.getElementById("fileInput").click();
        });

        document.getElementById("fileInput").addEventListener("change", function(event) {
            let file = event.target.files[0];
            if (!file) return;

            let reader = new FileReader();
            reader.onload = function() {
                document.getElementById("profileImage").src = reader.result;
            };
            reader.readAsDataURL(file);


            // Upload image to server
            let formData = new FormData();
            formData.append("image", file);
            formData.append("orgid", orgid);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "uploads.php", true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    let response = JSON.parse(xhr.responseText);
                    if (response.status === "success") {
                        alert("Image uploaded successfully!");
                    } else {
                        alert("Upload failed: " + response.message);
                    }
                }
            };

            xhr.send(formData);
        });
    </script>

</body>

</html>