<?php
    session_start();
    include 'db_connection.php';

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["error" => "User not logged in"]);
        exit;
    }
    
    $user_id = $_SESSION['user_id'];

    $response = array();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $id = $_POST['id'];
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $ifsc_code = $_POST['ifsc_code'];
        $bank_name = $_POST['bank_name'];
        $bank_account = $_POST['bank_account'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $mobile_no = $_POST['mobile_no'];
        $email = $_POST['email'];
        $code = $_POST['code'];
        $status = $_POST['status'];

        $sql = "UPDATE `bank_card` SET `user_id` = '$user_id', `name` = '$name', `ifsc_code` = '$ifsc_code', `bank_name` = '$bank_name', `bank_account` = '$bank_account', `state` = '$state', `city` = '$city', `address` = '$address', `mobile_no` = '$mobile_no', `email` = '$email', `code` = '$code', `status` = '$status' WHERE id = '$id'";
        
        if (mysqli_query($conn, $sql)) {
            $response['status'] = 'success';
            $response['message'] = 'Bank details updated successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to Update Bank Details: ' . mysqli_error($conn);
        }
    }

    echo json_encode($response);

    mysqli_close($conn);
?>