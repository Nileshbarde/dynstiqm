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
    <title>H Dynasta - Promotions</title>
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
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-wallet fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Commission</p>
                                <h6 class="mb-0" id="totalCommission">₹0</h6>
                            </div>
                        </div>
                    </div> 
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-university fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Interest</p>
                                <h6 class="mb-0" id="totalInterest">₹0</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <!-- <div class="row">
                    <div class="col-sm-12 col-xl-4">
                        <a href="promotions_view.php" class="btn btn-info text-white mb-3">View Promotions
                        </a>
                    </div>
                </div> -->
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light categoriesed h-100 p-4">
                        <form id="promotionsForm">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="promotion_code" name="promotion_code" placeholder="Promotions Code">
                                <label for="Promotions">Promotions Code</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="promotion_link" name="promotion_link" placeholder="Promotions Link" readonly>
                                <label for="Promotions">Promotions Link</label>
                            </div>
                            <button type="button" class="btn btn-primary mb-3" id="copyLinkBtn">Copy Link</button>
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
         <!-- promotion modal -->
         <div class="modal fade" id="onload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5>Notice</h5>
                        <p>When your friends trade, you will also receive a 25% commission and add 500 on first transcation wallet. Therefore, the more friends you invite, the higher your commission. When they make money, they will invite their friends to join them, and then you can get a 9% commission on add wallet. In this way, your team can spread quickly. Therefore, I hope everyone can use our platform to make money, make money, and make money!When they make money.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- promotion modal -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php include 'include/script.php'; ?>

    <!--script>
        $(document).ready(function() {
            $('#promotionsForm').on('submit', function(event) {
                event.preventDefault();
                
                var formData = new FormData(this);
                
                $.ajax({
                    url: '../controller/add_promotions.php',
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
    </script-->
    <script>
        $(document).ready(function() {
            // Function to generate the promotion link
            function generatePromotionLink(code) {
                return `https://dynstiqm.top/signup.php?r_code=${code}`;
            }

            // Fetch the promotion code from the server
            $.ajax({
                url: '../controller/fetch_promotion_code.php', // Adjust the URL to your server endpoint
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const promotionCode = response.invite_code;
                        $('#promotion_code').val(promotionCode);
                        const promotionLink = generatePromotionLink(promotionCode);
                        $('#promotion_link').val(promotionLink);
                    } else {
                        $('#message').html('<div class="alert alert-danger" role="alert">Failed to fetch promotion code.</div>');
                    }
                },
                error: function() {
                    $('#message').html('<div class="alert alert-danger" role="alert">An error occurred while fetching promotion code.</div>');
                }
            });

            // Copy the promotion link to the clipboard
            $('#copyLinkBtn').click(function() {
                const linkInput = document.getElementById('promotion_link');
                linkInput.select();
                document.execCommand('copy');
                $('#message').html('<div class="alert alert-success" role="alert">Link copied to clipboard!</div>');
            });
        });
    </script>

    <script type="text/javascript">
        $(window).on('load', function() {
            $('#onload').modal('show');
        });
    </script>
     <script>
    $(document).ready(function() {
        $.ajax({
            url: '../controller/fetch_commission.php',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#totalCommission').text('₹' + response.totalCommission);
                } else {
                    console.log('Failed to fetch commission');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching commission:', error);
            }
        });
    });
    </script>

</body>
</html>