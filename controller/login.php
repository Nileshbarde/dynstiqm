<?php
// Start session if not already started
session_start();

// Include database connection
include "db_connection.php";

// Initialize response array
$response = array("success" => false, "message" => "");

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $mobileNumber = $_POST["mobile_number"];
    $password = $_POST["password"];

    // SQL injection prevention
    $mobileNumber = mysqli_real_escape_string($conn, $mobileNumber);
    $password = mysqli_real_escape_string($conn, $password);

    // Hash password
    // $hashedPassword = hash("sha256", $password);

    // Check credentials in database
    $query = "SELECT * FROM users WHERE mobile_number='$mobileNumber' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
       
        // Login successful
        $user = $result->fetch_assoc();
        
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["name"];
        $_SESSION["mobile_number"] = $user["mobile_number"];
        $_SESSION["role_id"] = $user["role_id"];
         
        $response["success"] = true;
        $response["message"] = "Login successful.";
    } else {
        // Login failed
        $response["message"] = "Incorrect mobile number or password.";
    }
} else {
    $response["message"] = "Invalid request.";
}

// Close database connection
mysqli_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
