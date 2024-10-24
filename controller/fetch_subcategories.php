<?php
include 'db_connection.php';

// Handle fetching all categories
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch_categories') {
    $sql = "SELECT id, name FROM categories";
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

// Handle fetching all subcategories
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch_all_subcategories') {
    $sql = "SELECT s.id, s.sub_name, s.image, c.name 
            FROM subcategories s
            JOIN categories c ON s.cat_id = c.id";
    $result = $conn->query($sql);
    $subcategories = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subcategories[] = $row;
        }
    }
    echo json_encode($subcategories);
    exit;
}

// Handle fetching a single subcategory
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch_subcategory') {
    $id = intval($_GET['id']);
    $sql = "SELECT id, sub_name, cat_id,  image FROM subcategories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $subcategory = $result->fetch_assoc();
    echo json_encode($subcategory);
    exit;
}

// Handle updating a subcategory
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_subcategory') {
    $id = intval($_POST['id']);
    $sub_name = htmlspecialchars($_POST['sub_name']);
    $id = intval($_POST['id']);
   
    $image_path = '';

    // Handle the file upload if a new file is provided
    if (isset($_FILES['img']) && $_FILES['img']['name']) {
        $target_dir = "uploads/";
        $image_path = $target_dir . basename($_FILES["img"]["name"]);
        move_uploaded_file($_FILES["img"]["tmp_name"], $image_path);
    }

    // Prepare the SQL query
    $sql = "UPDATE subcategories SET sub_name = ?, id = ?";
    if ($image_path) {
        $sql .= ", image = ?";
    }
    $sql .= " WHERE id = ?";

    $stmt = $conn->prepare($sql);
    if ($image_path) {
        $stmt->bind_param("sisi", $sub_name, $id, $image_path, $id);
    } else {
        $stmt->bind_param("sii", $sub_name, $id, $id);
    }

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Subcategory updated successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to update subcategory'];
    }
    echo json_encode($response);
    exit;
}

// Handle deleting a subcategory
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_subcategory') {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM subcategories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Subcategory deleted successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to delete subcategory'];
    }
    echo json_encode($response);
    exit;
}
?>