<?php
session_start();
if (!isset($_SESSION['mobile_number'])) {
    header("Location: index.php");
    exit();
}
?>
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.php" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">
                <i class="fa fa-money me-2"></i>DYNASTY
            </h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">Test Account</h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <?php 
                if(isset($_SESSION['role_id']) == 1){
            ?>
            <a href="index.php" class="nav-item nav-link active">
                <i class="fa fa-tachometer-alt me-2"></i>Home
            </a>
            <a href="pages/categories.php" class="nav-item nav-link">
                <i class="fa fa-keyboard me-2"></i> Category
            </a>
            <a href="pages/subcategories.php" class="nav-item nav-link">
                <i class="fa fa-table me-2"></i> Subcategory
            </a>
            <a href="pages/users.php" class="nav-item nav-link">
                <i class="fa fa-th me-2"></i> Users
            </a>
            <a href="pages/rounds.php" class="nav-item nav-link">
                <i class="fa fa-chart-bar me-2"></i> Rounds
            </a>
            <?php
                } else if(isset($_SESSION['role_id']) == 2) {
            ?>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="far fa-file-alt me-2"></i>Wallet
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="pages/recharge.php" class="dropdown-item">Recharge</a>
                    <a href="pages/withdraw.php" class="dropdown-item">Withdraw</a>
                    <a href="pages/withdraw_request.php" class="dropdown-item">Withdrawl Request</a>
                   <!-- <a href="blank.php" class="dropdown-item">Blank Page</a> -->
                </div>
            </div>
            <a href="pages/bank_account.php" class="nav-item nav-link">
                <i class="fa fa-chart-bar me-2"></i> Bank Accounts
            </a>
            <a href="pages/promotions.php" class="nav-item nav-link">
                <i class="fa fa-chart-bar me-2"></i> Promotion
            </a>
            <a href="pages/win.php" class="nav-item nav-link">
                <i class="fa fa-chart-bar me-2"></i> Win
            </a>
            <!-- <a href="form.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a> -->
            <!-- <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Elements</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="button.php" class="dropdown-item">Buttons</a>
                    <a href="typography.php" class="dropdown-item">Typography</a>
                    <a href="element.php" class="dropdown-item">Other Elements</a>
                </div>
            </div> -->
            <!-- <a href="widget.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>
            <a href="form.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a>
            <a href="table.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
            <a href="chart.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a> -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="far fa-file-alt me-2"></i> My Account
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="pages/profile.php" class="dropdown-item">Profile</a>
                    <a href="controller/logout.php" class="dropdown-item">Sign Out</a>
                    <a href="pages/privacy_policy.php" class="dropdown-item">Privacy Policy</a>
                    <a href="pages/risk_disclosure_agreemen.php" class="dropdown-item">Risk Disclosure Agreement</a>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </nav>
</div>