<?php
include 'db_connection.php'; 
// Handle fetching all users
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch_all') {
    $sql = "SELECT id, mobile_number, password, image FROM users";
    $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    echo json_encode($users);
    exit;
}

// Handle fetching a single Users
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch') {
    $id = intval($_GET['id']);
    $sql = "SELECT id, mobile_number, password, image FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $Users = $result->fetch_assoc();
    echo json_encode($Users);
    exit;
}

// Handle updating a Users
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = intval($_POST['id']);
    $mobile_number = htmlspecialchars($_POST['mobile_number']);
    $password = htmlspecialchars($_POST['password']);
    $image_path = '';

    // Handle the file upload if a new file is provided
    if (isset($_FILES['img']) && $_FILES['img']['name']) {
        $target_dir = "uploads/";
        $image_path = $target_dir . basename($_FILES["img"]["name"]);
        move_uploaded_file($_FILES["img"]["tmp_name"], $image_path);
    }

    // Prepare the SQL query
    $sql = "UPDATE users SET mobile_number = ?, password = ?";
    if ($image_path) {
        $sql .= ", image = ?";
    }
    $sql .= " WHERE id = ?";

    $stmt = $conn->prepare($sql);
    if ($image_path) {
        $stmt->bind_param("sssi", $mobile_number, $password, $image_path, $id);
    } else {
        $stmt->bind_param("ssi", $mobile_number, $password, $id);
    }

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Users updated successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to update Users'];
    }
    echo json_encode($response);
    exit;
}

// Handle deleting a Users
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Users deleted successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to delete Users'];
    }
    echo json_encode($response);
    exit;
}
?>
