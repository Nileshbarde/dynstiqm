<?php
    session_start();
    // Include database connection
    include 'db_connection.php';

    // Get form data
    $id = $_POST['id'] ?? null;
    $type = $_POST['type'];
    $out_id = $_POST['out_id'];
    $number = $_POST['number'];
    $description = $_POST['description'];

    if ($id) {
        // Update existing complaint
        $sql = "UPDATE complaints SET type = ?, out_id = ?, number = ?, description = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $type, $out_id, $number, $description, $id);
        $stmt->execute();
        echo "Complaint updated successfully.";
    } else {
        // Insert new complaint
        $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
        $sql = "INSERT INTO complaints (user_id, type, out_id, number, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $user_id, $type, $out_id, $number, $description);
        $stmt->execute();
        echo "Complaint submitted successfully.";
    }

    $conn->close();
?>
