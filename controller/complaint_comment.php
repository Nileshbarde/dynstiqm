<?php
    session_start(); // Ensure the session is started
    // Include database connection
    include 'db_connection.php';

    // Get form data
    $complaint_id = $_POST['complaint_id'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
    $status = $_POST['status']; // Assuming user ID is stored in session

    // Insert comment into database
    $sql = "INSERT INTO complaint_comments (complaint_id, user_id, comment, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $complaint_id, $user_id, $comment, $status);

    if ($stmt->execute()) {
        // Update status in complaints table
        $update_sql = "UPDATE complaints SET status = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si",  $status, $complaint_id);
        $update_stmt->execute();
        
        echo "Comment added and status updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>
