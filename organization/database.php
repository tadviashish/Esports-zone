<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esports";
$conn = mysqli_connect($servername,$username,$password,$dbname);
if(!$conn)
{
    echo "Error to connect" + mysqli_connect_errno();
}
else{
    // echo "Connected";
}

?>