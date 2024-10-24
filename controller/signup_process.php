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

    // Hash password
    // $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if mobile number already exists
    $query = "SELECT * FROM users WHERE mobile_number='$mobileNumber'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        // Generate unique code for user
        $uniqueCode = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 5) . rand(100, 999);
        // Insert new user into database
        $sql = "INSERT INTO users (mobile_number, role_id, password, invitedby, invite_code) VALUES ('$mobileNumber', '2', '$password', '$inviteCode', '$uniqueCode')";
        if (mysqli_query($conn, $sql)) {
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
