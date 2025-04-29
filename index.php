<?php
require('database.php');

$login = true;
if (isset($_POST['submit'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $pass = mysqli_real_escape_string($conn, $_POST['password']);

  if ($username != "" && $pass != "") {

    $sql = "SELECT username, password FROM athelete_data WHERE username = '$username' AND password = '$pass'";
    $result = mysqli_query($conn, $sql);
    $athelete = mysqli_num_rows($result);


    $sql = "SELECT contactno, password FROM org_data WHERE contactno = '$username' AND password = '$pass'";
    $result = mysqli_query($conn, $sql);
    $org = mysqli_num_rows($result);

    $sql = "SELECT username, password FROM admin WHERE username = '$username' AND password = '$pass'";
    $result = mysqli_query($conn, $sql);
    $admin = mysqli_num_rows($result);



    if ($athelete == 1) {
      session_start();
      $_SESSION['user'] = $username;
      $_SESSION['pass'] = $pass;
      header("Location:./athelete/athelete_profile.php");
    } else {
      $login = false;
    }


    if ($org == 1) {
      session_start();
      $_SESSION['user'] = $username;
      $_SESSION['pass'] = $pass;
      $_SESSION['mobile'] = $username;
      header("Location:./organization/org_profile.php");
    } else {
      $login = false;
    }

    if ($admin == 1) {
      session_start();
      $_SESSION['user'] = $username;
      $_SESSION['pass'] = $pass;
      header("Location:./admin/admin.php");
    } else {
      $login = false;
    }
  } else {
    echo "Enter Mobile or Password";
  }
}
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ESport-Zone Login</title>
  <link rel="stylesheet" href="./login.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>

  </style>
</head>

<body>
  <?php
  if ($login == false) {
  ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Warning !!</strong> You should check your username or Password.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php

  }
  ?>
  <header>
    <h1>ESport-Zone</h1>
    <nav>
      <a href="about.php">about</a> | <a href="contact.php">contact</a>
    </nav>

  </header>
  <div class="login-box">

    <h2>LOGIN</h2>
    <form method="post" action="index.php">
      <label for="username">USERNAME</label>
      <input type="text" id="username" name="username" placeholder="USERNAME" required>
      <label for="password">PASSWORD</label>
      <input type="password" id="password" name="password" placeholder="PASSWORD" required>
      <input type="submit" name="submit">
    </form>
    <p>Don't have an Account? <a href="./athelete/atheleteregistration.php">Sign-up</a></p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">

  </script>
</body>

</html>