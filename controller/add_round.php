<?php
include 'db_connection.php';

$response = ['status' => 'error', 'message' => 'Something went wrong'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
     
        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO round (name) VALUES (?)");
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'Round added successfully'];
        } else {
            $response['message'] = 'Failed to add round';
        }
        $stmt->close();
   
}

$conn->close();
echo json_encode($response);
?>
