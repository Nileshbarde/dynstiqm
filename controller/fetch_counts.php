<?php
    session_start();
    include 'db_connection.php';

    // Assuming you have set the user_id in session
    $currentUserId = $_SESSION['user_id'];

    $sql = "
    SELECT 
        SUM(CASE 
            WHEN cat_id = 1 OR subcat_id IN (2, 4, 8, 10) THEN 1 
            ELSE 0 
        END) AS green_count,
        SUM(CASE 
            WHEN cat_id = 3 OR subcat_id IN (3, 5, 7, 9) THEN 1 
            ELSE 0 
        END) AS red_count,
        SUM(CASE 
            WHEN cat_id = 2 OR subcat_id IN (1, 6) THEN 1 
        END) AS violet_count
    FROM joins";

    $result = $conn->query($sql);
    $counts = $result->fetch_assoc();

    $conn->close();

    echo json_encode($counts);
?>
