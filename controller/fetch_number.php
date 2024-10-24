<?php
    session_start();
    include 'db_connection.php';

    // Assuming you have set the user_id in session
    $currentUserId = $_SESSION['user_id'];

    $sql = "SELECT number FROM results";
    $result = $conn->query($sql);

    $numbers = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $numbers[] = $row['number'];
        }
    }

    $conn->close();

    echo json_encode(['numbers' => $numbers]);
?>
