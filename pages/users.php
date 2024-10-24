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
    <title>H Dynasta - Users</title>
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
                        <a href="users_view.php" class="btn btn-info text-white mb-3">
                            View Users
                        </a>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <form id="usersForm" enctype="multipart/form-data">
                                <div class="form-floating mb-3">
                                    <input type="number" name="mobile_number" class="form-control" id="floatingInput" placeholder="+1 1274561234">
                                    <label for="floatingInput">Mobile</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="password" name="password" placeholder="Enter Password">
                                    <label for="category">Password</label>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" type="file" name="img" id="formFile" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-primary py-2 w-100 mb-3 mt-2">Add User</button>
                            </form>
                            <div id="message"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->


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
            $('#usersForm').on('submit', function(event) {
                event.preventDefault();
                
                var formData = new FormData(this);
                
                $.ajax({
                    url: '../controller/add_users.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                        } else {
                            $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function() {
                        $('#message').html('<div class="alert alert-danger">An error occurred while processing your request.</div>');
                    }
                });
            });
        });
    </script>

</body>

</html>