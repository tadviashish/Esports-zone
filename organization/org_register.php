<?php
require("database.php");


if(isset($_POST['submit']))
{
    $orgname = $_POST['orgname'];
    $pass = $_POST['password'];
    $oname = $_POST['ownername'];
    $discord = $_POST['discord'];
    $contactno = $_POST['contactno'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    
   $errors = [];
   if (!preg_match("/^[0-9]{10}$/", $contactno)) {
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
        window.location.href = 'org_register.php';
    </script>";
    exit();
   }

    $sql = "SELECT contactno FROM org_data WHERE contactno = '$contactno'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 0) {

      $sql =  "INSERT INTO org_data(orgname, password, ownername, discord, contactno, email, address) VALUES ('$orgname','$pass','$oname','$discord','$contactno','$email','$address')";
      $result = mysqli_query($conn, $sql);
      if ($result) 
      {
        echo "Register Success";
        session_start();
        $_SESSION['user'] = $orgname;
        $_SESSION['pass'] = $pass;
        $_SESSION['mobile'] = $contactno;
        header("refresh:2;url=org_profile.php");
      } else 
      {
        echo "The record was not inserted successfully " . mysqli_error($conn);
      }
    } 
    else 
    {
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
    <link rel="stylesheet" href="org_register.css">
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
            <form action="org_register.php" method="post">
                <label>ORGANIZATION NAME</label>
                <input type="text" name="orgname" placeholder="Enter org-name">
                
                <label>PASSWORD</label>
                <input type="password" name="password" placeholder="Enter password">
                
                <label>OWNER NAME</label>
                <input type="text" name="ownername" placeholder="Enter Owner Name">
                
                <label>DISCORD</label>
                <input type="text" name="discord" placeholder="Enter Discord ID">
                
                <label>CONTACT</label>
                <input type="text" name="contactno" placeholder="Enter contact number">
                
                <label>E-mail</label>
                <input type="email" name="email" placeholder="Enter email">

                <label>Address</label>
                  <textarea rows="4" cols="50" name="address" placeholder="Address"></textarea>
                
                <button type="submit" name="submit">REGISTER</button>
            </form>
            <p>Already have an Account? <a href="../index.php">Sign-in</a></p>
        </div>
        <a href="../athelete/atheleteregistration.php" class="org-register">Register as an Athelete</a>
    </div>
</body>
</html>
