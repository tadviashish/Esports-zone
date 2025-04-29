<?php
require("database.php");

if (isset($_POST['delete_btn']) && isset($_POST['delete_ids'])) {
    $delete_ids = $_POST['delete_ids'];

    foreach ($delete_ids as $id) {
        $id = mysqli_real_escape_string($conn, $id);
        $sql = "DELETE FROM athelete_data WHERE atheleteid = '$id'";
        mysqli_query($conn, $sql);
    }

    // header("Location: admin.php?msg=deleted");
    echo "<script>
    alert('Selected athletes deleted successfully!');
    window.location.href = 'admin.php';
</script>";
    exit();

} else {

    header("Location: admin.php?msg=none_selected");
    exit();
}
