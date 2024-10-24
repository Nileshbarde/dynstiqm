<?php
include 'db_connection.php';

// Fetch wallet details along with the user's mobile number
$sql = "SELECT w.`id`, w.`user_id`, w.`amount`, w.`witdraw_amount`, w.`withdraw_date`, w.`withdraw_status`, w.`status`, u.`mobile_number`
FROM wallet w
JOIN users u ON w.user_id = u.id
WHERE w.`withdraw_status` = 'Withdraw Pending'";

$result = $conn->query($sql);

$wallet_details = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wallet_details[] = $row;
    }
}

echo json_encode($wallet_details);

$conn->close();
?>
