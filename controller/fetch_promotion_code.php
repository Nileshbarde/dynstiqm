<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Initialize response array
$response = array("success" => false, "invite_code" => "");

// Query to fetch the promotion code from the database
$sql = "SELECT invite_code FROM users WHERE id = $user_id"; // Assuming the table name is 'promotions'

$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $promotionCode = $row['invite_code'];

        // Set the promotion code in the response
        $response["success"] = true;
        $response["invite_code"] = $promotionCode;
    } else {
        $response["message"] = "No promotion code found.";
    }
} else {
    $response["message"] = "Error executing query: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
