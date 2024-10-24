<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["error" => "User not logged in"]);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $status = "Withdraw Pending";

    // Validation
    if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
        echo json_encode(["error" => "Invalid amount"]);
        exit;
    }

    $sql = "INSERT INTO wallet (user_id, witdraw_amount, withdraw_date, status) VALUES (?, ?, NOW(), ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('ids', $user_id, $amount, $status);
        if ($stmt->execute()) {
            echo json_encode(["success" => "Withdrawal request submitted"]);
        } else {
            echo json_encode(["error" => "Failed to submit withdrawal request"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["error" => "Database error"]);
    }

    $conn->close();
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
