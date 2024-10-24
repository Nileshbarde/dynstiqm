<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];

    // Assuming you have user_id from the session
    session_start();
    $user_id = $_SESSION['user_id']; // Update this according to your session setup

    // Generate UTR ID (Unique Transaction Reference ID)
    $utr_id = uniqid('utr_'); // Example UTR ID generation, you might want a different approach

    // Generate a unique transaction ID
    $transction_id = uniqid('txn_'); // Generate a unique transaction ID

    // Define other fields (for example purposes, replace with actual values)
    $payment_by = 'UPT'; // Replace with actual payment method
    $status = "Success"; // Set status accordingly

    // Insert wallet details into the database
    $sql = "INSERT INTO wallet (user_id, utr_id, amount, transction_id, transc_date, payment_by, status) VALUES (?, ?, ?, ?, NOW(), ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $user_id, $utr_id, $amount, $transction_id, $payment_by, $status);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Wallet added successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
