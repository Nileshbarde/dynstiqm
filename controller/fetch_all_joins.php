<?php
    session_start();
    include 'db_connection.php';

    // Assuming you have set the user_id in session
    $currentUserId = $_SESSION['user_id'];

    // Query to fetch data
    $sql = "SELECT  j.id, 
                    j.contract_money, 
                    j.quantity, 
                    j.total, 
                    u.mobile_number AS user_mobile_number, 
                    j.cat_id, 
                    j.subcat_id, 
                    j.period, 
                    j.created_at, 
                    j.updated_at 
                FROM 
                    joins j 
                JOIN 
                    users u ON j.user_id = u.id";

    
    $result = $conn->query($sql);

    $data = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode(['success' => true, 'allJoins' => $data]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No records found']);
    }

    $conn->close();
?>
