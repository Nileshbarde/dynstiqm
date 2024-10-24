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
    <style>
        .nav-pills .nav-link {
            border-radius: 0px;
        }
        .nav .nav-item button.active {
            background-color: transparent;
            border-radius: 0px;
        }
        .nav .nav-item button.active::after {
            content: "";
            width: 100%;
            position: absolute;
            left: 0;
            bottom: -1px;
            border-radius: 5px 5px 0 0;
        }
    </style>
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
                    <div class="col-sm-12 col-xl-11">
                    </div>
                    <div class="col-sm-12 col-xl-1">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#complaintModal"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="container p-5">
                <ul class="nav nav-pills mb-3 border-bottom border-2 d-flex justify-content-between" id="pills-tab" role="tablist">
                    <li class="nav-item flex-grow-1" role="presentation">
                        <button class="nav-link text-white bg-info fw-semibold active position-relative w-100" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Completed</button>
                    </li>
                    <li class="nav-item flex-grow-1" role="presentation">
                        <button class="nav-link text-white bg-info fw-semibold position-relative w-100" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Wait</button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <table class="table text-start align-middle table-bordered table-hover mb-0" id="complaintsTable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Complaint ID</th>
                                    <th scope="col">User ID</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <!-- Wait Tab -->
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <table class="table text-start align-middle table-bordered table-hover mb-0" id="waitComplaintsTable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Out ID</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Status</th>
                                    <?php 
                                        if(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1) {
                                    ?>
                                        <th scope="col">Actions</th>
                                    <?php
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Complaint Modal -->
            <div class="modal fade" id="complaintModal" tabindex="-1" aria-labelledby="complaintModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="complaintModalLabel">Add Complaint</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="complaintForm">
                                <input type="hidden" id="complaint-id" name="id">
                                <div class="mb-3">
                                    <label for="complaint-type" class="form-label">Type</label>
                                    <select class="form-select" id="complaint-type" name="type">
                                        <option value="Suggest">Suggest</option>
                                        <option value="Consult">Consult</option>
                                        <option value="Recharge Problem">Recharge Problem</option>
                                        <option value="Withdraw Problem">Withdraw Problem</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="out-id" class="form-label">Out ID</label>
                                    <input type="text" class="form-control" id="out-id" name="out_id">
                                </div>
                                <div class="mb-3">
                                    <label for="number" class="form-label">What Number</label>
                                    <input type="text" class="form-control" id="number" name="number">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comment Modal -->
            <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentModalLabel">Add Comment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="commentForm">
                                <input type="hidden" id="comment-complaint-id" name="complaint_id">
                                <div class="mb-3">
                                    <label for="comment-text" class="form-label">Comment</label>
                                    <textarea class="form-control" id="comment-text" name="comment"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="comment-text" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="Commented">Commented</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
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
        $(document).ready(function () {
            // Load complaints on page load
            loadComplaints();

            // Load comments function
            function loadComplaints() {
                $.ajax({
                    url: '../controller/fetch_complaint_comments.php',
                    type: 'GET',
                    success: function (data) {
                        $('#complaintsTable tbody').html(data);
                    }
                });
            }

            // Handle add/update complaint form submission
            $('#complaintForm').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.ajax({
                    url: '../controller/submit_complaint.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        alert(response);
                        $('#complaintModal').modal('hide');
                        loadComplaints();
                    }
                });
            });

            

            // Handle comment form submission
            $('#commentForm').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.ajax({
                    url: '../controller/complaint_comment.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#commentModal').modal('hide');
                        loadComplaints();
                    }
                });
            });

            // Open modal for updating complaint
            $(document).on('click', '.edit-complaint', function () {
                const complaintId = $(this).data('id');
                $.ajax({
                    url: '../controller/get_complaint.php',
                    type: 'GET',
                    data: { id: complaintId },
                    success: function (response) {
                        const complaint = JSON.parse(response);
                        $('#complaint-id').val(complaint.id);
                        $('#complaint-type').val(complaint.type);
                        $('#out-id').val(complaint.out_id);
                        $('#number').val(complaint.number);
                        $('#description').val(complaint.description);
                        $('#complaintModal').modal('show');
                    }
                });
            });

            // Open modal for adding comment
            $(document).on('click', '.add-comment', function () {
                const complaintId = $(this).data('id');
                $('#comment-complaint-id').val(complaintId);
                $('#commentModal').modal('show');
            });

            // Load complaints function
            function loadComplaints() {
                $.ajax({
                    url: '../controller/get_complaint.php',
                    type: 'GET',
                    success: function (response) {
                        $('#waitComplaintsTable tbody').html(response);
                    }
                });
            }
        });
    </script>

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