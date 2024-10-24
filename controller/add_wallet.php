<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    print_r($amount);
    die;
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

    // Check if this is the first time the user is adding to their wallet
    $check_first_time_sql = "SELECT COUNT(*) FROM wallet WHERE user_id = ?";
    $check_first_time_stmt = $conn->prepare($check_first_time_sql);
    $check_first_time_stmt->bind_param("i", $user_id);
    $check_first_time_stmt->execute();
    $check_first_time_stmt->bind_result($wallet_count);
    $check_first_time_stmt->fetch();
    $check_first_time_stmt->close();

    // Insert wallet details into the database
    $sql = "INSERT INTO wallet (user_id, utr_id, amount, transction_id, transc_date, payment_by, status) VALUES (?, ?, ?, ?, NOW(), ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $user_id, $utr_id, $amount, $transction_id, $payment_by, $status);

    if ($stmt->execute()) {
        // Check if this is the first wallet addition and amount is equal to or greater than 100
        if ($wallet_count == 0 && $amount >= 100) {
            // Fetch invite_code and invitedby from the user table
            $user_sql = "SELECT invite_code, invitedby FROM user WHERE id = ?";
            $user_stmt = $conn->prepare($user_sql);
            $user_stmt->bind_param("i", $user_id);
            $user_stmt->execute();
            $user_stmt->bind_result($invite_code, $invitedby);
            $user_stmt->fetch();
            $user_stmt->close();

            // Check if invitedby is not empty
            if (!empty($invitedby)) {
                // Calculate 30% commission
                $commission = $amount * 0.30;

                // Assuming you have the necessary details for promotions table
                // $promotion_link = 'your_promotion_link'; // Replace with actual promotion link

                // Insert commission details into the promotions table
                $promo_sql = "INSERT INTO promotions (invite_code, invitedby, user_id, promotion_amt, status) VALUES (?, ?, ?, ?, ?)";
                $promo_stmt = $conn->prepare($promo_sql);
                $promo_status = 'Active'; // Set the promotion status accordingly
                $promo_stmt->bind_param("ssiis", $invite_code, $invitedby, $user_id, $commission, $promo_status);

                if ($promo_stmt->execute()) {
                    echo json_encode(["success" => true, "message" => "Wallet added and commission applied successfully"]);
                } else {
                    echo json_encode(["success" => false, "message" => "Error: " . $promo_stmt->error]);
                }

                $promo_stmt->close();
            } else {
                echo json_encode(["success" => true, "message" => "Wallet added successfully, no commission applied"]);
            }
        } else {
            echo json_encode(["success" => true, "message" => "Wallet added successfully, no commission applied"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
