<?php
include 'db_connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch wallet details along with the user's mobile number
$sql = "SELECT w.id, w.user_id, w.witdraw_amount, w.withdraw_date, w.withdraw_status, w.status, u.mobile_number 
        FROM wallet w 
        JOIN users u ON w.user_id = u.id 
        WHERE w.withdraw_status = 'Success' OR w.withdraw_status = 'Withdraw Pending'";

$result = $conn->query($sql);

if ($result === false) {
    // Handle query error
    die("Error executing query: " . $conn->error);
}

$wallet_details = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wallet_details[] = $row;
    }
}

// Output JSON
header('Content-Type: application/json');
echo json_encode($wallet_details);

// Close connection
$conn->close();
?>
