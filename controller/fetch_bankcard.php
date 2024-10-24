<?php
    session_start();

    include 'db_connection.php';
    $user_id = $_SESSION["user_id"];

    // Fetch bank card details
    $sql = "SELECT id, name, ifsc_code, bank_name, bank_account, state, city, address, mobile_no, email, acc_user_id, code, otp, status, created_at, updated_at FROM bank_card";
    $result = $conn->query($sql);
    $bank_cards = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bank_cards[] = $row;
        }
    }

    echo json_encode($bank_cards);

    $conn->close();
?>
