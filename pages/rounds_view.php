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
                        <a href="rounds.php" class="btn btn-success text-white mb-3">
                            Add Rounds
                        </a>
                    </div>
                </div>
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Rounds</h6>
                        <a href="">Show All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0" id="roundsTable">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <th scope="col">Rounds</th>
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
                            <h5 class="modal-title" id="editModalLabel">Edit Round</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editRoundForm" enctype="multipart/form-data">
                                <input type="hidden" id="editRoundId" name="id">
                                <input type="hidden" name="action" value="update">
                                <div class="mb-3">
                                    <label for="editRoundName" class="form-label">Round Name</label>
                                    <input type="text" class="form-control" id="editRoundName" name="name">
                                </div>
                               <button type="submit" class="btn btn-primary">Update</button>
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
            function fetchRounds() {
                $.ajax({
                    url: '../controller/fetch_rounds.php',
                    type: 'GET',
                    data: { action: 'fetch_all' },
                    dataType: 'json',
                    success: function(response) {
                        var roundsTable = $('#roundsTable tbody');
                        roundsTable.empty();
                        $.each(response, function(index, rounds) {
                            var row = '<tr>';
                            row += '<td>' + rounds.id + '</td>';
                            row += '<td>' + rounds.name + '</td>';
                            row += '<td>';
                            row += '<button class="btn btn-primary btn-sm editBtn" data-id="' + rounds.id + '">Edit</button> ';
                            row += '<button class="btn btn-danger btn-sm deleteBtn" data-id="' + rounds.id + '">Delete</button>';
                            row += '</td>';
                            row += '</tr>';
                            roundsTable.append(row);
                        });
                    },
                    error: function() {
                        console.error('An error occurred while fetching categories.');
                    }
                });
            }

            fetchRounds();

            // Edit Round
            $(document).on('click', '.editBtn', function() {
                var id = $(this).data('id');
                // Fetch Round details and show in the modal
                $.ajax({
                    url: '../controller/fetch_rounds.php',
                    type: 'GET',
                    data: { action: 'fetch', id: id },
                    dataType: 'json',
                    success: function(response) {
                        $('#editRoundId').val(response.id);
                        $('#editRoundName').val(response.name);
                        // Show the modal
                        $('#editModal').modal('show');
                    },
                    error: function() {
                        console.error('An error occurred while fetching Round details.');
                    }
                });
            });

            $('#editRoundForm').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: '../controller/fetch_rounds.php',
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
                        $('#message').html('<div class="alert alert-danger">An error occurred while updating the Round.</div>');
                    }
                });
            });

            // Delete Round
            $(document).on('click', '.deleteBtn', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this Round?')) {
                    $.ajax({
                        url: '../controller/fetch_rounds.php',
                        type: 'POST',
                        data: { action: 'delete', id: id },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                                fetchCategories();
                            } else {
                                $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                            }
                        },
                        error: function() {
                            $('#message').html('<div class="alert alert-danger">An error occurred while deleting the Round.</div>');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>