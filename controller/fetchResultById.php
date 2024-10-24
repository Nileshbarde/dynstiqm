<?php
    include 'db_connection.php';

    // Assuming you have a way to get the current user's ID, e.g., from session
    session_start();
    $user_id = $_SESSION['user_id']; // Adjust as necessary

    // Fetch user-specific records from the results table
    $sql = "SELECT r.*, u.mobile_number
        FROM results r
        JOIN users u ON r.user_id = u.id
        WHERE r.user_id = '$user_id'
        ORDER BY r.id DESC";
    $result = $conn->query($sql);
    $userRecords = [];

    while ($row = $result->fetch_assoc()) 
    {
        $resultValue = '';
        $selectedNumber = '';
    
        // Determine the result value based on cat_id and sub_id
        if ($row['cat_id'] == 1) {
            $resultValue = '1 green';
        } elseif ($row['cat_id'] == 2) {
            $resultValue = '2 violet';
        } elseif ($row['cat_id'] == 3) {
            $resultValue = '3 red';
        } elseif ($row['sub_id'] >= 1 && $row['sub_id'] <= 9) {
            $resultValue = $row['sub_id'] - 1;
        }
    
        // Determine the selected number value based on subcat_id
        if ($row['sub_id'] >= 1 && $row['sub_id'] <= 9) {
            $selectedNumber = $row['sub_id'] - 1;
        } elseif ($row['cat_id'] >= 1 && $row['cat_id'] <= 3) {
            $selectedNumber = $row['cat_id'];
        }

        if($row['status'] == 'fail') {
            if ($row['cat_id'] == 1) {
                $resultValue = '1 green';
            } elseif ($row['cat_id'] == 2) {
                $resultValue = '2 violet';
            } elseif ($row['cat_id'] == 3) {
                $resultValue = '3 red';
            } elseif ($row['sub_id'] >= 1 && $row['sub_id'] <= 9) {
                $resultValue = $row['sub_id'] - 3;
            }
        }

            $userRecords[] = [
                'id' => $row['id'],
                'period' => $row['period'],
                'contract_money' => $row['contract_money'],
                'contract_count' => $row['contract_count'],
                'delivery' => $row['delivery'],
                'fee' => $row['fee'],
                'price' => $row['price'],
                'number' => $row['number'],
                'color' => $row['color'],
                'results' => $resultValue,
                'select' => $selectedNumber,
                'status' => $row['status'],
                'created_at' => $row['created_at'],
                'mobile_number' => $row['mobile_number'] // Added mobile number
            ];

            // echo "<pre>";
            // echo "pre";
            // print_r($userRecords);
        }
    
    echo json_encode([
        'success' => true,
        'userRecords' => $userRecords
    ]);

    $conn->close();
?>
