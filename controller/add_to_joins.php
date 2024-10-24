<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    include 'db_connection.php';

    $response = array("success" => false, "message" => "");

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["error" => "User not logged in"]);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $user_id = $_SESSION['user_id'];
        $contract_money = $_POST['contract_money'];
        $total = $_POST['total'];
        $cat_id = empty($_POST['cat_id']) ? 0 : $_POST['cat_id'];
        $subcat_id = empty($_POST['subcat_id']) ? 0 : $_POST['subcat_id'];
        $period = $_POST['period'];

        $conn->begin_transaction();

        try {
            $walletQuery = "SELECT balance FROM total_wallet WHERE user_id = ?";
            $stmt = $conn->prepare($walletQuery);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) 
            {
                $row = $result->fetch_assoc();
                $current_balance = $row['balance'];

                // Check if the user has enough balance
                if ($current_balance >= $contract_money) {
                    // Deduct the contract money from the balance
                    $new_balance = $current_balance - $contract_money;
                                
                    // Update the wallet balance
                    $updateWalletQuery = "UPDATE total_wallet SET balance = ? WHERE user_id = ?";
                    $stmt = $conn->prepare($updateWalletQuery);
                    $stmt->bind_param("di", $new_balance, $user_id);
                    if ($stmt->execute()) {
                        // Insert into joins table
                        $insertJoinQuery = "INSERT INTO joins (contract_money, quantity, total, user_id, cat_id, subcat_id, period) VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $quantity = 1; // Assuming quantity is always 1
                        $stmt = $conn->prepare($insertJoinQuery);
                        $stmt->bind_param("diisiii", $contract_money, $quantity, $total, $user_id, $cat_id, $subcat_id, $period);

                        if ($stmt->execute()) {
                            // Commit the transaction
                            $conn->commit();
                            $response["success"] = true;
                            $response["message"] = "Joined successfully and wallet updated.";
                        } else {
                            throw new Exception("Error inserting into joins table.");
                        }
                    } else {
                        throw new Exception("Error updating wallet.");
                    }
                } else {
                    $response["message"] = "Insufficient balance.";
                }
            } else {
                throw new Exception("User wallet not found.");
            }
        
        } catch (Exception $e) {
            // Rollback the transaction if any query fails
            $conn->rollback();
            $response["message"] = "Transaction failed: " . $e->getMessage();
        }

        $stmt->close();
        $conn->close();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>
