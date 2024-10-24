<?php
    session_start();
    include 'db_connection.php';

    // Assuming you have set the user_id in session
    $currentUserId = $_SESSION['user_id'];
 
    // Fetch the latest period
    $sql = "SELECT period FROM joins ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) 
    {
        $row = $result->fetch_assoc();
        $lastPeriod = $row['period'];
    
        // Fetch the data for the last period
        $sql = "SELECT * FROM joins WHERE period = '$lastPeriod'";
        $result = $conn->query($sql);
        $records = [];
        $totalSum = 0;
    
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
            $totalSum += $row['contract_money'];
        }
        
     
        $userSql = "SELECT * FROM joins WHERE period = '$lastPeriod' AND user_id = '$currentUserId'";
        $userResult = $conn->query($userSql);
        $userRecords = [];
        while ($row = $userResult->fetch_assoc()) {
            $userRecords[] = $row;
        }
        $contract_count = count($userRecords);
    
        // Determine the winner
        $winner = null;
        foreach ($records as $record) {
            if ($record['contract_money'] < $totalSum) {
                $winner = $record;
                break;
            }
        }

        // If no winner was found, use a random number to determine the winner
        if (!$winner) {
            $selectedNumber = rand(0, 9); // Example result number, replace with your actual logic
            foreach ($records as $record) {
                if ($selectedNumber == $selectedNumber) {
                    $winner = $record;
                    break;
                }
            }
        }
    
        // If a winner is found, process the payout and update the results table
        // Process the winner if found
        if ($winner) 
        {
            $payout = 0;
            $contract_money = $winner['contract_money'];
            $percentage = 5.00; // The percentage you want to calculate
            $fee = ($contract_money * $percentage) / 100;
            $delivery = $contract_money - $fee;

            
            /*
                0.5 fee
                9.5 dilvery
            */

            /* Determine color based on cat_id
            switch ($winner['cat_id']) {
                case 1:
                    $payout = $delivery * 2;
                    $status = 'success';
                    $selectedcolor = 'green';
                    break;
                    break;
                case 2:
                    $payout = $delivery * 1.5;
                    $status = 'success';
                    $selectedcolor = 'violet';
                    break;
                case 3:
                    $payout = $delivery * 2;
                    $status = 'success';
                    $selectedcolor = 'red';
                    break;
            }*/

            // Determine selectedNumber based on subcat_id
            if ($winner['subcat_id'] >= 1 && $winner['subcat_id'] <= 9) {
                $selectedNumber = $winner['subcat_id'] - 1;
            } else {
                $selectedNumber = null; // or any other value indicating no number was selected
            }

            // Determine payout and status based on selectedNumber and winner's number
            if (isset($selectedNumber)) 
            {
                if (in_array($selectedNumber, [1, 3, 7, 9])) {
                    $payout = $delivery * 2;
                    $color = 'green';
                    $status = 'success';
                } elseif ($selectedNumber == 5) {
                    $payout = $delivery * 1.5;
                    $color = 'violet';
                    $status = 'success';
                } elseif (in_array($selectedNumber, [2, 4, 6, 8])) {
                    $payout = $delivery * 2;
                    $color = 'red';
                    $status = 'success';
                } elseif ($selectedNumber == 0) {
                    $payout = $delivery * 1.5;
                    $color = 'violet';
                    $status = 'success';
                } elseif ($winner['number'] == $selectedNumber) {
                    $payout = $delivery * 9;
                    $color = 'select number';
                    $status = 'success';
                }
            } else {
                $payout = $delivery * 1.5;
                $status = 'success';
            }

            // Handle the case when only color is selected and no number is selected
            // if (!isset($selectedNumber) && isset($selectedcolor)) 
            // {
            //     if ($selectedcolor == 'green') {
            //             $payout = $delivery * 2;
            //             $status = 'success';
            //             $color = 'green';
            //     }
            //     elseif($selectedcolor == 'violet')
            //     {
            //         $payout = $delivery * 1.5;
            //         $status = 'success';
            //         $color = 'violet';
            //     } 
            //     elseif($selectedcolor == 'red') 
            //     {
            //         $payout = $delivery * 2;
            //         $status = 'success';
            //         $color = 'red';
            //     }
            // }


            // Check if the winner for the current period and user already exists in the results table
            $sql = "SELECT * FROM results WHERE period = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $winner['period'], $winner['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
           
            if ($result->num_rows == 0) {
                
                // $openPrice = $totalSum + $payout;
            
                // Insert the winner into the results table if it doesn't already exist
                $sql = "INSERT INTO results (user_id, period, contract_money, contract_count, number, price, fee, delivery, color, status, selected_number, cat_id, sub_id, wallet_updated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $walletUpdated = true;

                // Determine the value to store in the 'number' and 'selected_number' columns
                // $numberValue = isset($selectedNumber) ? $selectedNumber : null;
                $selectedNumberValue = isset($selectedNumber) ? $selectedNumber : null;

                $stmt->bind_param("iiiiidddssiiis", $winner['user_id'], $winner['period'], $contract_money, $contract_count, $selectedNumberValue, $payout, $fee, $delivery, $color, $status, $selectedNumberValue, $winner['cat_id'], $winner['subcat_id'], $walletUpdated);
                $stmt->execute();
            
                // Update the user's payout balance in the total_wallet table
                $sql = "SELECT balance FROM total_wallet WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $winner['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
            
                if ($result->num_rows > 0) {
                    // Update the balance if the user exists in the total_wallet table
                    $row = $result->fetch_assoc();
                    $newBalance = $row['balance'] + $payout;
            
                    $sql = "UPDATE total_wallet SET balance = ? WHERE user_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("di", $newBalance, $winner['user_id']);
                    $stmt->execute();
                } else {
                    // Insert new balance if the user does not exist in the total_wallet table
                    $sql = "INSERT INTO total_wallet (user_id, balance) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("id", $winner['user_id'], $payout);
                    $stmt->execute();
                }
            }

            // Insert failed selections for other records if they exist
            foreach ($records as $record) 
            { 
                if ($record !== $winner) 
                {
                    $contract_money = $record['contract_money'];
                    $percentage = 5.00; // The percentage you want to calculate
                    $fee = ($contract_money * $percentage) / 100;
                    $delivery = $contract_money - $fee;
                    $status = 'fail';

                  
                    // Check if the record for the current period and user already exists in the results table
                    $sql = "SELECT * FROM results WHERE period = ? AND user_id = ? AND sub_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sii", $record['period'], $record['user_id'], $record['subcat_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows == 0) {
                        // Insert failed selection if it doesn't already exist
                        $sql = "INSERT INTO results (user_id, period, contract_money, contract_count, number, price, fee, delivery, color, status, selected_number, cat_id, sub_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);

                        $numberValue = isset($selectedNumber) ? $selectedNumber : $selectedcolor;
                        $selectedNumberValue = isset($selectedNumber) ? $selectedNumber : null;

                        $stmt->bind_param("iiiiidddssiii", $record['user_id'], $record['period'], $contract_money, $contract_count, $numberValue, $delivery, $fee, $delivery, $color, $status, $numberValue, $record['cat_id'], $record['subcat_id']);
                        $stmt->execute();
                    }
                }
            }
        }
            
        // Fetch all winners' data from the results table
        $sql = "SELECT * FROM results WHERE `status` = 'success' ORDER BY id DESC";
        $result = $conn->query($sql);
        $allWinners = [];
    
        while ($row = $result->fetch_assoc()) {
            $allWinners[] = $row;
        }
        // Return all winners
        echo json_encode([
            'success' => true,
            'allWinners' => $allWinners
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No records found for the current period']);
    }
    
    $conn->close();
?>