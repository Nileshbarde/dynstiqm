<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>G Dynasty - Sign Up</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
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


        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-6">
                    <div class="bg-light rounded p-4 my-4 mx-3">
                        <div class="text-center mb-3">
                            <a href="index.php" class="">
                                <h3 class="text-primary ">
                                    <i class="fa fa-money me-2"></i>DYNASTY
                                </h3>
                            </a>
                        </div>
                        <h3 class="text-center mb-3">Sign Up</h3>
                        <form id="signupForm">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="jhondoe" required>
                                <label for="floatingText">Mobile Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="loginPassword" name="loginPassword" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="inviteCode" name="inviteCode" placeholder="Invite Code" >
                                <label for="floatingPassword">Invite Code</label>
                            </div>
                            <div class="text-center">
                                <a href="#" data-toggle="modal" data-target="#myModal">Privacy Policy</a>
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                            <p class="text-center mb-0">Already have an Account? <a href="signin.php">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


     <!-- Privacy Policy Modal -->
     <div class="modal" id="myModal" tabindex="-1" aria-labelledby="privacyPolicyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyPolicyModalLabel">Privacy Policy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h2>Privacy Policy</h2>
                    <p>Your privacy policy content goes here...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/main.js"></script>


    <script>
         // Extract referral code from URL
         const urlParams = new URLSearchParams(window.location.search);
        const referralCode = urlParams.get('r_code');

        // Populate the invite code field if referral code exists
        if (referralCode) {
            document.getElementById('inviteCode').value = referralCode;
        }

        function generateUniqueCode() {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            const digits = '0123456789';
            let code = '';
            for (let i = 0; i < 5; i++) {
                code += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            for (let i = 0; i < 3; i++) {
                code += digits.charAt(Math.floor(Math.random() * digits.length));
            }
            return code;
        }

        $(document).ready(function() {
            $('#signupForm').on('submit', function(e) {
                e.preventDefault();
                
                const mobileNumber = $('#mobile_number').val();
                const password = $('#loginPassword').val();
                const inviteCode = $('#inviteCode').val() || generateUniqueCode();
                
                $.ajax({
                    url: 'controller/signup_process.php',
                    type: 'POST',
                    data: {
                        mobile_number: mobileNumber,
                        password: password,
                        inviteCode: inviteCode
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Sign Up Successful!');
                            window.location.href = 'signin.php';
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while processing your request.');
                    }
                });
            });
        });
    </script>
</body>
</html>