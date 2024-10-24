<?php
session_start();
if (!isset($_SESSION['mobile_number'])) {
    header("Location: ../signin.php");
    exit();
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>H Dynasta - Recharge</title>
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
                            <i class="fa fa-university fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Wallet</p>
                                <h6 class="mb-0" id="todayWallet">₹0</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-wallet fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Interest</p>
                                <h6 class="mb-0" id="interest">₹0</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Add Wallet</h6>
                            <form id="walletForm">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="amountInput" name="amount" placeholder="Amount">
                                    <label for="amountInput">Amount</label>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-xl-3 mb-2">
                                        <button type="button" class="btn btn-primary amount-btn" data-amount="100">₹ 100</button>
                                    </div>
                                    <div class="col-sm-6 col-xl-3 mb-2">
                                        <button type="button" class="btn btn-primary amount-btn" data-amount="500">₹ 500</button>
                                    </div>
                                    <div class="col-sm-6 col-xl-3 mb-2">
                                        <button type="button" class="btn btn-primary amount-btn" data-amount="1000">₹ 1000</button>
                                    </div>
                                    <div class="col-sm-6 col-xl-3 mb-2">
                                        <button type="button" class="btn btn-primary amount-btn" data-amount="2000">₹ 2000</button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary py-2 w-100 mb-3 mt-4">Add Wallet</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="container-fluid pt-4 px-4">
                    <div class="bg-light text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Wallet</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0" id="walletTable">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <!-- <th>User ID</th> -->
                                    <th>UTR ID</th>
                                    <th>Amount</th>
                                    <th>Transaction ID</th>
                                    <th>Transaction Date</th>
                                    <th>Payment By</th>
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
         // Handle amount button clicks
         $('.amount-btn').on('click', function() {
                var amount = $(this).data('amount');
                $('#amountInput').val(amount);
            });
            
        document.getElementById('walletForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const amount = document.getElementById('amountInput').value;
            if (amount) {
                // Base64 encode the amount
                const encodedAmount = btoa(amount);
                // Redirect to UPI payment page with encoded amount
                window.location.href = `upi.php?pay=${encodedAmount}`;
            } else {
                alert("Please enter an amount.");
            }
        });
    </script>
    
    <script>
        $(document).ready(function() {
            function fetchWalletData() {
                $.ajax({
                    url: '../controller/wallet.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#todayWallet').text('₹' + response.today_wallet);
                        $('#totalMoney').text('₹' + response.total_money);
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
                    url: '../controller/fetch_wallet_details.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var walletTable = $('#walletTable tbody');
                        walletTable.empty();
                        $.each(response, function(index, wallet) {
                            var row = '<tr>' +
                                '<td>' + wallet.id + '</td>' +
                                '<td>' + wallet.utr_id + '</td>' +
                                '<td>' + wallet.amount + '</td>' +
                                '<td>' + wallet.transction_id + '</td>' +
                                '<td>' + wallet.transc_date + '</td>' +
                                '<td>' + wallet.payment_by + '</td>' +
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

    <!-- <script>
        $(document).ready(function() {
            // Handle amount button clicks
            $('.amount-btn').on('click', function() {
                var amount = $(this).data('amount');
                $('#amountInput').val(amount);
            });

            // Handle form submission
            $('#walletForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '../controller/add_wallet.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Wallet added successfully!');
                            $('#amountInput').val(''); // Clear the input field
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while adding the wallet.');
                    }
                });
            });
        });
    </script> -->

    <!-- Fetchwalletbyid -->
    <script>
        $(document).ready(function() {
            function fetchWalletData() {
                $.ajax({
                    url: '../controller/fetchwalletbyid.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#todayWallet').text('₹' + response.today_wallet);
                        $('#interest').text('₹' + response.total_interest);
                    },
                    error: function() {
                        $('#todayWallet').text('₹0');
                        $('#interest').text('₹0');
                        console.error('An error occurred while fetching wallet data.');
                    }
                });
            }
            // Fetch wallet data on page load
            fetchWalletData();
        });
    </script>

  

</body>
</html>