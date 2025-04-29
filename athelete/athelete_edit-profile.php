<?php
require("database.php") ;
session_start();

// echo $_SESSION['user'];
// echo $_SESSION['pass'];

if(isset($_SESSION["user"]) && $_SESSION["pass"])
{

if(isset($_SESSION['user']))
{
    $username = $_SESSION['user'];
    $sql = "SELECT * FROM athelete_data WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id =  $row['atheleteid'];
    // echo $id;
}

if(isset($_POST['submit']))
{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $user = $_POST['username'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $insta = $_POST['instagram'];
    $youtube = $_POST['youtube'];
    $bio = $_POST['bio'];

    $sql = "UPDATE athelete_data SET username='$user',name='$name',mobile='$mobile',email='$email',instagram='$insta',youtube='$youtube',bio='$bio' WHERE atheleteid = $id";
    $result = mysqli_query($conn, $sql);
    $_SESSION['user'] = $user;
    $_SESSION['mobile'] = $mobile;
    if ($result) {
        header("Location:athelete_profile.php");
    } else {
        echo mysqli_error($conn);
    }

}

}
else{
    header("Location:./athelete/athelete_profile.php");
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESport-Zone</title>
    <link rel="stylesheet" href="athelete_edit-profile.css">
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
                <a href="athelete_edit-profile.php"><button class="active">Edit Profile</button></a>
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

            <img id="profileImage" src="<?php echo $row['profile']; ?>" alt="Profile Image">
            <input type="file" id="fileInput" accept="image/*" style="display: none;">
            <p><b>Change Profile Picture</b></p>
            
            <div class="form-container">
                <form method="post" action="athelete_edit-profile.php">
                    <input  type="text"  name="id" value="<?php echo $row['atheleteid']; ?>" hidden>
                    <label for="name">Change Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" placeholder="Enter your name">

                    <label for="username">Change Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>" placeholder="Enter your username">

                    <label for="mobile">Change Mobile</label>
                    <input type="text" id="mobile" name="mobile" value="<?php echo $row['mobile']; ?>" placeholder="Enter your mobile number">

                    <label for="email">Change E-mail</label>
                    <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" >

                    <label for="instagram">Add Instagram Link</label>
                    <input type="url" id="instagram" value="<?php echo $row['instagram']; ?>" name="instagram" placeholder="Enter Instagram link">

                    <label for="youtube">Add YouTube Link</label>
                    <input type="url" id="youtube" name="youtube" value="<?php echo $row['youtube']; ?>" placeholder="Enter YouTube link">

                    <label for="bio">Change or Add Bio</label>
                    <textarea id="bio" name="bio" rows="4" value="" placeholder="Write your bio here..."><?php echo $row['bio']; ?></textarea>

                    <input class="btn" type="submit" name="submit">
                </form>
            </div>
        </div>
    </div>


    <script>

        let athleteID = <?php echo $row['atheleteid']; ?>; // Change this to dynamic athlete ID

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
            formData.append("athleteID", athleteID);

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