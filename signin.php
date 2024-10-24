<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>DYNASTY -Sign In</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        Spinner End -->

        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-6">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <!-- <div class="text-center mb-3">
                            <a href="index.php" class="">
                                <h3 class="text-primary ">
                                    <i class="fa fa-money me-2"></i>DYNASTY
                                </h3>
                            </a>
                        </div> -->
                        <h3 class="text-center mb-3">Sign In</h3>
                        <form id="loginForm" method="post">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="name@example.com">
                                <label for="floatingInput">Mobile Number</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Login Password</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <a href="signup.php" id="forgotPassword">Register</a>
                                <a href="forget_password.php" id="forgotPassword">Forgot Password</a>
                            </div>
                            <div class="alert alert-danger" id="error-message" style="display: none;"></div>
                            <button type="button" id="signInButton" class="btn btn-primary w-100">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    
    
   <script>
        document.getElementById("signInButton").addEventListener("click", function() {
            var formData = new FormData(document.getElementById("loginForm"));
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Handle successful login
                        var response = JSON.parse(xhr.responseText);
                        if(response.success) {
                            window.location.href = "index.php";
                        } else {
                            document.getElementById("error-message").innerText = response.message;
                            document.getElementById("error-message").style.display = "block";
                        }
                    } else {
                        // Handle login failure
                        document.getElementById("error-message").innerText = "An error occurred during the login process.";
                        document.getElementById("error-message").style.display = "block";
                    }
                }
            };
            xhr.open("POST", "controller/login.php", true);
            xhr.send(formData);
        });
    </script>
</body>
</html>