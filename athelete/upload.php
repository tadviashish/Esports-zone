<?php
require("database.php");
session_start();
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $sql = "SELECT * FROM athelete_data WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id =  $row['atheleteid'];

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESport-Zone</title>
    <link rel="stylesheet" href="upload.css">
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
                <a href="upload.php"><button class="active">Upload</button></a>
                <a href="games.php"><button class="nav-button">Games</button></a>
                <a href="search_org.php"><button class="nav-button">Search Org</button></a>
                <a href="inquiries.php"><button class="nav-button">Inquiries</button></a>
                <span class="logout">
                    <a href="logout.php"><button>LOGOUT</button></a>
                </span>
            </nav>
        </aside>

        <div class="profile2">
            <div class="upload-section">
                <div class="upload-box" id="post">
                    <input type="file" name="post" id="fileInput" hidden accept="video/*,image/*">
                    <span>+</span>
                </div>
                <div class="post">
                    <?php
                    $sql = "SELECT * FROM uploadpost WHERE atheleteid = '$id'";
                    $image = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($image) > 0) {
                        foreach ($image as $img):
                            $post = $img['post'];
                            $extension = strtolower(pathinfo($post, PATHINFO_EXTENSION));
                            $videoExtensions = ['mp4', 'webm'];
                    ?>
                            <div class="image-box" onclick="openPopup('<?php echo $post; ?>')">
                                <?php if (in_array($extension, $videoExtensions)): ?>
                                    <video src="<?php echo $post; ?>" width="100%" height="auto" controls ></video>
                                <?php else: ?>
                                    <img src="<?php echo $post; ?>" alt="post image">
                                <?php endif; ?>

                                <div class="menu2" onclick="event.stopPropagation();">
                                    <div class="dots" onclick="toggleMenu(this)">⋮</div>
                                    <div class="menu2-options">
                                        <button onclick="deleteImage(this, '<?php echo $img['postid']; ?>')">Delete</button>
                                    </div>
                                </div>
                            </div>

                    <?php
                        endforeach;
                    } else {
                        echo "<b>User Not found, try another name or username</b>";
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>

    </div>


    <div id="popup" onclick="closePopup()">
        <span class="close-btn" onclick="closePopup()">×</span>
        <img id="popup-img" src="" alt="Full Image" style="display: none;">
        <video id="popup-video" controls autoplay style="display: none;">
            <source id="popup-video-source" src="" type="">
            Your browser does not support the video tag.
        </video>
    </div>


    <script>
        function openPopup(src) {
            const popup = document.getElementById("popup");
            const img = document.getElementById("popup-img");
            const video = document.getElementById("popup-video");
            const videoSource = document.getElementById("popup-video-source");
            const extension = src.split('.').pop().toLowerCase();
            const videoTypes = ['mp4', 'webm', 'ogg'];

            if (videoTypes.includes(extension)) {
                img.style.display = "none";
                video.style.display = "block";
                videoSource.src = src;
                video.load(); 
                video.play(); 
            } else {

                video.style.display = "none";
                img.style.display = "block";
                img.src = src;
            }

            popup.style.display = "flex";
        }


        function closePopup() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("popup-video").pause();
        }


        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }
        let athleteID = <?php echo $row['atheleteid']; ?>; // Change this to dynamic athlete ID

        document.getElementById("post").addEventListener("click", function() {
            document.getElementById("fileInput").click();
        });

        document.getElementById("fileInput").addEventListener("change", function(event) {
            let file = event.target.files[0];
            if (!file) return;

            let reader = new FileReader();
            reader.onload = function() {
                document.getElementById("post").src = reader.result;
            };
            reader.readAsDataURL(file);


            // Upload image to server
            let formData = new FormData();
            formData.append("image", file);
            formData.append("athleteID", athleteID);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "uploadpost.php", true);

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


        function toggleMenu(dotElement) {
            const menu = dotElement.nextElementSibling;
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        function deleteImage(buttonElement, postId) {
            const imageBox = buttonElement.closest('.image-box');


            alert("Delete image: ");


            imageBox.remove();
        }


        function deleteImage(btn, postid) {
            if (confirm("Are you sure you want to delete this photo? 😢")) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_post.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        if (xhr.responseText.trim() === "Deleted") {
                            const imageBox = btn.closest(".image-box");
                            imageBox.remove();
                            alert("Image deleted successfully! 🗑️✨");
                        } else {
                            alert("Error: " + xhr.responseText);
                        }
                    }
                };

                xhr.send("postid=" + postid);
            }
        }
        window.onclick = function(event) {
            if (!event.target.matches('.dots')) {
                document.querySelectorAll('.menu-options').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        };
    </script>
</body>

</html>