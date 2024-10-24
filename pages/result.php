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
    <title>H Dynasta - Recharge</title>
    <?php include 'include/style.php'; ?>
    <style>
       *,:after,:before{box-sizing:border-box}
      .pull-left{float:left}
      .pull-right{float:right}
      .clearfix:after,.clearfix:before{content:'';display:table}
      .clearfix:after{clear:both;display:block}

      .clock:before,
      .count:after{
        content:'';
        position:absolute;
      }
      .clock-wrap{
        margin:auto;
        width:150px;
        height:150px;
        margin-top:30px;
        position:relative;
        border-radius:50px;
        /* background-color:#fff;
        box-shadow:0 0 15px rgba(0,0,0,.15); */
      }
      .clock{
        /* top:50%; */
        left:50%;
        width:180px;
        height:180px;
        border-radius:50%;
        position:absolute;
        margin-top:-90px;
        margin-left:-90px;
        /* background-color:#feeff4; */
      }
      .clock:before{
        top:50%;
        left:50%;
        width:120px;
        height:120px;
        margin-top:-60px;
        margin-left:-60px;
        border-radius:inherit;
        background-color:#ec366b;
        box-shadow:0 0 15px rgba(0,0,0,.15), 0 0 3px rgba(255,255,255,.75) inset;
        /*border:1px solid rgba(255,255,255,.1);*/
      }
      .count{
        width:100%;
        color:#fff;
        height:100%;
        padding:50px;
        font-size:32px;
        font-weight:500;
        line-height:82px;
        position:absolute;
        text-align:center;
      }
      .count:after{
        width:100%;
        display:block;
        font-size:18px;
        font-weight:300;
        line-height:18px;
        text-align:center;
        position:relative;
      }
      .count.sec:after{content:'sec'}
      .count.min:after{content:'min'}
      .action{
        margin:auto;
        max-width:200px;
      }
      .action .input{
        margin-top:30px;
        position:relative;
      }
      .action .input-num{
        width:100%;
        border:none;
        padding:12px;
        border-radius:60px;
      }
      .action .input-btn{
        top:0;
        right:0;
        color:#fff;
        border:none;
        border:none;
        padding:12px;
        position:absolute;
        border-radius:60px;
        background-color:#ec366b;
        text-transform:uppercase;
      }
      .tbl{display:table;width:100%}
      .tbl .col{display:table-cell}

      .btn-purple {
        color:white;background-color:purple;
      }
      .text-purple {
        color:purple;
      }
    </style>
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
       
            <div class="container pt-4 px-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="rounded d-flex align-items-center justify-content-between p-4">
                            <!-- <i class="fa fa-wallet fa-3x text-primary"></i> -->
                            <div class="ms-3">
                                <p class="mb-3">Period</p>
                                <h6 class="mb-0" id="uniqueNumber"></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rounded d-flex align-items-center justify-content-between p-4">
                            <div class="clock-wrap">
                                <div class="clock pro-0">
                                    <span class="count">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row g-4">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-3">
                        <div class="rounded d-flex align-items-center justify-content-between p-4">
                            <b><span id="green-count" class="text-success"></span></b>
                        </div>
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-3">
                        <div class="rounded d-flex align-items-center justify-content-between p-4">
                            <b><span id="violet-count" class="text-purple"></span></b>
                        </div> 
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-3">
                        <div class="rounded d-flex align-items-center justify-content-between p-4">
                            <b><span id="red-count" class="text-danger"></span></b>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="container-fluid pt-4 px-4">
                <div class="container-fluid pt-4 px-4">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" >
                            <tbody id="numbers-table">
                                <tr class="text-center" id="numbers-row">
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--div class="container pt-4 px-4">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Rd 1</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Rd 2</button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Rd 4</button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Rd 5</button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Rd 6</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <table class="table table-bordered">
                                <tr>
                                    <td>1</td>
                                    <td><button class="btn btn-success btn-sm rounded-circle">3</button></td>
                                    <td><button class="btn btn-success btn-sm rounded-circle">6</button></td>
                                    <td><button class="btn btn-danger btn-sm rounded-circle">6</button></td>
                                    <td><button class="btn btn-purple btn-sm rounded-circle">3</button></td>
                                  
                                </tr>
                               
                                <tr>
                                    <td>3</td>
                                    <td><button class="btn btn-danger btn-sm rounded-circle">8</button></td>
                                    <td><button class="btn btn-purple btn-sm rounded-circle">6</button></td>
                                    <td><button class="btn btn-success btn-sm rounded-circle">3</button></td>
                                    <td><button class="btn btn-purple btn-sm rounded-circle">3</button></td>
                                    
                                </tr>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <table class="table table-bordered">
                          
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <table class="table table-bordered">
                              
                            </table>
                        </div>
                    </div>
                </div-->
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
        <!-- Content End -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php include 'include/script.php'; ?>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '../controller/fetch_counts.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#green-count').text('Green: ' + data.green_count);
                    $('#violet-count').text('Violet: ' + data.violet_count);
                    $('#red-count').text('Red: ' + data.red_count);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching counts:', textStatus, errorThrown);
                }
            });
        });

        $(document).ready(function() {
            $.ajax({
                url: '../controller/fetch_number.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var numbersRow = $('#numbers-row');
                    numbersRow.empty(); // Clear the row before appending new data
                    $.each(data.numbers, function(index, number) {
                        var cell = $('<td></td>');
                        var button = $('<button class="btn btn-primary btn-sm rounded-circle"></button>').text(number);
                        cell.append(button);
                        numbersRow.append(cell);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching numbers:', textStatus, errorThrown);
                }
            });
        });

        function fetchUniqueNumber() {
            fetch('../controller/unique_counter.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('uniqueNumber').innerText = data.uniqueNumber;
                })
                .catch(error => console.error('Error fetching unique number:', error));
        }

        // Run the function once the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', fetchUniqueNumber);

    </script>

    <script>
        // Function to start countdown timer
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            var countdownInterval = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(countdownInterval);
                    location.reload(); // Refresh the page after countdown finishes
                } else if (timer <= 15) {
                    // Disable buttons when timer is less than or equal to 15 seconds
                    disableButtons();
                }
            }, 1000);
        }

        // Function to disable buttons
        function disableButtons() {
            var buttons = document.querySelectorAll('.btn');
            buttons.forEach(function(button) {
                button.disabled = true;
            });
        }

        // Function to enable buttons
        function enableButtons() {
            var buttons = document.querySelectorAll('.btn');
            buttons.forEach(function(button) {
                button.disabled = false;
            });
        }

        // Initialize countdown timer
        window.onload = function () {
            var countdownTime = 60; // Countdown time in seconds
            var display = document.querySelector('.count');
            startTimer(countdownTime, display);

            // Enable buttons after countdown time (61 seconds for slight delay)
            setTimeout(enableButtons, (countdownTime + 1) * 1000);
        };
    </script>

</body>
</html>