<?php
    session_start();
    include 'db_connection.php';

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["error" => "User not logged in"]);
        exit;
    }
    
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $name = $_POST['name'];
        $ifsc_code = $_POST['ifsc_code'];
        $bank_name = $_POST['bank_name'];
        $bank_account = $_POST['bank_account'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $mobile_no = $_POST['mobile_no'];
        $email = $_POST['email'];
        $acc_user_id = $_POST['acc_user_id'];
        $code = $_POST['code'];
        // $otp = $_POST['otp'];
        $status = $_POST['status'];

        $sql = "SELECT * FROM bank_card";
        $result = $conn->query($sql);
        
        if ($result->num_rows == 0) 
        {
            $sql = "INSERT INTO bank_card (user_id, name, ifsc_code, bank_name, bank_account, state, city, address, mobile_no, email, acc_user_id, code, status) VALUES ('$user_id','$name', '$ifsc_code', '$bank_name', '$bank_account', '$state', '$city', '$address', '$mobile_no', '$email', '$acc_user_id', '$code', '$status')";
        

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "New bank details added successfully"]);
            } else {
                echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
            }
        } else {
            echo json_encode(["message" => "Bank Data Already Existed"]);
        }

        $conn->close();
    }
?>
