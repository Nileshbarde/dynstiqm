<?php
include 'db_connection.php';

$response = ['status' => 'error', 'message' => 'Something went wrong'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $promotion_code = htmlspecialchars($_POST['promotion_code']);
    $promotion_amt = htmlspecialchars($_POST['promotion_amt']);
    $notice = htmlspecialchars($_POST['notice']);

    $stmt = $conn->prepare("INSERT INTO promotions (promotion_code, promotion_amt, notice) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $promotion_code, $promotion_amt, $notice);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Promotion added successfully'];
    } else {
        $response['message'] = 'Failed to add category';
    }
    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>
