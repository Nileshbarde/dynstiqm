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
    <title>H Dynasta - Withdraw</title>
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

            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light categoriesed h-100 p-4">
                            <h5>Change Password</h5>
                            <form id="changePasswordForm">
                                <div class="form-group mt-3">
                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="confirmPassword">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light categoriesed h-100 p-4">
                            <h5 class="mb-3">Change Withdrawal Password</h5>
                            <form id="changeWithdrawPasswordForm">
                                <div class="form-group">
                                    <label for="currentWithdrawPassword">Current Withdrawal Password (leave empty if not set)</label>
                                    <input type="password" class="form-control" id="currentWithdrawPassword" name="currentWithdrawPassword">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="newWithdrawPassword">New Withdrawal Password</label>
                                    <input type="password" class="form-control" id="newWithdrawPassword" name="newWithdrawPassword" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="confirmWithdrawPassword">Confirm New Withdrawal Password</label>
                                    <input type="password" class="form-control" id="confirmWithdrawPassword" name="confirmWithdrawPassword" required>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Change Withdrawal Password</button>
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
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php include 'include/script.php'; ?>
    <script src="scripts.js"></script>
   </body>
</html>