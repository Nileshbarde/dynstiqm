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
    <title>H Dynasta - Bank Account View</title>
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
                    <div class="col-sm-12 col-xl-4">
                        <a href="bank_account.php" class="btn btn-success text-white mb-3">
                            Add Bank Account
                        </a>
                    </div>
                </div>
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">View Bank Account</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0" id="bankTable">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <th>Name</th>
                                    <th>IFSC Code</th>
                                    <th>Bank Name</th>
                                    <th>Bank Account</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Mobile No</th>
                                    <th>Email</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
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

    <script>
        $(document).ready(function() {
            function fetchCategories() {
                $.ajax({
                    url: '../controller/fetch_bankcard.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var bankTable = $('#bankTable tbody');
                        bankTable.empty();
                        $.each(response, function(index, card) {
                            var row = '<tr>' +
                                '<td>' + card.id + '</td>' +
                                '<td>' + card.name + '</td>' +
                                '<td>' + card.ifsc_code + '</td>' +
                                '<td>' + card.bank_name + '</td>' +
                                '<td>' + card.bank_account + '</td>' +
                                '<td>' + card.state + '</td>' +
                                '<td>' + card.city + '</td>' +
                                '<td>' + card.address + '</td>' +
                                '<td>' + card.mobile_no + '</td>' +
                                '<td>' + card.email + '</td>' +
                                '<td>' + card.code + '</td>' +
                                '<td>' + card.status + '</td>' +
                             
                                '<td><button class="btn btn-primary btn-sm editBtn" data-id="' + card.id + '">Edit</button></td>' +
                            '</tr>';
                            bankTable.append(row);
                        });
                    },
                    error: function() {
                        console.error('An error occurred while fetching categories.');
                    }
                });
            }

            fetchCategories();

            // Edit category
            $(document).on('click', '.editBtn', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '../controller/fetch_bank_card_by_id.php',
                    type: 'GET',
                    data: { action: 'fetch', id: id },
                    dataType: 'json',
                    success: function(response) {
                        $('#editId').val(response.id);
                        $('#userId').val(response.user_id);
                        $('#editName').val(response.name);
                        $('#editIfscCode').val(response.ifsc_code);
                        $('#editBankName').val(response.bank_name);
                        $('#editBankAccount').val(response.bank_account);
                        $('#editState').val(response.state);
                        $('#editCity').val(response.city);
                        $('#editAddress').val(response.address);
                        $('#editMobileNo').val(response.mobile_no);
                        $('#editEmail').val(response.email);
                        $('#editCode').val(response.code);
                        $('#editStatus').val(response.status);

                        // Show the edit modal
                        // $('#editBankCardModal').modal('show');
                        $('#editModal').modal('show');
                    },
                    error: function() {
                        console.error('An error occurred while fetching category details.');
                    }
                });
            });

            $('#editCategoryForm').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '../controller/fetch_categories.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                            $('#editModal').modal('hide');
                            fetchCategories();
                        } else {
                            $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function() {
                        $('#message').html('<div class="alert alert-danger">An error occurred while updating the category.</div>');
                    }
                });
            });

            // Handle form submission for editing
            $('#editBankCardForm').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '../controller/update_bank.php', // PHP script to update data
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.status == 'success') {
                            fetchCategories(); // Refresh table data
                            $('#editModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an error updating the student data.'
                        });
                    }
                });
            });   
        });
    </script>
</body>
</html>