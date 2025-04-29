<?php
require("database.php");

if (isset($_GET['id'])) {
    $aid = $_GET['id'];

    $sql = "DELETE FROM athelete_data WHERE atheleteid = '$aid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>
                alert('Athelete deleted successfully! 🗑️');
                window.location.href = 'admin.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error deleting Athelete: " . mysqli_error($conn) . "');
                window.location.href = 'admin.php';
              </script>";
    }
} else {
    echo "<script>
            alert('No ID provided to delete ❌');
            window.location.href = 'admin.php';
          </script>";
}
?>
