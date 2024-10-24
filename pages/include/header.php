
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="../index.php" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">
                <i class="fa fa-money me-2"></i>DYNASTY
            </h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="../img/user.jpg" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <!-- <h6 class="mb-0">Test Account</h6> -->
                <span><?php echo $_SESSION["mobile_number"]; ?></span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <?php 
                if(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1) {
            ?>
            <a href="../index.php" class="nav-item nav-link active">
                <i class="fa fa-tachometer-alt me-2"></i> Home
            </a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-wallet me-2"></i>Wallet
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="recharge.php" class="dropdown-item">Recharge</a>
                    <a href="withdraw.php" class="dropdown-item">Withdraw Request</a>
                    <a href="withdraw_request.php" class="dropdown-item">User Withdrawl</a>
                </div>
            </div>
            
            <a href="categories.php" class="nav-item nav-link">
                <i class="fa fa-list-alt me-2"></i> Category
            </a>
            <a href="subcategories.php" class="nav-item nav-link">
                <i class="fa fa-table me-2"></i> Subcategory
            </a>
           
            <a href="rounds.php" class="nav-item nav-link">
                <i class="fa fa-dot-circle me-2"></i>Rounds
            </a>
            <a href="users.php" class="nav-item nav-link">
                <i class="fa fa-users me-2"></i> Users
            </a>
            <a href="order_history.php" class="nav-item nav-link">
                <i class="fa fa-users me-2"></i> Order Hisotry
            </a>
            <a href="result_history.php" class="nav-item nav-link">
                <i class="fa fa-users me-2"></i> All Result History
            </a>
            <a href="complaint_suggestion.php" class="nav-item nav-link">
                <i class="fa fa-wallet me-2"></i> Complaint & Suggestion
            </a>
            <?php
                } else if(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 2) {
            ?>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-wallet me-2"></i>Wallet
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="recharge.php" class="dropdown-item">Recharge</a>
                    <a href="withdraw_request.php" class="dropdown-item">Withdrawl Request</a>
                </div>
            </div>

            <a href="bank_account.php" class="nav-item nav-link">
                <i class="fa fa-university me-2"></i> Bank Accounts
            </a>
            <a href="promotions.php" class="nav-item nav-link">
                <i class="fa fa-bullhorn me-2"></i> Promotion
            </a>
            <a href="win.php" class="nav-item nav-link">
                <i class="fa fa-chart-bar me-2"></i> Win
            </a>
           
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="far fa-file-alt me-2"></i> My Account
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="profile.php" class="dropdown-item">Profile</a>
                    <a href="../controller/logout.php" class="dropdown-item">Sign Out</a>
                    <a href="privacy_policy.php" class="dropdown-item">Privacy Policy</a>
                    <a href="risk_disclosure_agreemen.php" class="dropdown-item">Risk Disclosure Agreement</a>
                    <a href="complaint_suggestion.php" class="dropdown-item">Complaint & Suggestion</a>
                </div>
            </div>
            <a href="my_order_history.php" class="nav-item nav-link">
                <i class="fa fa-users me-2"></i> My Order Hisotry
            </a>
            <a href="my_result_history.php" class="nav-item nav-link">
                <i class="fa fa-users me-2"></i> My Result Hisotry
            </a>
            <!-- <a href="result_history.php" class="nav-item nav-link">
                <i class="fa fa-users me-2"></i> All Result History
            </a> -->
            <a href="#" class="nav-item nav-link" download="">
                <i class="fa fa-download me-2"></i> Download
            </a>
            <a href="https://t.me/joindmewindynasty" class="nav-item nav-link" download="">
                <i class="fab fa-telegram "></i> Telegram
            </a>
            <?php 
                } else {

                }
            ?>
        </div>
    </nav>
</div>