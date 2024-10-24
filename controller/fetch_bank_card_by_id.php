<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Check if the ID parameter is provided
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch bank card details by ID
        $sql = "SELECT id, user_id, name, ifsc_code, bank_name, bank_account, state, city, address, mobile_no, email, acc_user_id, code, otp, status, created_at, updated_at FROM bank_card WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Bank card found, return the details as JSON
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            // Bank card not found
            echo json_encode(["error" => "Bank card not found"]);
        }
    } else {
        // ID parameter is missing
        echo json_encode(["error" => "ID parameter is missing"]);
    }
} else {
    // Invalid request method
    echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();
?>
