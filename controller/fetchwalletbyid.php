<?php

session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch today's wallet amount, last interest application date, and total interest
$sql_today = "SELECT balance AS today_wallet, last_interest_date, total_interest FROM total_wallet WHERE user_id = ?";
$stmt = $conn->prepare($sql_today); 
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_today = $stmt->get_result();
$row = $result_today->fetch_assoc();
$today_wallet = $row['today_wallet'] ?? 0;
$last_interest_date = $row['last_interest_date'];
$total_interest = $row['total_interest'] ?? 0;

// Calculate interest if the wallet is not empty and a day has passed
$interest_rate = 0.009; // 0.9% interest rate
$today_date = date("Y-m-d");
if ($today_wallet > 0) {
    if ($last_interest_date === null || $last_interest_date < $today_date) {
        // Apply interest
        $interest = $today_wallet * $interest_rate;
        $today_wallet_with_interest = $today_wallet + $interest;
        $new_total_interest = $total_interest + $interest;

        // Update the wallet balance, last interest date, and total interest
        $sql_update = "UPDATE total_wallet SET balance = ?, last_interest_date = ?, total_interest = ? WHERE user_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        if (!$stmt_update) {
            echo "Prepare failed: " . $conn->error;
            exit;
        }
        $stmt_update->bind_param("dssi", $today_wallet_with_interest, $today_date, $new_total_interest, $user_id);
        if (!$stmt_update->execute()) {
            echo "Update failed: " . $stmt_update->error;
            exit;
        }
        $stmt_update->close();
    } else {
        $today_wallet_with_interest = $today_wallet;
        $interest = 0;
    }
} else {
    $interest = 0;
    $today_wallet_with_interest = $today_wallet;
}

// Format amounts to 2 decimal places
$today_wallet = number_format($today_wallet, 2, '.', '');
$interest = number_format($interest, 2, '.', '');
$today_wallet_with_interest = number_format($today_wallet_with_interest, 2, '.', '');
$total_interest = number_format($total_interest, 2, '.', '');

// Prepare response
$response = [
    'today_wallet' => $today_wallet,
    'interest' => $interest,
    'today_wallet_with_interest' => $today_wallet_with_interest,
    'total_interest' => $total_interest
];

echo json_encode($response);

$stmt->close();
$conn->close();
?>
