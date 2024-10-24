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
    <title>H Dynasta - Result History</title>
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
                <div class="row">
                    <!-- <div class="col-sm-12 col-xl-4">
                        <a href="bank_account.php" class="btn btn-success text-white mb-3">
                           Order History
                        </a>
                    </div> -->
                </div>
                <div class="bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">View Orders</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0" id="example">
                            <thead>
                                <tr class="text-dark">
                                    <th>#</th> <!-- Auto-incrementing value -->
                                    <th>Mobile Number</th>
                                    <th>Contract Money</th>
                                    <th>Contract Count</th>
                                    <th>Delivery</th>
                                    <th>Fee</th>
                                    <th>Price</th>
                                    <th>Number</th>
                                    <th>Color</th>
                                    <th>Results</th>
                                    <th>Select</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be dynamically added here -->
                            </tbody>
                        </table>
                        <div id="message" class="mt-3"></div>
                    </div>
                </div>
            </div>
            <!-- Form End -->

            <?php include 'include/footer.php'; ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top">
            <i class="bi bi-arrow-up"></i>
        </a>
    </div>

    <?php include 'include/script.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        function fetchData() {
            $.ajax({
                url: '../controller/fetch_allresult.php', // Adjust the path to your PHP script
                type: 'POST',
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        
                        if (response.success) {
                            var data = response.userRecords;

                            // Ensure data is an array before attempting to use forEach
                            if (Array.isArray(data)) {
                                // Clear previous data
                                $('#example tbody').empty();

                                // Add auto-incrementing values and display the data
                                data.forEach((item, index) => {
                                    var row = `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${item.mobile_number}</td>
                                            <td>${item.contract_money}</td>
                                            <td>${item.contract_count}</td>
                                            <td>${item.delivery}</td>
                                            <td>${item.fee}</td>
                                            <td>${item.price}</td>
                                            <td>${item.number}</td>
                                            <td>${item.color}</td>
                                            <td>${item.results}</td>
                                            <td>${item.select}</td>
                                            <td>${item.status}</td>
                                            <td>${item.created_at}</td>
                                        </tr>
                                    `;
                                    $('#example tbody').append(row);
                                });

                                // Initialize DataTable after adding rows
                                $('#example').DataTable();
                            } else {
                                $('#message').text('No data found.');
                            }
                        } else {
                            $('#message').text(response.message);
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        $('#message').text('An error occurred while processing the response.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#message').text('An error occurred while fetching the results.');
                }
            });
        }

        // Call the function to fetch data
        fetchData();
    </script>

</body>
</html>