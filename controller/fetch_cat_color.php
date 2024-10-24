<?php
include 'db_connection.php';

$sql = 'SELECT `id`, `name`, `status` FROM categories WHERE type="Main Page"';
$result = $conn->query($sql);
$categories = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

echo json_encode($categories);

$conn->close();
?>
