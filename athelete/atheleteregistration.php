<?php
require("database.php");
session_start();


if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $pass = $_POST['password'];
  $name = $_POST['name'];
  $birthday = $_POST['birthday'];
  $discord = $_POST['discord'];
  $mobile = $_POST['mobile'];
  $email = $_POST['email'];
  $address = $_POST['address'];

   $errors = [];
   if (!preg_match("/^[0-9]{10}$/", $mobile)) {
       $errors[] = "Mobile number must be exactly 10 digits.";
   }

   if (!filter_var($email, FILTER_VALIDATE_EMAIL) || 
       !(preg_match("/\.(com|in|org)$/", $email))) {
       $errors[] = " Email must be valid and end with .com, .in, or .org";
   }

   if (!empty($errors)) {
    $alertMessage = implode('\n', $errors); 
    echo "<script>
        alert('$alertMessage');
        window.location.href = 'atheleteregistration.php';
    </script>";
    exit();
}

  $sql = "SELECT username FROM athelete_data WHERE username = '$username'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if ($num == 0) {

    $sql =  "INSERT INTO athelete_data(username, password, name, birthday, discord, mobile, email, address) VALUES ('$username','$pass','$name','$birthday','$discord','$mobile','$email','$address')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      echo "Register Success";
      $_SESSION['user'] = $username;
      $_SESSION['pass'] = $pass;
      $_SESSION['mobile'] = $mobile;
      header("refresh:2;url=athelete_profile.php");
    } else {
      echo "The record was not inserted successfully " . mysqli_error($conn);
    }
  } else {
    echo "Account Found";
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ESport-Zone Registration</title>
  <link rel="stylesheet" href="atheleteregistration.css">

</head>

<body>
  <div class="container">
    <header>
      <h1>ESport-Zone</h1>
      <nav>
        <a href="../about.php">about</a> | <a href="../contact.php">contact</a>
      </nav>
    </header>
    <div class="form-container">
      <h2>REGISTER</h2>
      <form method="post" action="atheleteregistration.php">

        <input type="text" id="username" name="username" placeholder="Enter username" required>
        <small id="username-status"></small>


        <label>PASSWORD</label>
        <input type="password" name="password" placeholder="Enter password" require>

        <label>NAME</label>
        <input type="text" name="name" placeholder="Enter your name" require>

        <label>Date Of Birth</label>
        <input type="date" name="birthday">

        <label>DISCORD</label>
        <input type="text" name="discord" placeholder="Enter Discord ID" require>

        <label>Mobile</label>
        <input type="text" name="mobile" placeholder="Enter mobile number" require>

        <label>E-mail</label>
        <input type="email" name="email" placeholder="Enter email" require>

        <label>Address</label>
        <textarea rows="4" cols="50" name="address" placeholder="Address" require></textarea>

        <button type="submit" name="submit">REGISTER</button>
      </form>
      <p>Already have an Account? <a href="../index.php">Sign-in</a></p>
    </div>
    <a href="../organization/org_register.php" class="org-register">Register as an Organization</a>
  </div>


  <script>
let timer; // for debounce

document.getElementById("username").addEventListener("input", function () {
    clearTimeout(timer); // clear previous timer
    let username = this.value;

    // run after 1 second of no typing
    timer = setTimeout(function () {
        if (username.length > 0) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "check_username.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                const status = document.getElementById("username-status");
                if (xhr.responseText.trim() === "taken") {
                    status.innerHTML = "<span style='color: red;'>Username already exists 😥</span>";
                } else {
                    status.innerHTML = "<span style='color: green;'>Username available 😊</span>";
                }
            };

            xhr.send("username=" + encodeURIComponent(username));
        } else {
            document.getElementById("username-status").innerHTML = "";
        }
    }, 1000); // 1000ms = 1 second
});
</script>

</body>

</html>