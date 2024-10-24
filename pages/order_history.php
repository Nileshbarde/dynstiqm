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
    <title>H Dynasta - Order History</title>
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
                                    <th>ID</th>
                                    <th>Contract Money</th>
                                    <th>Quantity</th>
                                    <!-- <th>Total</th> -->
                                    <th>User Mob. Number</th>
                                    <th>Numbers</th>
                                    <th>Period</th>
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

            <!-- Modal for Editing -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Bank Account </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editBankCardForm">
                                <input type="hidden" name="id" class="form-control" id="editId" required value="">
                                <input type="hidden" name="user_id" class="form-control" id="userId" required value="">
                                <div class="form-group">
                                    <label for="editName">Name</label>
                                    <input type="text" class="form-control" id="editName" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="editIfscCode">IFSC Code</label>
                                    <input type="text" class="form-control" id="editIfscCode" name="ifsc_code" required>
                                </div>
                                <div class="form-group">
                                    <label for="editBankName">Bank Name</label>
                                    <input type="text" class="form-control" id="editBankName" name="bank_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="editBankAccount">Bank Account</label>
                                    <input type="text" class="form-control" id="editBankAccount" name="bank_account" required>
                                </div>
                                <div class="form-group">
                                    <label for="editState">State</label>
                                    <input type="text" class="form-control" id="editState" name="state" required>
                                </div>
                                <div class="form-group">
                                    <label for="editCity">City</label>
                                    <input type="text" class="form-control" id="editCity" name="city" required>
                                </div>
                                <div class="form-group">
                                    <label for="editAddress">Address</label>
                                    <input type="text" class="form-control" id="editAddress" name="address" required>
                                </div>
                                <div class="form-group">
                                    <label for="editMobileNo">Mobile No</label>
                                    <input type="text" class="form-control" id="editMobileNo" name="mobile_no" required>
                                </div>
                                <div class="form-group">
                                    <label for="editEmail">Email</label>
                                    <input type="email" class="form-control" id="editEmail" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="editCode">Code</label>
                                    <input type="text" class="form-control" id="editCode" name="code" required>
                                </div>
                                <div class="form-group">
                                    <label for="editStatus">Status</label>
                                    <input type="text" class="form-control" id="editStatus" name="status" required>
                                </div>
                                <button type="submit" class="btn btn-primary mt-5">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

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
        url: '../controller/fetch_all_joins.php', // Adjust path to your PHP script
        type: 'POST',
        success: function(response) {
            try {
                response = JSON.parse(response);
                if (response.success) {
                    var allJoins = response.allJoins;

                    // Clear previous data
                    $('#example tbody').empty();

                    // Display all data with auto-increment index
                    allJoins.forEach(function(join, index) {
                        var row = `
                            <tr>
                                <td>${index + 1}</td> <!-- Auto-increment index -->
                                <td>${join.contract_money}</td>
                                <td>${join.quantity}</td>
                               
                                <td>${join.user_mobile_number}</td> <!-- Mobile number -->
                                <td>${join.cat_id}</td>
                                <td>${join.period}</td>
                            </tr>
                        `;
                        $('#example tbody').append(row);
                    });

                    // Initialize DataTable after adding rows
                    $('#example').DataTable();
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

// Call the function to fetch and display data
fetchData();

    </script>

</body>
</html>