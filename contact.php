<?php
require("database.php");
$send = false;
if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $sql = "INSERT INTO contactus (name, phone, email, message) VALUES ('$name', '$phone', '$email', '$message')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $send = true;
    } else {
        $send = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESport-Zone Contact</title>
    <link rel="stylesheet" href="contact.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">


</head>

<body>
    <?php
    if ($send == true) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success ✅</strong> Your message has been submitted successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    <?php

    }

    ?>
    <header>
        <h1>ESport-Zone</h1>
        <nav>
            <a href="index.php">HOME</a>
        </nav>
    </header>
    <section class="contact-section">
        <div class="form-container">
            <h2>Connect With Our Team</h2>
            <p>Fill the form so that our team can reach out to you</p>

            <form action="contact.php" method="POST">
                <label for="name">NAME</label>
                <input type="text" id="name" name="name" required>

                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>

                <label for="email">E-MAIL</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <input id="button" type="submit" name="submit"></input>
            </form>
        </div>
    </section>
    <a href="about.php">
        <button class="about-btn">ABOUT</button>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</body>

</html>