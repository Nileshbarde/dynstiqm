<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT id, mobile_number FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user_details = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user_details[] = $row;
    }
}

echo json_encode($user_details);

$conn->close();
?>
