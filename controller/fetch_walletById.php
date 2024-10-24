<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$withdraw_status = 0;

$sql = "SELECT id, user_id, utr_id, amount, transction_id, transc_date, payment_by, status FROM wallet WHERE user_id = ? AND withdraw_status = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $withdraw_status);
$stmt->execute();
$result = $stmt->get_result();
$wallet_details = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wallet_details[] = $row;
    }
}

echo json_encode($wallet_details);

$stmt->close();
$conn->close();
?>

