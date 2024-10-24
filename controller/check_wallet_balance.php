<?php
session_start();
include 'db_connection.php';

$response = array("success" => false, "message" => "", "balance" => 0);

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Retrieve the user's wallet balance
    $query = "SELECT balance FROM total_wallet WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $response["success"] = true;
        $response["balance"] = $row["balance"];
    } else {
        $response["message"] = "Could not retrieve wallet balance.";
    }
} else {
    $response["message"] = "Invalid request.";
}

mysqli_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
