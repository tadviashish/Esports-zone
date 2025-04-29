<?php
require("database.php");

if (isset($_POST['delete_btn']) && isset($_POST['delete_ids'])) {
    $delete_ids = $_POST['delete_ids'];

    foreach ($delete_ids as $id) {
        $id = mysqli_real_escape_string($conn, $id);
        $sql = "DELETE FROM org_data WHERE orgid = '$id'";
        mysqli_query($conn, $sql);
    }

    // header("Location: admin.php?msg=deleted");
    echo "<script>
    alert('Selected Organizations deleted successfully!');
    window.location.href = 'admin_org.php';
</script>";
    exit();

} else {

    header("Location: admin.php?msg=none_selected");
    exit();
}
