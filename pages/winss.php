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
    hr {
        border: none;            /* Removes the default border */
        height: 3px;             /* Specifies the height (thickness) of the line */
        background-color: #007bff; /* Sets the background color */
        margin: 20px 0;          /* Adds top and bottom margin */
        width: 100%;             /* Sets the width of the line */
        margin-left: auto;       /* Centers the line horizontally */
        margin-right: auto;      /* Centers the line horizontally */
    }
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
      .modal-body {
        text-align: left;
      }
      .custom-modal-dialog {
            /* max-width: 750px; */
            margin: auto;
        }

        .custom-modal {
            max-height: 80vh;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .custom-modal-dialog {
                max-width: 90%;
                margin: auto;
            }
        }
        .table>:not(caption)>*>* {
    padding: .5rem 0.3rem;
        }


    @media (max-width: 576px) {
        .custom-modal {
            width: 90%;
            height: auto;
        }
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
      #big-dot {
        display: inline-block;
        width: 20px; /* Adjust size as needed */
        height: 20px; /* Adjust size as needed */
        border-radius: 50%;
        vertical-align: middle; /* Aligns the dot with the text */
        margin-right: 5px; /* Space between the dot and the text */
        
      }
      .green {
        background-color: green;
      }
      .violet {
        background-color: violet;
      }
      .red {
        background-color: red;
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

      .button-container {
            display: flex;
            flex-wrap: wrap;
        }
        .button-item {
            flex: 1 1 20%; /* Five items per row */
            max-width: 20%;
            box-sizing: border-box;
            padding: 5px;
        }
        @media (max-width: 768px) {
            .button-item {
                flex: 1 1 33.33%; /* Three items per row for small devices */
                max-width: 33.33%;
            }
        }
        @media (max-width: 576px) {
            .button-item {
                flex: 1 1 20%; /* Two items per row for extra small devices */
                max-width: 20%;
            }
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
            <?php include 'include/navbar.php'; ?>
            <!-- Navbar End -->
            
            <!-- Form Start -->
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-6">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-wallet fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Available balance:</p>
                                <h6 class="mb-0" id="todayWallet">₹0</h6>
                            </div>
                        </div>
                        <div class="container">
                            <form id="walletForm">
                                <div class="form-floating mt-3 mb-3">
                                    <input type="text" class="form-control" id="amountInput" name="amount" placeholder="Amount">
                                    <label for="amountInput">Amount</label>
                                </div>
                                <button type="submit" class="btn btn-primary py-2 w-100 mb-3 mt-4">Add Wallet</button>
                                <a href="result.php" class="btn btn-primary py-2 w-100 mb-3 mt-4">Trend</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
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
                                    <span class="count" id="timer">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="container-fluid">
                <div class="row g-4" id="categoryButtons"></div>
                <div class="row g-4" id="subcategoryButtons"></div>
                <hr>
                <div class="text-center ">
                    <div class=" mb-4">
                    <h6 class="mb-0 text-center">Parity Record</h6>
                </div>
                <hr>
                <div class="container pt-2">
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0" id="winnersTable" style="padding: 0rem;">
                            <thead>
                                <tr class="text-dark">
                                    <th>Period</th>
                                    <th>Price</th>
                                    <th>Number</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody lass="table-body">
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <h6 class="mb-0 text-center">My Order</h6>
                </div>
                <hr>
                <div class="container mt-3">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <div class="table-responsive">
                        <!-- <table class="table accordion text-start align-middle table-bordered table-hover mb-0" id="myResultWallet">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <th>Period</th>
                                    <th>Price</th>
                                    <th>Number</th>
                                    <th>Color</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table> -->
                        <table class="table accordion" id="myResultWallet">
                            <thead>
                                <tr style="text-align:left">
                                    <th>Period</th>
                                    
                                    <!-- <th scope="col">Result</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Model -->
                <div class="modal fade" id="amountModal" tabindex="-1" aria-labelledby="amountModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="amountModalLabel"> <span id="modalColorName"></span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary amount-btn" data-amount="10">10</button>
                                    <button type="button" class="btn btn-primary amount-btn" data-amount="100">100</button>
                                    <button type="button" class="btn btn-primary amount-btn" data-amount="1000">1000</button>
                                    <button type="button" class="btn btn-primary amount-btn" data-amount="10000">10000</button>
                                </div>
                                <div class="input-group mt-4">
                                    <span class="input-group-text">Amount:</span>
                                    <input type="text" class="form-control" id="selectedAmount" readonly required>
                                </div>
                                <div class="btn-group mt-4">
                                    <button type="button" class="btn btn-primary" id="decrement">-</button>
                                    <button type="button" class="btn btn-primary" id="increment">+</button>
                                </div>
                               
                                <div class="form-group mt-3">
                                    <!-- <input type="checkbox" checked> <a href="">Presale Rule</a> -->
                                    <input type="checkbox" checked>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#presaleModal">
                                            Presale Rule
                                        </a>
                                </div>


                                <input type="hidden" id="cat_id">
                                <input type="hidden" id="subcat_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="confirmButton">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end model -->

                <!-- Model -->
                <div class="modal fade" id="amountSubModal" tabindex="-1" aria-labelledby="amountSubModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="amountSubModalLabel"> <span id="modalSubColorName"></span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h6>Contract Numbers</h6>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary amount-btn1" data-amount="10">10</button>
                                    <button type="button" class="btn btn-primary amount-btn1" data-amount="100">100</button>
                                    <button type="button" class="btn btn-primary amount-btn1" data-amount="1000">1000</button>
                                    <button type="button" class="btn btn-primary amount-btn1" data-amount="10000">10000</button>
                                </div>
                                <div class="input-group mt-4">
                                    <span class="input-group-text">Amount:</span>
                                    <input type="text" class="form-control" id="selectedAmount1" readonly required>
                                </div>
                                <div class="btn-group mt-4">
                                    <button type="button" class="btn btn-primary" id="decrement1">-</button>
                                    <button type="button" class="btn btn-primary" id="increment1">+</button>
                                </div>
                               
                                <div class="form-group mt-3">
                                    <!-- <input type="checkbox" checked> <a href="">Presale Rule</a> -->
                                    <input type="checkbox" checked>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#presaleModal">
                                            Presale Rule
                                        </a>
                                </div>

                                <input type="hidden" id="cat_id">
                                <input type="hidden" id="subcat_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="confirmButton1">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end model -->

                <!-- pre sale modal -->
                <div class="modal fade" id="presaleModal" tabindex="-1" aria-labelledby="presaleModalLabel" aria-hidden="true" >
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content custom-modal">
                            <div class="modal-header">
                                <h5 class="modal-title" id="presaleModalLabel">Presale Rule</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <div class="col-sm-12 col-xl-12" style="text-align: left;">
                                    <p>In order to protect the legitimate rights and interests of users participating in the presale and maintain the normal operation order of the presale, the rules are formulated in accordance with relevant agreements and rules of national laws and regulations.</p>
                                    <h6>Chapter 1 Definition</h6>
                                    <p>1.1   Presale definition: refers to a sales model in which a merchant provides a product or service plan, gathers consumer orders through presale product tools, and provides goods and / or services to consumers according to prior agreement.</p>
                                    <p>1.2   The presale model is a "deposit" model. "Deposit" refers to a fixed amount of presale commodity price pre-delivered. “The deposit” can participate in small games and have the opportunity to win more deposits. The deposit can be directly exchanged for commodities. The deposit is not redeemable.</p>
                                    <p>1.3   Presale products: refers to the products released by merchants using presale product tools. Only the presale words are marked on the product title or product details page, and the products that do not use the presale product tools are not presale products.</p>
                                    <p>1.4   Presale system: Refers to the system product tools provided to support merchants for presale model sales.</p>
                                    <p>1.5   Presale commodity price: refers to the selling price of presale commodity. The price of presale goods is composed of two parts: deposit and final payment.</p>
                                    <p>1.6   Presale deposit: Refers to a certain amount of money that consumers pay in advance when purchasing presale goods, which is mainly used as a guarantee to purchase presale goods and determine the purchase quota.</p>
                                    <p>1.7   Presale final payment: refers to the amount of money that the consumer still has to pay after the presale commodity price minus the deposit.</p>


                                    <h6>Chapter 2 Presale management specifications</h6>

                                    <h6>2.1 Commodity management</h6>

                                    <p>2.1.1 Presale deposit time: up to 7 days can be set.</p>

                                    <p>2.1.2 Presale final payment time: The start time of the final payment is within 7 days.</p>

                                    <p>2.1.3 During the presale of commodities, the system does not support merchants to modify the price of pre-sold commodities (including deposits and balances), but the amount of remaining commodity inventory can be modified according to the actual situation of inventory.</p>

                                    <p>2.1.4 To avoid unnecessary disputes, If the presale product is a customized product, the merchant should clearly inform the consumer on the product page of the production cycle and delivery time of the product, and contact the consumer to confirm the delivery standard, delivery time, etc.</p>

                                    <p>2.1.5 For customized products, the merchant has not agreed with the consumer on the delivery time and delivery standard, the delivery standard proposed by the consumer is unclear or conflicts and after the merchant places an order, he(she) starts production and delivery without confirming with the consumer, if the consumer initiates a dispute as a result, the platform will treat it as a normal delivery time limit order fulfillment.</p>

                                    <h6>2.2 Transaction management</h6>

                                    <p>2.2.1 Consumers who use the pre-sale system will lock in the pre-sale quota after placing an order for goods. If the pre-sale order is overtime, the system will automatically cancel it.</p>

                                    <p>2.2.2 During the presale period, the merchant shall not cancel the presale activities without reason. For presale activities that have generated orders, the merchant must not cancel the order without the consumer ’s consent. If the consumer agrees, the merchant should double return the deposit paid by the consumer; if the consumer does not agree to cancel the order, the merchant should perform the contract according to the order.</p>

                                    <p>2.2.3 If the final payment of the presale order is not completed due to consumer reasons, the merchant can deduct the deposit paid by the consumer; if the merchant actively negotiates with the consumer to terminate the order before paying the final payment, the merchant shall double Return the deposit paid by the consumer.</p>

                                    <h6>2.3 Delivery Management</h4>

                                    <h6>2.3.1 Delivery time limit setting</h4>

                                    <p>If the merchant sets the delivery time limit through the presale system, it should be shipped within the set time limit.</p>

                                    <h6>2.3.2 Shipping way</h6>

                                    <p>The third-party delivery the orders.</p>

                                    <p>Customers need to provide your name, address and phone number to facilitate third-party delivery orders.</p>

                                    <h6>2.4 After-sales management</h6>

                                    <p>Presale products shall provide after-sales service in accordance with the "Regulations for After-sales Service of Platform Merchants".</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- pre sale -->
            </div>
            <?php include 'include/footer.php'; ?>
        </div>
        <!-- Content End -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php include 'include/script.php'; ?>


        <!-- Timer  -->
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
                    localStorage.removeItem('startTime');
                    localStorage.removeItem('uniqueNumber'); // Clear unique number on countdown end
                    location.reload(); // Refresh the page after countdown finishes
                } else if (timer <= 15) {
                    // Disable buttons when timer is less than or equal to 15 seconds
                    disableButtons();
                    // Fetch results and display
                    fetchResults();
                }

                // Store the remaining time in localStorage
                localStorage.setItem('remainingTime', timer);
            }, 1000);
        }

        // Initialize countdown timer
        window.onload = function () {
            var countdownTime = 60; // Countdown time in seconds
            var display = document.querySelector('.count');
            var startTime = localStorage.getItem('startTime');
            var currentTime = Math.floor(Date.now() / 1000);
            var elapsedTime = startTime ? currentTime - parseInt(startTime) : 0;

            if (elapsedTime >= countdownTime) {
                // Timer has expired
                display.textContent = "00:00";
                disableButtons();
                localStorage.removeItem('startTime');
            } else {
                // Calculate remaining time
                var remainingTime = countdownTime - elapsedTime;
                startTimer(remainingTime, display);

                // Store the start time if not already stored
                if (!startTime) {
                    localStorage.setItem('startTime', currentTime);
                }
            }

            // Enable buttons after countdown time (61 seconds for slight delay)
            setTimeout(enableButtons, (countdownTime + 1) * 1000);

            // Fetch the unique number if not already stored
            if (!localStorage.getItem('uniqueNumber')) {
                fetchUniqueNumber();
            } else {
                document.getElementById('uniqueNumber').innerText = localStorage.getItem('uniqueNumber');
            }
        };

        function fetchUniqueNumber() {
            fetch('../controller/unique_counter.php')
                .then(response => response.json())
                .then(data => {
                    if (data.uniqueNumber) {
                        localStorage.setItem('uniqueNumber', data.uniqueNumber);
                        document.getElementById('uniqueNumber').innerText = data.uniqueNumber;
                    }
                })
                .catch(error => console.error('Error fetching unique number:', error));
        }

        // Function to disable buttons
        function disableButtons() {
            var buttons = document.querySelectorAll('.btn');
            buttons.forEach(function(button) {
                button.disabled = true;
                button.style.backgroundColor = 'gray';
            });
        }

        // Function to enable buttons
        function enableButtons() {
            var buttons = document.querySelectorAll('.btn');
            buttons.forEach(function(button) {
                button.disabled = false;
            });
        }
    </script>
    <!-- Timer end -->

    <!-- fetch Joins -->
    <script>
        function declareResults() {
            $.ajax({
                url: '../controller/fetch_joins.php',
                type: 'POST',
                success: function(response) {
                    console.log('Response from server:', response); // Debugging line
                    response = JSON.parse(response);
                    if (response.success) {
                        var allWinners = response.allWinners;

                        // Display all winners' data
                        allWinners.forEach(function(winner) {
                            var winnerRow = `
                                <tr>
                                    <td>${winner.period}</td>
                                    <td>${winner.price}</td>
                                    <td style="color:${winner.color};">${winner.number}</td>
                                    <td><div id="big-dot" style="width: 15px; height: 15px; border-radius: 50%; background-color: ${winner.color};">
                                    </div></td>
                                </tr>
                            `;
                            $('#winnersTable tbody').append(winnerRow);
                        });
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Debugging line
                    console.error('Status:', status); // Debugging line
                    console.error('XHR:', xhr); // Debugging line
                    alert('An error occurred while fetching the results.');
                }
            });
        }

        // Call the function immediately to declare results
        declareResults();
    </script>
    
    <!-- fetch joins by id  -->
    <script>
    function fetchUserRecords() {
        $.ajax({
            url: '../controller/fetch_joins_byid.php', // Updated endpoint to fetch user records
            type: 'POST',
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    var userRecords = response.userRecords;
                    userRecords.forEach(function(record) {
                        // Define the content that will be displayed after the delay
                        function delayedContent() {
                            var recordRow = `
                                <tr data-bs-toggle="collapse" data-bs-target="#r${record.id}" style="text-align:left">
                                    <td>
                                        ${record.period} 
                                        <span style="color:${record.status === 'success' ? 'green' : 'red'};text-transform:capitalize;margin-left: 20px;">
                                            ${record.status}
                                        </span>
                                        <span style="margin-left: 20px;color:${record.status === 'success' ? 'green' : 'red'}">
                                            ${record.status === 'success' ? '+ ₹ ' + record.price : '- ₹ ' + record.price}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="collapse accordion-collapse" id="r${record.id}" data-bs-parent="#myResultWallet" style="text-align:left">
                                    <td >
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-4"><strong>Period:</strong></div>
                                                <div class="col-md-8">${record.period}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4"><strong>Contract Money:</strong></div>
                                                <div class="col-md-8">${record.contract_money}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4"><strong>Contract Count:</strong></div>
                                                <div class="col-md-8">${record.contract_count}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4"><strong>Delivery:</strong></div>
                                                <div class="col-md-8">${record.delivery}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4"><strong>Fee:</strong></div>
                                                <div class="col-md-8">${record.fee}</div>
                                            </div>
                                        
                                            <div class="row">
                                                <div class="col-md-4"><strong>Result:</strong></div>
                                                <div class="col-md-8" style="color:${record.color}">${record.results}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4"><strong>Select:</strong></div>
                                                <div class="col-md-8" style="color:${record.color}">${record.select}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4"><strong>Status:</strong></div>
                                                <div class="col-md-8"  style="color:${record.status === 'success' ? 'green' : 'red'}">${record.status}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4"><strong>Amount:</strong></div>
                                                <div class="col-md-8" style="color:${record.status === 'success' ? 'green' : 'red'}">
                                                 ${record.status === 'success' ? '+ ₹ ' + record.price : '- ₹ ' + record.price}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4"><strong>Created Time:</strong></div>
                                                <div class="col-md-8">${record.created_at}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4"><strong>Type:</strong></div>
                                                <div class="col-md-8">Parity</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                `;
                            $('#myResultWallet tbody').append(recordRow);
                        }

                        // Append the row immediately
                        $('#myResultWallet tbody').append(`
                            <tr data-bs-toggle="collapse" data-bs-target="#r${record.id}" style="text-align:left">
                                <td>
                                    ${record.period} 
                                    <span style="color:${record.status === 'success' ? 'green' : 'red'};text-transform:capitalize;margin-left: 20px;">
                                        ${record.status}
                                    </span>
                                    <span style="margin-left: 20px;color:${record.status === 'success' ? 'green' : 'red'}">
                                        ${record.status === 'success' ? '+ ₹ ' + record.price : '- ₹ ' + record.price}
                                    </span>
                                </td>
                            </tr>
                            <tr class="collapse accordion-collapse" id="r${record.id}" data-bs-parent="#myResultWallet" style="text-align:left">
                                <td ></td>
                            </tr>
                        `);

                        // Delay appending the detailed content
                        setTimeout(delayedContent, 15000); // 15000 milliseconds = 15 seconds
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Debugging line
                console.error('Status:', status); // Debugging line
                console.error('XHR:', xhr); // Debugging line
                alert('An error occurred while fetching the results.');
            }
        });
    }

    // Call the function to fetch user records
    fetchUserRecords();
</script>



    <script>
        document.getElementById('walletForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const amount = document.getElementById('amountInput').value;
            if (amount) {
                // Redirect to UPI payment page with amount
                window.location.href = `upi.php?amount=${amount}`;
            } else {
                alert("Please enter an amount.");
            }
        });
    </script>
  
    <!-- Fetchwalletbyid -->
    <script>
        $(document).ready(function() {
            function fetchWalletData() {
                $.ajax({
                    url: '../controller/fetchwalletbyid.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#todayWallet').text('₹' + response.today_wallet);
                    },
                    error: function() {
                        $('#todayWallet').text('₹0');
                        console.error('An error occurred while fetching wallet data.');
                    }
                });
            }

            // Fetch wallet data on page load
            fetchWalletData();
        });
    </script>

    <!-- Fetch Wallet By Id -->
    <script>
        $(document).ready(function() {
            function fetchWalletDetails() {
                $.ajax({
                    url: '../controller/fetch_walletByid.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var walletTable = $('#walletTable tbody');
                        walletTable.empty();
                        $.each(response, function(index, wallet) {
                            var row = '<tr>' +
                                '<td>' + wallet.id + '</td>' +
                                '<td>' + wallet.user_id + '</td>' +
                                '<td>' + wallet.utr_id + '</td>' +
                                '<td>' + wallet.amount + '</td>' +
                                '<td>' + wallet.transction_id + '</td>' +
                                '<td>' + wallet.transc_date + '</td>' +
                                '<td>' + wallet.payment_by + '</td>' +
                                '<td>' + wallet.status + '</td>' +
                            '</tr>';
                            walletTable.append(row);
                        });
                    },
                    error: function() {
                        $('#message').html('<div class="alert alert-danger">An error occurred while fetching wallet details.</div>');
                    }
                });
            }

            // Fetch wallet details on page load
            fetchWalletDetails();
        });
    </script>

    <!-- Increase Amount Button -->
    <script>
        // Set amount on button click
        $('.amount-btn').click(function() {
            selectedAmount = parseInt($(this).data('amount'));
            $('#selectedAmount').val(selectedAmount);
        });

        // Increment amount
        $('#increment').click(function() {
            if (selectedAmount > 0) {
                selectedAmount += selectedAmount;
                $('#selectedAmount').val(selectedAmount);
            }
        });

        // Decrement amount
        $('#decrement').click(function() {
            if (selectedAmount > 0) {
                selectedAmount -= selectedAmount / 2;
                $('#selectedAmount').val(selectedAmount);
            }
        });


         //  amount-btn1
         $('.amount-btn1').click(function() {
            selectedAmount = parseInt($(this).data('amount'));
            $('#selectedAmount1').val(selectedAmount);
        });

        // Increment amount1
        $('#increment1').click(function() {
            if (selectedAmount > 0) {
                selectedAmount += selectedAmount;
                $('#selectedAmount1').val(selectedAmount);
            }
        });

        // Decrement amount
        $('#decrement1').click(function() {
            if (selectedAmount > 0) {
                selectedAmount -= selectedAmount / 2;
                $('#selectedAmount1').val(selectedAmount);
            }
        });

        // Set modal color and title
        $('#amountModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var color = button.data('color');
            var modal = $(this);

            modal.find('#modalColorName').text('Join ' + color);
        });

        // Confirm button click
        $('#confirmButton').click(function() {
            const period = $('#uniqueNumber').text();
            const cat_id = $('#cat_id').val();
            const contractMoney = selectedAmount;
            const total = contractMoney;    

            // First, check the user's wallet balance
            $.ajax({
                url: '../controller/check_wallet_balance.php',
                type: 'POST',
                data: {
                    user_id: $('#user_id').val(), // Assuming you have the user ID in a hidden input field
                },
                success: function(response) {
                    if (response.success) {
                        const walletBalance = response.balance;
                        
                        // Check if the wallet balance is sufficient
                        if (walletBalance >= total) {
                            // Proceed with joining the contract
                            $.ajax({
                                url: '../controller/add_to_joins.php',
                                type: 'POST',
                                data: {
                                    contract_money: contractMoney,
                                    total: total,
                                    cat_id: cat_id,
                                    period: period
                                },
                                success: function(response) {
                                    if (response.success) {
                                        // Show a success message
                                        alert('Successfully joined the contract.');
                                        // Close the modal after the alert is closed
                                        $('#amountModal').modal('hide');
                                        // Optionally update UI or take other actions
                                    } else {
                                        alert(response.message);
                                    }
                                },
                                error: function() {
                                    alert('An error occurred while processing your request.');
                                }
                            });
                        } else {
                            alert('Insufficient balance. Please recharge your wallet.');
                        }
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while checking your wallet balance.');
                }
            });
        });

        // // Set amount on button click
        // $('.amount-btn1').click(function() {
        //     selectedAmount = parseInt($(this).data('amount'));
        //     $('#selectedAmount1').val(selectedAmount);
        // });

        // Confirm button click
        $('#confirmButton1').click(function() {
            const period = $('#uniqueNumber').text();
            const subcat_id = $('#subcat_id').val();
            const contractMoney = selectedAmount;
          
            const total = contractMoney;

            $.ajax({
                url: '../controller/add_to_joins.php',
                type: 'POST',
                data: {
                    contract_money: contractMoney,
                    total: total,
                    subcat_id: subcat_id,
                    period: period
                },
                success: function(response) {
                    if (response.success) {
                        // Show a success message
                        alert('Successfully joined the contract.');
                        // Close the modal after the alert is closed
                        $('#amountSubModal').modal('hide');
                        // Optionally update UI or take other actions
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while processing your request.');
                }
            });
        });
    </script>

    <!-- subcat color -->
    <script>
        $(document).ready(function() {
            function fetchSubcategories() {
                $.ajax({
                    url: '../controller/fetch_subcat_color.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var subcategoryButtons = $('#subcategoryButtons');
                        subcategoryButtons.empty();

                        $.each(response, function(index, subcategory) {
                            // Add a new row for every set of 5 buttons
                            if (index % 5 === 0) {
                                subcategoryButtons.append('<div class="w-100"></div>');
                            }

                            var button = `
                                <div class="button-item">
                                    <button type="submit" class="btn py-2 w-100 mb-2" 
                                        style="background-color: ${subcategory.status}; color: white;"
                                        data-bs-toggle="modal" data-bs-target="#amountSubModal"
                                        onclick="setSubcategory('${subcategory.sub_name}', '${subcategory.status}', '${subcategory.id}')">
                                        ${subcategory.sub_name}
                                    </button>
                                </div>
                            `;
                            subcategoryButtons.append(button);
                        });
                    },
                    error: function() {
                        console.error('An error occurred while fetching subcategories.');
                    }
                });
            }

            fetchSubcategories();
        });

        var selectedAmount1 = 0;
        var incrementValue1 = 0;

        // Function to set selected amount and increment value
        function setSubAmount(amounts) {
            selectedAmount1 = amounts;
            incrementValue1 = amounts;
            document.getElementById('selectedAmount1').value = selectedAmount1;
        }

        // console.log(id);
        //     document.getElementById('amountModalLabel').innerText = `${name}`;
        //     $('#cat_id').val(id);
        //     $('.modal-content').css('border-color', status);

        // Function to set category and color for the modal
        function setSubcategory(sub_name, status, id) {
            console.log(id);
            document.getElementById('amountSubModalLabel').innerText = `Select ${sub_name}`;
            $('#subcat_id').val(id);
            $('.modal-content').css('border-color', status);
        }

            // Set selected amount when clicking on pre-defined amounts
        document.getElementById('amounts10').addEventListener('click', function() {
            setSubAmount(10);
        });

        document.getElementById('amounts100').addEventListener('click', function() {
            setSubAmount(100);
        });

        document.getElementById('amounts1000').addEventListener('click', function() {
            setSubAmount(1000);
        });

        document.getElementById('amounts10000').addEventListener('click', function() {
            setSubAmount(10000);
        });

        // Increment and decrement buttons
        document.getElementById('increment1').addEventListener('click', function() {
            selectedAmount1 += incrementValue1; // Increment by the selected amount
            document.getElementById('selectedAmount1').value = selectedAmount1;
        });

        document.getElementById('decrement1').addEventListener('click', function() {
            if (selectedAmount1 > 0) {
                selectedAmount1 -= incrementValue1; // Decrement by the selected amount
                if (selectedAmount1 < 0) selectedAmount1 = 0; // Ensure amount doesn't go negative
                document.getElementById('selectedAmount1').value = selectedAmount1;
            }
        });
    </script>

    <!-- cat color -->
    <script>
        $(document).ready(function() {
            function fetchCategories() {
                $.ajax({
                    url: '../controller/fetch_cat_color.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var categoryButtons = $('#categoryButtons');
                        categoryButtons.empty();

                        $.each(response, function(index, category) {
                            var button = `
                                <div class="col-sm-4 col-md-4 col-4">
                                    <button type="submit" class="btn py-2 w-100 mb-3 mt-4" 
                                        style="font-size:13px;background-color: ${category.status}; color: white;"     data-bs-toggle="modal" data-bs-target="#amountModal"
                                        onclick="setCategory('${category.name}', '${category.status}', '${category.id}')">
                                        ${category.name}
                                    </button>
                                </div>
                            `;
                            categoryButtons.append(button);
                        });
                    },
                    error: function() {
                        console.error('An error occurred while fetching categories.');
                    }
                });
            }

            fetchCategories();
        });

        // var selectedAmount = 0;
        // var incrementValue = 0;

        // // Function to set selected amount and increment value
        // function setAmount(amount) {
        //     selectedAmount = amount;
        //     incrementValue = amount;
        //     document.getElementById('selectedAmount').value = selectedAmount;
        // }

        // Function to set category and color for the modal
        function setCategory(name, status, id) {
            console.log(id);
            document.getElementById('amountModalLabel').innerText = `${name}`;
            $('#cat_id').val(id);
            $('.modal-content').css('border-color', status);
        }

        // // Set selected amount when clicking on pre-defined amounts
        // document.getElementById('amount10').addEventListener('click', function() {
        //     setAmount(10);
        // });

        // document.getElementById('amount100').addEventListener('click', function() {
        //     setAmount(100);
        // });

        // document.getElementById('amount1000').addEventListener('click', function() {
        //     setAmount(1000);
        // });

        // document.getElementById('amount10000').addEventListener('click', function() {
        //     setAmount(10000);
        // });

        // // Increment and decrement buttons
        // document.getElementById('increment').addEventListener('click', function() {
        //     selectedAmount += incrementValue; // Increment by the selected amount
        //     document.getElementById('selectedAmount').value = selectedAmount;
        // });

        // document.getElementById('decrement').addEventListener('click', function() {
        //     if (selectedAmount > 0) {
        //         selectedAmount -= incrementValue; // Decrement by the selected amount
        //         if (selectedAmount < 0) selectedAmount = 0; // Ensure amount doesn't go negative
        //         document.getElementById('selectedAmount').value = selectedAmount;
        //     }
        // });
    </script>
</body>
</html>