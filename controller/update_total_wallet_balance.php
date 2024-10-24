<?php
    session_start();
    include 'db_connection.php';

    // $userid = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
        $userid = $_POST['user_id'];

        if ($amount > 0) {
            // SQL query to update the total wallet balance
            $query = "UPDATE total_wallet SET balance = balance - ? WHERE user_id = $userid"; // Assuming there's only one row in total_wallet

            if ($stmt = $conn->prepare($query)) 
            {
                $stmt->bind_param('d', $amount);

                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Total wallet balance updated successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update the total wallet balance.']);
                }

                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Database query failed.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid amount.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }

    $mysqli->close();
?>
