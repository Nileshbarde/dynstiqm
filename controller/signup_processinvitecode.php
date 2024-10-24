<?php
session_start();
include 'db_connection.php';

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobileNumber = $_POST["mobile_number"];
    $password = $_POST["password"];
    $inviteCode = $_POST["inviteCode"];

    // SQL injection prevention
    $mobileNumber = mysqli_real_escape_string($conn, $mobileNumber);
    $password = mysqli_real_escape_string($conn, $password);
    $inviteCode = mysqli_real_escape_string($conn, $inviteCode);

    // Check if mobile number already exists
    $query = "SELECT * FROM users WHERE mobile_number='$mobileNumber'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        // Generate unique code for user
        $uniqueCode = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 5) . rand(100, 999);

        // Insert new user into database
        $sql = "INSERT INTO users (mobile_number, password, invite_code, invitedby, status) VALUES ('$mobileNumber', '$password', '$uniqueCode', '$inviteCode', 1)";
        if (mysqli_query($conn, $sql)) {
            // Get the newly registered user ID
            $userId = mysqli_insert_id($conn);

            // Check if inviteCode is valid and get the inviter's ID
            $query = "SELECT id, invite_code FROM users WHERE invite_code='$inviteCode'";
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $inviterId = $row['id'];

                // Calculate commission for the inviter
                $commission = 150; // 9% of the fixed promotion amount of 150

                // Insert the promotion record
                $promotionLink = "http://localhost/lp/signup.php?r_code=". $uniqueCode; // Assign the appropriate promotion link
                $status = "active"; // Assign the appropriate status

                $sql = "INSERT INTO promotions (invite_code, invitedby, user_id, promotion_link, promotion_amt, status) VALUES ('$uniqueCode', '$inviteCode', '$userId', '$promotionLink', '$commission', '$status')";
                mysqli_query($conn, $sql);
            }

            $response["success"] = true;
            $response["message"] = "Sign Up Successful!";
        } else {
            $response["message"] = "Database error: Could not insert user.";
        }
    } else {
        $response["message"] = "Mobile number already registered.";
    }

    mysqli_close($conn);
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
?>
