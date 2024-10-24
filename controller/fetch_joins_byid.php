<?php
    include 'db_connection.php';

    // Assuming you have a way to get the current user's ID, e.g., from session
    session_start();
    $user_id = $_SESSION['user_id']; // Adjust as necessary

    // Fetch user-specific records from the results table
    $sql = "SELECT * FROM results WHERE user_id = '$user_id' ORDER BY id DESC";
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
                'price' => $row['price'],
                'created_at' => $row['created_at']
            ];

            // echo "<pre>";
            // echo "pre";
            // print_r($userRecords);
        }
    

    /* Fetch the current period from another table or source
    $currentPeriodResult = $conn->query("SELECT period FROM joins WHERE user_id = '$user_id' LIMIT 1");
    $currentPeriodRow = $currentPeriodResult->fetch_assoc();
    $currentPeriod = $currentPeriodRow['period'];*/

    // Return user records along with the current period
    echo json_encode([
        'success' => true,
        'userRecords' => $userRecords
    ]);


    // // Return user records
    // echo json_encode([
    //     'success' => true,
    //     'userRecords' => $userRecords
    // ]);

    $conn->close();
?>
