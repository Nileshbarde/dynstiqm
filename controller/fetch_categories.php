<?php
include 'db_connection.php'; 
// Handle fetching all categories
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch_all') {
    $sql = "SELECT id, name, type, image FROM categories";
    $result = $conn->query($sql);
    $categories = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    echo json_encode($categories);
    exit;
}

// Handle fetching a single category
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch') {
    $id = intval($_GET['id']);
    $sql = "SELECT id, name, type, image FROM categories WHERE id = ?";
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
    $type = htmlspecialchars($_POST['type']);
    $image_path = '';

    // Handle the file upload if a new file is provided
    if (isset($_FILES['img']) && $_FILES['img']['name']) {
        $target_dir = "uploads/";
        $image_path = $target_dir . basename($_FILES["img"]["name"]);
        move_uploaded_file($_FILES["img"]["tmp_name"], $image_path);
    }

    // Prepare the SQL query
    $sql = "UPDATE categories SET name = ?, type = ?";
    if ($image_path) {
        $sql .= ", image = ?";
    }
    $sql .= " WHERE id = ?";

    $stmt = $conn->prepare($sql);
    if ($image_path) {
        $stmt->bind_param("sssi", $name, $type, $image_path, $id);
    } else {
        $stmt->bind_param("ssi", $name, $type, $id);
    }

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Category updated successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to update category'];
    }
    echo json_encode($response);
    exit;
}

// Handle deleting a category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM categories WHERE id = ?";
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
