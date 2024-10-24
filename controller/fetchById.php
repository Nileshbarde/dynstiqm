<?php
session_start();
include 'db_connection.php';

// Assuming you have set the user_id in session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$currentUserId = $_SESSION['user_id'];

// Your SQL query to fetch data by currentUserId
$query = "
    SELECT 
        j.id, 
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
        users u ON j.user_id = u.id
    WHERE 
        j.user_id = ?
";

// Prepare and execute the statement
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $currentUserId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'Query error: ' . mysqli_error($conn)]);
    exit;
}

$data = mysqli_fetch_all($result, MYSQLI_ASSOC); // Fetch all rows

if ($data) {
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'No data found for the user']);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
