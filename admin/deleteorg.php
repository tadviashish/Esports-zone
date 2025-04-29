<?php
require("database.php");

if (isset($_GET['id'])) {
    $orgid = $_GET['id'];

    $sql = "DELETE FROM org_data WHERE orgid = '$orgid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>
                alert('Organization deleted successfully! 🗑️');
                window.location.href = 'admin_org.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error deleting organization: " . mysqli_error($conn) . "');
                window.location.href = 'admin_org.php';
              </script>";
    }
} else {
    echo "<script>
            alert('No ID provided to delete ❌');
            window.location.href = 'admin_org.php';
          </script>";
}
?>
