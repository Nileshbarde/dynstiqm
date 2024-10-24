<?php
include 'db_connection.php';

// Fetch current timestamp (minute precision)
$currentTimestamp = date('Y-m-d H:i');

// Start transaction
$conn->begin_transaction();

try {
    // Lock the table to prevent concurrent updates
    $conn->query("LOCK TABLES unique_counters WRITE");

    // Fetch the current counter value and timestamp
    $sql = "SELECT counter, timestamp FROM unique_counters ORDER BY timestamp DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastTimestamp = $row['timestamp'];
        $counter = $row['counter'];

        if ($currentTimestamp == $lastTimestamp) {
            // Serve the same unique number if within the same minute
            $uniqueNumber = $counter;
        } else {
            // Increment the counter for the new minute
            $counter++;
            $uniqueNumber = $counter;
            $sql = "INSERT INTO unique_counters (timestamp, counter) VALUES ('$currentTimestamp', $counter)";
            $conn->query($sql);
        }
    } else {
        // Initialize the counter if no records exist
        $counter = 1;
        $uniqueNumber = $counter;
        $sql = "INSERT INTO unique_counters (timestamp, counter) VALUES ('$currentTimestamp', $counter)";
        $conn->query($sql);
    }

    // Commit the transaction
    $conn->commit();

    // Unlock the table
    $conn->query("UNLOCK TABLES");

    // Return the unique number
    echo json_encode(['uniqueNumber' => date('Ymd') . str_pad($uniqueNumber, 3, '0', STR_PAD_LEFT)]);
} catch (Exception $e) {
    // Rollback the transaction in case of an error
    $conn->rollback();
    echo json_encode(['error' => 'An error occurred while generating the unique number.']);
}

$conn->close();
?>
