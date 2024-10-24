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
    <title>H Dynasta - Withdraw</title>
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
                                <p class="mb-2">Total Withdraw</p>
                                <h6 class="mb-0" id="todayWWallet">₹0</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-university fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Balance</p>
                                <h6 class="mb-0" id="totalMoney">₹0</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid pt-4 px-4">
                <!-- <div class="row">
                    <div class="col-sm-12 col-xl-4">
                        <a href="users.php" class="btn btn-success text-white mb-3">
                            Add Users
                        </a>
                    </div>
                </div> -->
                <?php 
                    if(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 2) {
                ?>
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Withdraw</h6>
                </div>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0" id="walletTable">
                        <thead>
                            <tr class="text-dark">
                                <th scope="col">
                                    <input class="form-check-input" type="checkbox">
                                </th>
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
                 <?php 
                    }
                ?>
                <?php 
                    if(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1) {
                ?>
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Withdraw Request</h6>
                </div>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0" id="walletTable">
                        <thead>
                            <tr class="text-dark">
                                <th scope="col">
                                    <input class="form-check-input" type="checkbox">
                                </th>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Withdraw Date</th>
                                <th>Status</th>
                                <th>Action</th> <!-- New column for action -->
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <?php 
                    }
                ?>
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
            function fetchWalletData() {
                $.ajax({
                    url: '../controller/wallet.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#todayWWallet').text('₹' + response.todayWWallet);
                        $('#totalMoney').text('₹' + response.todaybalance);
                    },
                    error: function() {
                        $('#todayWallet').text('₹0');
                        $('#totalMoney').text('₹0');
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
                    url: '../controller/fetch_wwallet_details.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var walletTable = $('#walletTable tbody');
                        walletTable.empty();
                        $.each(response, function(index, wallet) {
                            var row = '<tr>' +
                                '<td>' + wallet.id + '</td>' +
                                '<td>' + wallet.mobile_number + '</td>' +
                                '<td class="withdraw-amount">' + wallet.witdraw_amount + '</td>' +
                                '<td>' + wallet.withdraw_date + '</td>' +
                                '<td>' + wallet.status + '</td>' +
                                '<td>' +
                                   '<select class="status-dropdown" data-id="' + wallet.id + '" data-user-id="' + wallet.user_id + '"  data-amount="' + wallet.witdraw_amount + '">' +
                                        '<option value="Pending"' + (wallet.status == 'Pending' ? ' selected' : '') + '>Pending</option>' +
                                        '<option value="Approved"' + (wallet.status == 'Approved' ? ' selected' : '') + '>Approved</option>' +
                                        '<option value="Rejected"' + (wallet.status == 'Rejected' ? ' selected' : '') + '>Rejected</option>' +
                                    '</select>' +
                                '</td>' +
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

            // Handle status change
            $(document).on('change', '.status-dropdown', function() {
                var walletId = $(this).data('id');
                var newStatus = $(this).val();
                var withdrawAmount = $(this).data('amount');
                var userId = $(this).data('user-id');
                withdrawAmount = parseFloat(withdrawAmount);

                if (isNaN(withdrawAmount)) {
                    alert('Invalid withdraw amount');
                    return;
                }

                $.ajax({
                    url: '../controller/update_wallet_status.php',
                    type: 'POST',
                    data: {
                        id: walletId,
                        status: newStatus,
                        user_id: userId
                    },
                    success: function(response) {
                        if (newStatus === 'Approved') {
                            updateTotalWalletBalance(withdrawAmount, userId);
                        }
                        alert('Status updated successfully');
                        window.location.reload(); // Reload the page
                    },
                    error: function() {
                        alert('An error occurred while updating the status.');
                    }
                });
            });


            function updateTotalWalletBalance(amount, userId) {
                $.ajax({
                    url: '../controller/update_total_wallet_balance.php',
                    type: 'POST',
                    data: {
                        amount: amount,
                        user_id: userId
                    },
                    success: function(response) {
                        // Optionally handle success response
                        console.log('Total wallet balance updated successfully');
                    },
                    error: function() {
                        alert('An error occurred while updating the total wallet balance.');
                    }
                });
            }
        });
    </script>

</body>
</html>