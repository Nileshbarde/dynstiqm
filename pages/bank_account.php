<?php
session_start();
if (!isset($_SESSION['mobile_number'])) {
    header("Location: ../signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>H Dynasta - Bank Account</title>
    <?php include 'include/style.php'; ?>
</head>
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
      
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <?php include 'include/header.php'; ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
          <?php include 'include/navbar.php'; ?>
            <!-- Navbar End -->


            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <div class="col-sm-12 col-xl-4">
                        <a href="bank_account_view.php" class="btn btn-info text-white mb-3">View Bank Account
                        </a>
                    </div>
                </div>
        
                <div class="row g-4">
                    <div class="col-sm-8 col-xl-8">
                        <div class="bg-light categoriesed h-100 p-4">
                        <form id="bankForm">
                            <input type="hidden" id="acc_user_id" name="acc_user_id" required>
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="ifsc_code">IFSC Code</label>
                                <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="bank_name">Bank Name</label>
                                <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="bank_account">Bank Account</label>
                                <input type="text" class="form-control" id="bank_account" name="bank_account" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="state">State</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="mobile_no">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile_no" name="mobile_no" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" id="code" name="code" required>
                            </div>
                            <!-- <div class="form-group mb-3">
                                <label for="otp">OTP</label>
                                <input type="text" class="form-control" id="otp" name="otp" required>
                            </div> -->
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <input type="text" class="form-control" id="status" name="status" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Bank Details</button>
                        </form>
                        <div id="message"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->

            <!-- Footer Start -->
            <?php include 'include/footer.php'; ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php include 'include/script.php'; ?>

    <script>
        $(document).ready(function() {
            function fetchUserDetails() {
                $.ajax({
                    url: '../controller/fetch_usersbyid.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.length > 0) {
                            var user = response[0]; // Assuming response is an array with one user object
                            $('#user_id').val(user.id);
                            $('#mobile_no').val(user.mobile_number);
                        }
                    },
                    error: function() {
                        $('#message').html('<div class="alert alert-danger">An error occurred while fetching user details.</div>');
                    }
                });
            }

            fetchUserDetails();
        });
        
        $('#bankForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '../controller/add_bank_account.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.message) {
                        $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                        $('#bankForm')[0].reset();
                        fetchDetails();
                    } else if (response.error) {
                        $('#message').html('<div class="alert alert-danger">' + response.error + '</div>');
                    }
                },
                error: function() {
                    $('#message').html('<div class="alert alert-danger">An error occurred while adding bank details.</div>');
                }
            });
        });
    </script>
</body>
</html>