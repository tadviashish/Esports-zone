<?php
require("database.php");

$q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

$sql = "SELECT * FROM athelete_data WHERE name LIKE '%$q%'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<li class="athlete-item">
                <input type="checkbox" name="delete_ids[]" value="' . $row['atheleteid'] . '">
                <span class="athlete-name">' . $row['name'] . '</span>
                <a href="admin_view_athelete.php?id=' . $row['atheleteid'] . '">View Details</a>
                <a href="deleteathelete.php?id=' . $row['atheleteid'] . '">Delete</a>
              </li>';
    }
} else {
    echo "<li class='athlete-item'>No results found</li>";
}
?>
