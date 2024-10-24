<?php
include 'db_connection.php';

// Fetch subcategories
$sql = "SELECT id, sub_name, status FROM subcategories";
$result = $conn->query($sql);
$subcategories = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
    }
}

echo json_encode($subcategories);

$conn->close();
?>
