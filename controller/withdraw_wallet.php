<?php
    session_start();
    include 'db_connection.php';
    
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["error" => "User not logged in"]);
        exit;
    }
    
    $user_id = $_SESSION['user_id'];
   
    // Fetch total money amount
    $sql_total = "SELECT SUM(witdraw_amount) AS total_wamount FROM wallet WHERE user_id = $user_id AND withdraw_status = 'Success'";
    $result_total = $conn->query($sql_total);
    $total_money = $result_total->fetch_assoc()['total_wamount'] ?? 0;

    $sql_total = "SELECT balance FROM total_wallet WHERE user_id = $user_id ";
    $result_total = $conn->query($sql_total);
    $balance = $result_total->fetch_assoc()['balance'] ?? 0;

    $response = [
        'total_wamount' => $total_money,
        'balance' => $balance
    ];

    echo json_encode($response);

    $conn->close();
?>
