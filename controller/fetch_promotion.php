<?php
include 'db_connection.php'; 
// Handle fetching all categories
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch_all') {
    $sql = "SELECT `id`, `promotion_code`, `promotion_amt`, `notice`, `status` FROM `promotions`";
    $result = $conn->query($sql);
    $promotion = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $promotion[] = $row;
        }
    }
    echo json_encode($promotion);
    exit;
}

// Handle fetching a single category
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch') {
    $id = intval($_GET['id']);
    $sql = "SELECT `id`, `promotion_code`, `promotion_amt`, `notice`, `status` FROM `promotions` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    echo json_encode($category);
    exit;
}

// Handle updating a category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = intval($_POST['id']);
    $promotion_code = htmlspecialchars($_POST['promotion_code']);
    $promotion_amt = htmlspecialchars($_POST['promotion_amt']);
    $notice = htmlspecialchars($_POST['notice']);
   

    // Prepare the SQL query
    $sql = "UPDATE promotions SET promotion_code=?, promotion_amt=?, notice=?";
    $sql .= " WHERE id = ?";

    $stmt = $conn->prepare($sql);
   
    $stmt->bind_param("sssi", $promotion_code, $promotion_amt, $notice, $id);
    
    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Promotion updated successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to update promotion'];
    }
    echo json_encode($response);
    exit;
}

// Handle deleting a category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM promotions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Promotions deleted successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to delete promotions'];
    }
    echo json_encode($response);
    exit;
}
?>
