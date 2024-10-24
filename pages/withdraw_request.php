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
    <title>H Dynasta - Withdraw Request</title>
    <?php include 'include/style.php'; ?>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
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
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-wallet fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Withdrawed</p>
                                <h6 class="mb-0" id="todayWWallet">₹0</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-wallet fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Balance</p>
                                <h6 class="mb-0" id="mianBalance">₹0</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid pt-4 px-4">
                <!-- <div class="row">
                    <div class="col-sm-12 col-xl-4">
                        <a href="users.php" class="btn btn-success text-white mb-3">
                            Withdrawl Request
                        </a>
                    </div>
                </div>  -->
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light categoriesed h-100 p-4">
                        <form id="withdrawForm" enctype="multipart/form-data">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount">
                                <label for="amount">Amount</label>
                            </div>
                            <button type="submit" class="btn btn-primary py-2 w-100 mb-3 mt-2">Withdraw Request</button>
                        </form>
                        <div id="message"></div>
                        </div>
                    </div>
                </div>
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Recent Withdraw</h6>
                </div>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0" id="walletTable">
                        <thead>
                            <tr class="text-dark">
                                <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Withdraw Date</th>
                                <th>Status</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            <!-- Form End -->

            <!-- Footer Start -->
            <?php include 'include/footer.php'; ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php include 'include/script.php'; ?>
    <script>
        $(document).ready(function() {
            $('#withdrawForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize(); // Serialize the form data
                $.ajax({
                    url: '../controller/process_withdraw.php', // Change this to your PHP script
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#message').html(response); // Display the server response

                        // Check if the response indicates success
                        if (response.includes('success')) {
                            location.reload(); // Reload the page after success
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', error);
                        $('#message').html('<p>An error occurred. Please try again.</p>');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            function fetchWalletData() {
                $.ajax({
                    url: '../controller/withdraw_wallet.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#todayWWallet').text('₹' + response.total_wamount);
                        $('#mianBalance').text('₹' + response.balance);
                    },
                    error: function() {
                        $('#todayWWallet').text('₹0');
                        $('#mianBalance').text('₹0');
                        console.error('An error occurred while fetching wallet data.');
                    }
                });
            }
            // Fetch wallet data on page load
            fetchWalletData();
        });
    </script>

    <script>
        $(document).ready(function() {
            function fetchWalletDetails() {
                $.ajax({
                    url: '../controller/fetch_withwallet_details.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var walletTable = $('#walletTable tbody');
                        walletTable.empty();
                        $.each(response, function(index, wallet) {
                            var row = '<tr>' +
                                '<td>' + wallet.id + '</td>' +
                                '<td>' + wallet.mobile_number + '</td>' +
                                '<td>' + wallet.witdraw_amount + '</td>' +
                                '<td>' + wallet.withdraw_date + '</td>' +
                                '<td>' + wallet.status + '</td>' +
                            '</tr>';
                            walletTable.append(row);
                        });
                    },
                    error: function() {
                        $('#message').html('<div class="alert alert-danger">An error occurred while fetching wallet details.</div>');
                    }
                });
            }

            // Fetch wallet details on page load
            fetchWalletDetails();

          
        });
    </script>

</body>
</html>