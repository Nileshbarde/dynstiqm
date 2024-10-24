<?php
    session_start();
    include 'db_connection.php';

    $response = array("success" => false, "totalCommission" => 0);

    if (isset($_SESSION['user_id'])) 
    {
        $userId = $_SESSION['user_id'];
        $query = "SELECT invite_code FROM users WHERE id = '$userId'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $invitecode = $row['invite_code'];
        }

        $query = "SELECT promotion_amt FROM promotions WHERE invitedby = '$invitecode'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $response["success"] = true;
            $response["totalCommission"] = $row['promotion_amt'];
        }
    }

    mysqli_close($conn);
    header('Content-Type: application/json');
    echo json_encode($response);
?>
