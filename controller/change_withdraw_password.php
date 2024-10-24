<?php
session_start();
require 'db_connection.php'; // Make sure you have a file to connect to your database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $currentWithdrawPassword = $_POST['currentWithdrawPassword'];
    $newWithdrawPassword = $_POST['newWithdrawPassword'];
    $confirmWithdrawPassword = $_POST['confirmWithdrawPassword'];

    if ($newWithdrawPassword !== $confirmWithdrawPassword) {
        echo "New withdrawal passwords do not match.";
        exit();
    }

    // Fetch current withdrawal password from the database
    $stmt = $conn->prepare("SELECT withd_pwd FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($hashedWithdrawPassword);
    $stmt->fetch();
    $stmt->close();

    // Check if the current withdrawal password is set
    if ($hashedWithdrawPassword) {
        // Verify current withdrawal password
        if (!password_verify($currentWithdrawPassword, $hashedWithdrawPassword)) {
            echo "Current withdrawal password is incorrect.";
            exit();
        }
    } else {
        // If no current withdrawal password, skip verification step
        if (!empty($currentWithdrawPassword)) {
            echo "No current withdrawal password set. Leave the current password field empty.";
            exit();
        }
    }

    // Update withdrawal password
    $newHashedWithdrawPassword = password_hash($newWithdrawPassword, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE users SET withd_pwd = ? WHERE id = ?");
    $stmt->bind_param("si", $newHashedWithdrawPassword, $userId);

    if ($stmt->execute()) {
        echo "Withdrawal password changed successfully.";
    } else {
        echo "Failed to change withdrawal password.";
    }
    $stmt->close();
}
?>
