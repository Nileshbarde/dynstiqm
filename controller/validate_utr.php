<?php
session_start();
include "db_connection.php";

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $utr = $_POST["utr"];
    $amount = $_POST["amount"];
    $user_id = $_SESSION["user_id"];

    // Check if UTR ID is exactly 12 digits
    if (!preg_match('/^\d{12}$/', $utr)) {
        $response["message"] = "Invalid UTR ID. It must be exactly 12 digits.";
        echo json_encode($response);
        exit;
    }

    if (!empty($utr) && !empty($amount) && !empty($user_id)) {
        // Check if the UTR ID is already used
        $checkQuery = "SELECT * FROM wallet WHERE utr_id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $utr);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response["message"] = "UTR ID has already been used.";
            echo json_encode($response);
            exit;
        }
        $stmt->close();

        // Check if this is the first time the user is adding to their wallet
        $checkFirstTimeQuery = "SELECT balance FROM total_wallet WHERE user_id = ?";
        $stmt = $conn->prepare($checkFirstTimeQuery);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($balance);
        $stmt->fetch();
        $stmt->close();

        // If it's the first time and the amount is >= 100, proceed with commission
        if ($balance == 0 && $amount >= 100) {
            // Fetch invite_code and invitedby from the user table
            $userQuery = "SELECT invite_code, invitedby FROM users WHERE id = ?";
            $stmt = $conn->prepare($userQuery);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->bind_result($invite_code, $invitedby);
            $stmt->fetch();
            $stmt->close();

            // Check if invitedby is not empty
            if (!empty($invitedby)) 
            {
                // Add 30% commission and additional 100 to the wallet amount
                $commission = $amount * 0.30;
                $amount = $amount;
                $status = 'success';

                // INSERT INTO `promotions`(`invite_code`, `invitedby`, `user_id`, `promotion_link`, `promotion_amt`, `status`) 
                $insertPromo = "INSERT INTO promotions (`invite_code`, `invitedby`, `user_id`, `promotion_amt`, `status`) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertPromo);
                $stmt->bind_param("ssids", $invite_code, $invitedby, $user_id, $commission, $status);
                $stmt->execute();

                // Insert the transaction into the wallet table with the updated amount
                $insertQuery = "INSERT INTO wallet (user_id, amount, utr_id, status) VALUES (?, ?, ?, 'Pending')";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param("ids", $user_id, $amount, $utr);
                
                if ($stmt->execute()) 
                {
                    // Update the total_wallet table
                    $totalWalletQuery = "SELECT balance FROM total_wallet WHERE user_id = ?";
                    $stmt = $conn->prepare($totalWalletQuery);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // User exists, update the balance
                        $updateTotalQuery = "UPDATE total_wallet SET utr_id = ?, balance = balance + ? WHERE user_id = ?";
                        $stmt = $conn->prepare($updateTotalQuery);
                        $stmt->bind_param("idi", $utr, $amount, $user_id);

                        if ($stmt->execute()) {
                            $response["success"] = true;
                            $response["message"] = "Amount added to wallet successfully.";
                        } else {
                            $response["message"] = "Database error: Could not update total wallet.";
                        }
                    } else {
                        // Insert a new entry into total_wallet
                        $insertTotalQuery = "INSERT INTO total_wallet (user_id, balance, status) VALUES (?, ?, 'success')";
                        $stmt = $conn->prepare($insertTotalQuery);
                        $stmt->bind_param("id", $user_id, $amount);
                        if ($stmt->execute()) {
                            $response["success"] = true;
                            $response["message"] = "Amount added to wallet successfully.";
                        } else {
                            $response["message"] = "Database error: Could not insert into total wallet.";
                        }
                    }
                    $stmt->close();
                } else {
                    $response["message"] = "Database error: Could not insert wallet transaction.";
                }
            } else {
                // If not invited by anyone, insert the original amount
                $insertQuery = "INSERT INTO wallet (user_id, amount, utr_id, status) VALUES (?, ?, ?, 'Pending')";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param("ids", $user_id, $amount, $utr);

                if ($stmt->execute()) {
                    // Update the total_wallet table
                    $totalWalletQuery = "SELECT balance FROM total_wallet WHERE user_id = ?";
                    $stmt = $conn->prepare($totalWalletQuery);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // User exists, update the balance
                        $updateTotalQuery = "UPDATE total_wallet SET utr_id = ?, balance = balance + ? WHERE user_id = ?";
                        $stmt = $conn->prepare($updateTotalQuery);
                        $stmt->bind_param("idi", $utr, $amount, $user_id);

                        if ($stmt->execute()) {
                            $response["success"] = true;
                            $response["message"] = "Amount added to wallet successfully.";
                        } else {
                            $response["message"] = "Database error: Could not update total wallet.";
                        }
                    } else {
                        // Insert a new entry into total_wallet
                        $insertTotalQuery = "INSERT INTO total_wallet (user_id, balance, status) VALUES (?, ?, 'success')";
                        $stmt = $conn->prepare($insertTotalQuery);
                        $stmt->bind_param("id", $user_id, $amount);
                        if ($stmt->execute()) {
                            $response["success"] = true;
                            $response["message"] = "Amount added to wallet successfully.";
                        } else {
                            $response["message"] = "Database error: Could not insert into total wallet.";
                        }
                    }
                    $stmt->close();
                } else {
                    $response["message"] = "Database error: Could not insert wallet transaction.";
                }
            }
        } else {
            // Insert the transaction without commission if not the first time or amount < 100
            $insertQuery = "INSERT INTO wallet (user_id, amount, utr_id, status) VALUES (?, ?, ?, 'Pending')";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ids", $user_id, $amount, $utr);
            if ($stmt->execute()) {
                // Update the total_wallet table
                $totalWalletQuery = "SELECT balance FROM total_wallet WHERE user_id = ?";
                $stmt = $conn->prepare($totalWalletQuery);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // User exists, update the balance
                    $updateTotalQuery = "UPDATE total_wallet SET utr_id = ?, balance = balance + ? WHERE user_id = ?";
                    $stmt = $conn->prepare($updateTotalQuery);
                    $stmt->bind_param("idi", $utr, $amount, $user_id);

                    if ($stmt->execute()) {
                        $response["success"] = true;
                        $response["message"] = "Amount added to wallet successfully.";
                    } else {
                        $response["message"] = "Database error: Could not update total wallet.";
                    }
                } else {
                    // Insert a new entry into total_wallet
                    $insertTotalQuery = "INSERT INTO total_wallet (user_id, balance, status) VALUES (?, ?, 'success')";
                    $stmt = $conn->prepare($insertTotalQuery);
                    $stmt->bind_param("id", $user_id, $amount);
                    if ($stmt->execute()) {
                        $response["success"] = true;
                        $response["message"] = "Amount added to wallet successfully.";
                    } else {
                        $response["message"] = "Database error: Could not insert into total wallet.";
                    }
                }
                $stmt->close();
            } else {
                $response["message"] = "Database error: Could not insert wallet transaction.";
            }
        }
    } else {
        $response["message"] = "Please provide all required information.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
