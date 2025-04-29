<?php
require("database.php");

$q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

$sql = "SELECT * FROM org_data WHERE orgname LIKE '%$q%'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<li class="athlete-item">
                <input type="checkbox" name="delete_ids[]" value="' . $row['orgid'] . '">
                <span class="athlete-name">' . $row['orgname'] . '</span>
                <a href="admin_view_org.php?id=' . $row['orgid'] . '">View Details</a>
                <a href="deleteorg.php?id=' . $row['orgid'] . '">Delete</a>
              </li>';
    }
} else {
    echo "<li class='athlete-item'>No results found</li>";
}
?>
