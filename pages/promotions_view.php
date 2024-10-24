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
    <title>H Dynasta - View Promotions</title>
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
                        <a href="promotions.php" class="btn btn-primary text-white mb-3">
                            Promotions
                        </a>
                    </div>
                </div>
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Promotions</h6>
                        <a href="">Show All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0" id="promotionTable">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <th scope="col">Promotion Code</th>
                                    <th scope="col">Promotion Amount</th>
                                    <th scope="col">Notice</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div id="message"></div>
                    </div>
                </div>
            </div>
            <!-- Form End -->

            <!-- Modal for Editing -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Promotions</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editPromotionsForm" enctype="multipart/form-data">
                                <input type="hidden" id="editPromotionId" name="id">
                                <input type="hidden" name="action" value="update">
                               
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="editPromotionCode" name="promotion_code" placeholder="Promotions Code">
                                    <label for="Promotions">Promotions Code</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="editPromotionAmt" name="promotion_amt" placeholder="Promotions Amount">
                                    <label for="Promotions">Promotions Amount</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" id="editNotice" name="notice" placeholder="Promotions Notice"></textarea>
                                    <label for="Promotions">Promotions Notice</label>
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

        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top">
            <i class="bi bi-arrow-up"></i>
        </a>
    </div>

    <!-- JavaScript Libraries -->
    <?php include 'include/script.php'; ?>

    <script>
        $(document).ready(function() {
            function fetchPromotion() {
                $.ajax({
                    url: '../controller/fetch_promotion.php',
                    type: 'GET',
                    data: { action: 'fetch_all' },
                    dataType: 'json',
                    success: function(response) {
                        var promotionTable = $('#promotionTable tbody');
                        promotionTable.empty();
                        $.each(response, function(index, promotion) {
                            var row = '<tr>';
                            row += '<td>' + promotion.id + '</td>';
                            row += '<td>' + promotion.promotion_code + '</td>';
                            row += '<td>' + promotion.promotion_amt + '</td>';
                            row += '<td>' + promotion.notice + '</td>';
                            row += '<td>';
                            row += '<button class="btn btn-primary btn-sm editBtn" data-id="' + promotion.id + '">Edit</button> ';
                            row += '<button class="btn btn-danger btn-sm deleteBtn" data-id="' + promotion.id + '">Delete</button>';
                            row += '</td>';
                            row += '</tr>';
                            promotionTable.append(row);
                        });
                    },
                    error: function() {
                        console.error('An error occurred while fetching categories.');
                    }
                });
            }

            fetchPromotion();

            // Edit promotions
            $(document).on('click', '.editBtn', function() {
                var id = $(this).data('id');
                // Fetch promotions details and show in the modal
                $.ajax({
                    url: '../controller/fetch_promotion.php',
                    type: 'GET',
                    data: { action: 'fetch', id: id },
                    dataType: 'json',
                    success: function(response) {
                        $('#editPromotionId').val(response.id);
                        $('#editPromotionCode').val(response.promotion_code);
                        $('#editPromotionAmt').val(response.promotion_amt);
                        $('#editNotice').val(response.notice);
                        // Show the modal
                        $('#editModal').modal('show');
                    },
                    error: function() {
                        console.error('An error occurred while fetching promotions details.');
                    }
                });
            });

            $('#editPromotionsForm').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: '../controller/fetch_promotion.php',
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
                        $('#message').html('<div class="alert alert-danger">An error occurred while updating the promotions.</div>');
                    }
                });
            });

            // Delete promotions
            $(document).on('click', '.deleteBtn', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this promotions?')) {
                    $.ajax({
                        url: '../controller/fetch_promotion.php',
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
                            $('#message').html('<div class="alert alert-danger">An error occurred while deleting the promotions.</div>');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>