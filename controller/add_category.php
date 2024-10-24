<?php
include 'db_connection.php';

$response = ['status' => 'error', 'message' => 'Something went wrong'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $type = htmlspecialchars($_POST['type']);
    $status = htmlspecialchars($_POST['status']);
    
    $image = $_FILES['img'];

    // Handle the file upload
    if ($image['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an actual image or fake image
        $check = getimagesize($image["tmp_name"]);
        if ($check !== false) {
            // Allow certain file formats
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($imageFileType, $allowed_types)) {
                if (move_uploaded_file($image["tmp_name"], $target_file)) {
                    // Insert data into the database
                    $stmt = $conn->prepare("INSERT INTO categories (name, type, status, image) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $name, $type, $status, $target_file);

                    if ($stmt->execute()) {
                        $response = ['status' => 'success', 'message' => 'Category added successfully'];
                    } else {
                        $response['message'] = 'Failed to add category';
                    }
                    $stmt->close();
                } else {
                    $response['message'] = 'Failed to upload image';
                }
            } else {
                $response['message'] = 'Invalid file type';
            }
        } else {
            $response['message'] = 'File is not an image';
        }
    } else {
        $response['message'] = 'Error uploading file';
    }
}

$conn->close();
echo json_encode($response);
?>
