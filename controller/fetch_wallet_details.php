<?php
    session_start();
    include 'db_connection.php';
    
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["error" => "User not logged in"]);
        exit;
    }
    
    $user_id = $_SESSION['user_id'];

    // Fetch wallet details
    $sql = "SELECT id, user_id, utr_id, amount, transction_id, transc_date, payment_by, status FROM wallet WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $wallet_details = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $wallet_details[] = $row;
        }
    }

    echo json_encode($wallet_details);

    $conn->close();
?>
