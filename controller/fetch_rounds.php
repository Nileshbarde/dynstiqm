<?php
include 'db_connection.php'; 
// Handle fetching all round
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch_all') {
    $sql = "SELECT id, name FROM round";
    $result = $conn->query($sql);
    $round = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $round[] = $row;
        }
    }
    echo json_encode($round);
    exit;
}

// Handle fetching a single category
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch') {
    $id = intval($_GET['id']);
    $sql = "SELECT id, name FROM round WHERE id = ?";
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
    $name = htmlspecialchars($_POST['name']);
   
    // Prepare the SQL query
    $sql = "UPDATE round SET name = ?";
    $sql .= " WHERE id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
       $stmt->bind_param("si", $name, $id);
    }

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Round updated successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to update round'];
    }
    echo json_encode($response);
    exit;
}

// Handle deleting a category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM round WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Category deleted successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to delete category'];
    }
    echo json_encode($response);
    exit;
}
?>
