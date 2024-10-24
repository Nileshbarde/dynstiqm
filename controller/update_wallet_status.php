<?php
    include 'db_connection.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $walletId = $_POST['id'];
        $newStatus = $_POST['status'];
        $withdraw_status = 'Success';

        // Prepare and execute the update statement
        $stmt = $conn->prepare("UPDATE wallet SET withdraw_status = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssi",$withdraw_status, $newStatus, $walletId);

        if ($stmt->execute()) { 
            echo json_encode(['message' => 'Status updated successfully']);
        } else {
            echo json_encode(['message' => 'Error updating status']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['message' => 'Invalid request method']);
    }
?>
