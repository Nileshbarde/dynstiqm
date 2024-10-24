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
    <title>H Dynasta - View Rounds</title>
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
                        <a href="users.php" class="btn btn-success text-white mb-3">
                            Add Users
                        </a>
                    </div>
                </div>
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Users</h6>
                        <a href="">Show All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0" id="usersTable">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Form End -->

            <!-- Modal for Editing -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Users</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editUsersForm" enctype="multipart/form-data">
                                <input type="hidden" id="editUsersId" name="id">
                                <input type="hidden" name="action" value="update">
                                <div class="form-floating mb-3">
                                    <input type="number" name="mobile_number" class="form-control" id="editUsersMobileNumber" placeholder="+1 1274561234">
                                    <label for="floatingInput">Mobile</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="editUsersPassword" name="password" placeholder="Enter Password">
                                    <label for="category">Password</label>
                                </div>
                                <div class="mb-3">
                                    <label for="editUsersImage" class="form-label">Users Image</label>
                                    <input type="file" class="form-control" id="editUsersImage" name="img">
                                </div>
                               
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


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
            function fetchUsers() {
                $.ajax({
                    url: '../controller/fetch_users.php',
                    type: 'GET',
                    data: { action: 'fetch_all' },
                    dataType: 'json',
                    success: function(response) {
                        var usersTable = $('#usersTable tbody');
                        usersTable.empty();
                        $.each(response, function(index, user) {
                            var row = '<tr>';
                            row += '<td>' + user.id + '</td>';
                            row += '<td>' + user.mobile_number + '</td>';
                            row += '<td>' + user.password + '</td>';
                            row += '<td><img src="../controller/' + user.image + '" alt="' + user.name + '" width="50"></td>';
                            row += '<td>';
                            row += '<button class="btn btn-primary btn-sm editBtn" data-id="' + user.id + '">Edit</button> ';
                            row += '<button class="btn btn-danger btn-sm deleteBtn" data-id="' + user.id + '">Delete</button>';
                            row += '</td>';
                            row += '</tr>';
                            usersTable.append(row);
                        });
                    },
                    error: function() {
                        console.error('An error occurred while fetching users.');
                    }
                });
            }

            fetchUsers();

            // Edit Users
            $(document).on('click', '.editBtn', function() {
                var id = $(this).data('id');
                // Fetch Users details and show in the modal
                $.ajax({
                    url: '../controller/fetch_users.php',
                    type: 'GET',
                    data: { action: 'fetch', id: id },
                    dataType: 'json',
                    success: function(response) {
                        $('#editUsersId').val(response.id);
                        $('#editUsersName').val(response.name);
                        $('#editUsersMobileNumber').val(response.mobile_number);
                        $('#editUsersPassword').val(response.password);
                        // Show the modal
                        $('#editModal').modal('show');
                    },
                    error: function() {
                        console.error('An error occurred while fetching Users details.');
                    }
                });
            });

            $('#editUsersForm').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: '../controller/fetch_users.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                            $('#editModal').modal('hide');
                            fetchusers();
                        } else {
                            $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function() {
                        $('#message').html('<div class="alert alert-danger">An error occurred while updating the Users.</div>');
                    }
                });
            });

            // Delete Users
            $(document).on('click', '.deleteBtn', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this Users?')) {
                    $.ajax({
                        url: '../controller/fetch_users.php',
                        type: 'POST',
                        data: { action: 'delete', id: id },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                                fetchusers();
                            } else {
                                $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                            }
                        },
                        error: function() {
                            $('#message').html('<div class="alert alert-danger">An error occurred while deleting the Users.</div>');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>