<?php
    session_start();
    include 'db_connection.php';
    
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["error" => "User not logged in"]);
        exit;
    }
    
    $user_id = $_SESSION['user_id'];
   
    // Fetch total money amount
    $sql_total = "SELECT SUM(witdraw_amount) AS total_money FROM wallet WHERE withdraw_status = 'Success'";
    $result_total = $conn->query($sql_total);
    $total_wmoney = $result_total->fetch_assoc()['total_money'] ?? 0;

    // Fetch total money amount
    $sql_total = "SELECT SUM(balance) AS tot_bal FROM total_wallet";
    $result_total = $conn->query($sql_total);
    $total_money = $result_total->fetch_assoc()['tot_bal'] ?? 0;

    $response = [
        'todaybalance' => $total_money,
        'todayWWallet' => $total_wmoney
    ];

    echo json_encode($response);

    $conn->close();
?>
