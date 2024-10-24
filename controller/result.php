<?php
include 'db_connection.php';

// Get the current period dynamically (e.g., based on the current time)
$current_period = date('YmdHi'); // Use current date and hour-minute format

// Fetch all user selections for the current period
$sql = "SELECT * FROM joins WHERE period = '$current_period'";
$result = $conn->query($sql);

$user_selections = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $user_selections[] = $row;
    }
}

// Find the user with the lowest contract amount and get their selected number
$lowest_contract = PHP_INT_MAX;
$winning_number = -1;

foreach ($user_selections as $selection) {
    if ($selection['contract_money'] < $lowest_contract) {
        $lowest_contract = $selection['contract_money'];
        $winning_number = $selection['number']; // Assuming you have a 'number' field in your `joins` table
    }
}

// Determine the winning color based on the number
$winning_color = '';
if (in_array($winning_number, [1, 3, 5, 7, 9])) {
    $winning_color = 'green';
} elseif (in_array($winning_number, [2, 4, 6, 8])) {
    $winning_color = 'red';
} elseif (in_array($winning_number, [0, 5])) {
    $winning_color = 'violet';
}

// Calculate the winnings for each user
foreach ($user_selections as $selection) {
    $user_id = $selection['user_id'];
    $contract_money = $selection['contract_money'];
    $quantity = $selection['quantity'];
    $total = $selection['total'];
    $cat_id = $selection['cat_id'];
    $subcat_id = $selection['subcat_id'];
    $selected_number = $selection['number']; // Assuming you have a 'number' field in your `joins` table

    // Determine the category color
    $cat_color = '';
    switch ($cat_id) {
        case 1:
            $cat_color = 'green';
            break;
        case 2:
            $cat_color = 'violet';
            break;
        case 3:
            $cat_color = 'red';
            break;
    }

    // Calculate the contract amount after deducting the 5% fee
    $contract_amount_after_fee = $contract_money * 0.95;

    // Calculate the user's winnings based on the rules
    $winnings = 0;
    if ($cat_color === $winning_color) {
        if ($winning_number == 5 || $winning_number == 0) {
            $winnings = $contract_amount_after_fee * 1.5;
        } else {
            $winnings = $contract_amount_after_fee * 2;
        }
    } elseif ($winning_color === 'violet' && ($winning_number == 0 || $winning_number == 5)) {
        $winnings = $contract_amount_after_fee * 5.5;
    }

    // Store the results in a results table or update the user's account balance accordingly
    $sql = "INSERT INTO results (user_id, period, contract_money, winnings, cat_id, number, winning_number, winning_color) 
            VALUES ($user_id, '$current_period', $contract_money, $winnings, $cat_id, $selected_number, $winning_number, '$winning_color')";
    $conn->query($sql);
}

// Save the result of the current period
$sql = "INSERT INTO rounds (period, winning_number, winning_color) VALUES ('$current_period', '$winning_number', '$winning_color')";
$conn->query($sql);

$conn->close();
?>
