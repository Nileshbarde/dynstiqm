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
    <title>H Dynasta - View Subcategories</title>
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
                        <a href="subcategories.php" class="btn btn-success text-white mb-3">
                            Add Subcategory
                        </a>
                    </div>
                </div>
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Subcategory</h6>
                        <a href="">Show All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0" id="subcategoriesTable">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <th scope="col">Subcategory</th>
                                    <th scope="col">Category</th>
                                    
                                    <th scope="col">Image</th>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Subcategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSubcategoryForm" enctype="multipart/form-data">
                        <input type="hidden" id="editSubcategoryId" name="id">
                        <input type="hidden" name="action" value="update_subcategory">
                        <div class="mb-3">
                            <label for="editSubcategoryName" class="form-label">Subcategory Name</label>
                            <input type="text" class="form-control" id="editSubcategoryName" name="sub_name">
                        </div>
                        <div class="mb-3">
                            <label for="editCategorySelect" class="form-label">Category</label>
                            <select class="form-select" id="editCategorySelect" name="cat_id">
                                <!-- Options will be dynamically populated -->
                            </select>
                        </div>
                     
                        <div class="mb-3">
                            <label for="editSubcategoryImage" class="form-label">Subcategory Image</label>
                            <input type="file" class="form-control" id="editSubcategoryImage" name="img">
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
            function fetchCategories() {
                $.ajax({
                    url: '../controller/fetch_subcategories.php',
                    type: 'GET',
                    data: { action: 'fetch_categories' },
                    dataType: 'json',
                    success: function(response) {
                        var categorySelect = $('#editCategorySelect');
                        categorySelect.empty();
                        $.each(response, function(index, category) {
                            categorySelect.append('<option value="' + category.id + '">' + category.name + '</option>');
                        });
                    }
                });
            }

            function fetchSubcategories() {
                $.ajax({
                    url: '../controller/fetch_subcategories.php',
                    type: 'GET',
                    data: { action: 'fetch_all_subcategories' },
                    dataType: 'json',
                    success: function(response) {
                        var subcategoriesTable = $('#subcategoriesTable tbody');
                        subcategoriesTable.empty();
                        $.each(response, function(index, subcategory) {
                            var row = '<tr>' +
                                '<td>' + subcategory.id + '</td>' +
                                '<td>' + subcategory.sub_name + '</td>' +
                                '<td>' + subcategory.name + '</td>' +
                                '<td><img src="../controller/' + subcategory.image + '" alt="' + subcategory.sub_name + '" width="50"></td>' +
                                '<td>' +
                                    '<button class="btn btn-warning editBtn" data-id="' + subcategory.id + '">Edit</button>' +
                                    ' <button class="btn btn-danger deleteBtn" data-id="' + subcategory.id + '">Delete</button>' +
                                '</td>' +
                            '</tr>';
                            subcategoriesTable.append(row);
                        });
                    }
                });
            }

            // Fetch categories and subcategories on page load
            fetchCategories();
            fetchSubcategories();

            // Handle edit button click
            $(document).on('click', '.editBtn', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '../controller/fetch_subcategories.php',
                    type: 'GET',
                    data: { action: 'fetch_subcategory', id: id },
                    dataType: 'json',
                    success: function(response) {
                        $('#editSubcategoryId').val(response.id);
                        $('#editSubcategoryName').val(response.sub_name);
                        $('#editCategorySelect').val(response.cat_id);

                        $('#editModal').modal('show');
                    }
                });
            });

            // Handle edit form submission
            $('#editSubcategoryForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '../controller/fetch_subcategories.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                            $('#editModal').modal('hide');
                            fetchSubcategories();
                        } else {
                            $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function() {
                        $('#message').html('<div class="alert alert-danger">An error occurred while updating the subcategory.</div>');
                    }
                });
            });

            // Handle delete button click
            $(document).on('click', '.deleteBtn', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this subcategory?')) {
                    $.ajax({
                        url: '../controller/fetch_subcategories.php',
                        type: 'POST',
                        data: { action: 'delete_subcategory', id: id },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                                fetchSubcategories();
                            } else {
                                $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                            }
                        },
                        error: function() {
                            $('#message').html('<div class="alert alert-danger">An error occurred while deleting the subcategory.</div>');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>