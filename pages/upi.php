<!-- ?php
$amount = isset($_GET['amount']) ? $_GET['amount'] : 0;
? -->
<?php
    if (isset($_GET['pay'])) {
        // Base64 decode the amount
        $encodedAmount = $_GET['pay'];
        $amount = base64_decode($encodedAmount);
    } else {
        $amount = 'Unknown';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPI Payment</title>
    <style>
        :root {
            --color-background: #fae3ea;
            --color-primary: #fc8080;
            --font-family-base: Poppin, sans-serif;
            --font-size-h1: 1.25rem;
            --font-size-h2: 1rem;
            }


        * {
            box-sizing: inherit;
        }

        html {
            box-sizing: border-box;
        }

        body {
            background-color: var(--color-background);
            display: grid;
            font-family: var(--font-family-base);
            line-height: 1.5;
            margin: 0;
            min-block-size: 100vh;
            padding: 5vmin;
            place-items: center;
        }

        address {
            font-style: normal;
        }

        button {
            border: 0;
            color: inherit;
            cursor: pointer;
            font: inherit;
        }

        fieldset {
            border: 0;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: var(--font-size-h1);
            line-height: 1.2;
            margin-block: 0 1.5em;
        }

        h2 {
            font-size: var(--font-size-h2);
            line-height: 1.2;
            margin-block: 0 0.5em;
        }

        legend {
            font-weight: 600;
            margin-block-end: 0.5em;
            padding: 0;
        }

        /* input {
            border: 0;
            color: inherit;
            font: inherit;
        } */

        input[type="radio"] {
            accent-color: var(--color-primary);
        }

        table {
            border-collapse: collapse;
            inline-size: 100%;
        }

        tbody {
            color: #b4b4b4;
        }

        td {
            padding-block: 0.125em;
        }

        tfoot {
            border-top: 1px solid #b4b4b4;
            font-weight: 600;
        }

        .align {
            display: grid;
            place-items: center;
        }

        .button {
            align-items: center;
            background-color: var(--color-primary);
            border-radius: 999em;
            color: #fff;
            display: flex;
            gap: 0.5em;
            justify-content: center;
            padding-block: 0.75em;
            padding-inline: 1em;
            transition: 0.3s;
        }

        .button:focus,
        .button:hover {
            background-color: #e96363;
        }
        .form-control {
            margin-bottom: 10px;
            padding-bottom: 10px;
            position: relative;
            width: 100%;
        }
        .button--full {
            inline-size: 100%;
        }

        .card {
            border-radius: 1em;
            /* background-color: var(--color-primary); */
            color: #fff;
            padding: 1em;
        }

        .form {
        display: grid;
        gap: 2em;
        }

        .form__radios {
        display: grid;
        gap: 1em;
        }

        .form__radio {
        align-items: center;
        background-color: #fefdfe;
        border-radius: 1em;
        box-shadow: 0 0 1em rgba(0, 0, 0, 0.0625);
        display: flex;
        padding: 1em;
        }

        .form__radio label {
        align-items: center;
        display: flex;
        flex: 1;
        gap: 1em;
        }
        .form-control label {
        color: #777;
        display: block;
        margin-bottom: 5px;
        }

        .form-control input {
        border: solid 2px #f0f0f0;
        border-radius: 4px;
        display: block;
        width: 100%;
        padding: 10px;
        font-size: 14px;
        outline: none;
        }

        .form-control input:focus {
        outline: 0;
        border-color: #777;
        }

        .header {
        display: flex;
        justify-content: center;
        padding-block: 0.5em;
        padding-inline: 1em;
        }

        .icon {
        block-size: 1em;
        display: inline-block;
        fill: currentColor;
        inline-size: 1em;
        vertical-align: middle;
        }
  
        .modal-dialog.custom-modal-width {
            max-width: 80%;
        }
        .iphone {
            background-color: #fbf6f7;
            background-image: linear-gradient(to bottom, #fbf6f7, #fff);
            border-radius: 1em;
            width: 100%;
            box-shadow: 0 0 1em rgba(0, 0, 0, 0.0625);
            overflow: auto;
            padding: 2em;
            margin-bottom: 15px;
        }
        .iphone .float-left {
            float: left;
        }
        .iphone .float-right {
            float: right;
            color: skyblue;
        }

        .amount-center {
            text-align: center;
            font-size: 24px; /* Adjust the size as needed */
            font-weight: bold;
            color: #333; /* You can change this to any color you prefer */
            padding: 10px;
            margin: 8px auto; /* Centers the div horizontally with auto margins */
            background-color: #f5f5f5; /* Optional: Add a background color */
            border-radius: 5px; /* Optional: Add rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow */
        }

    </style>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <!-- <h1>Scan and Pay</h1>
    <p>Please scan the QR code and pay ₹<?php echo htmlspecialchars($amount); ?>.</p>
    <img src="path/to/your/qr_code_image.jpg" alt="UPI QR Code">
    <form id="utrForm" action="validate_utr.php" method="post">
        <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">
        <div class="form-floating mt-3 mb-3">
            <input type="text" class="form-control" id="utrInput" name="utr" placeholder="UTR ID">
            <label for="utrInput">Enter UTR ID</label>
        </div>
        <button type="submit" class="btn btn-primary py-2 w-100 mb-3 mt-4">Submit UTR ID</button>
    </form> -->

    <div class="iphone">
        <div class="float-left">
            <h3>₹ <?php echo htmlspecialchars($amount); ?>.00 </h3>
        </div>
        <div class="float-right">
            <h5>SECURE PAYMENT BY UPI QR & ID</h5>
        </div>
    </div>
    <div class="iphone amount-center">
        <div class="" style="margin-top: 25px;">
            <img src="../img/qrcode.jpeg" width="150px;" />
        </div>
        <div>
            <h4>If Use PhonePe Scan QR code to Pay , You must copy the 12-digit UTR , Then Paste and Submit
            </h4>
            <h5>UPI ID: <span style="color: skyblue;font-size:25px">ddsupermarket897-1@okhdfcbank</span> <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#instructionModal">COPY</a></h5>
            <!-- Modal -->
            <div class="modal fade" id="instructionModal" tabindex="-1" aria-labelledby="instructionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered custom-modal-width">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="instructionModalLabel">How To Find UTR?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="screenshot-container">
                                    <img src="../img/upi.png" class="img-fluid" alt="UPI 1">
                                </div>
                                <p>If copy UPI to Pay, you must copy 12-digit UTR, then paste and submit.</p>
                                <p>If you don't know how to copy UTR, please click view video and learn.</p>
                                <h5>UPI Copy Succeeded</h5>
                                <p>Paste and Submit UTR.</p>
                                <div class="screenshot-container">
                                    <img src="../img/utr.png" class="img-fluid" alt="UTR" style="width: 150px;">
                                    <img src="../img/utr.png" class="img-fluid" alt="UTR" style="width: 150px;">
                                    <img src="../img/utr.png" class="img-fluid" alt="UTR" style="width: 150px;">
                                    <!-- <img src="screenshot2.png" class="img-fluid mt-2" alt="Screenshot 2"> -->
                                </div>
                                <!-- <div class="mt-3">
                                    <a href="view_video.html" class="btn btn-info">View Video</a>
                                </div> -->
                                <form id="utrForm" action="validate_utr.php" method="post">
                                    <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">
                                    <div class=" mt-3 mb-3">
                                        <label>Enter UTR ID</label>
                                        <input type="text" class="form-control" id="utrInput" name="utr">
                                    </div>
                                    <br>
                                    <div class="">
                                        <button type="submit" class="button button--full py-2 w-100 mb-3 ">Submit UTR ID</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
    <div class="iphone">
        <fieldset class="mt-5">
            <legend>Payment Method</legend>
            <div class="form__radios">
                <div class="form__radio">
                    <label for="google-pay" data-toggle="modal" data-target="#googlePayModal">
                        <img src="../img/gpay.png" style="width:30px;"> Google Pay
                    </label>
                </div>

               <div class="form__radio">
                    <label for="phone-pe" data-toggle="modal" data-target="#phonePeModal">
                        <img src="../img/ppicon.png" style="width:30px;"> Phone Pe
                    </label>
                </div>

                <div class="form__radio">
                    <label for="mastercard">
                        <img src="../img/paytm.png" style="width:30px;"> Paytm
                    </label>
                </div>
            </div>
        </fieldset>
        <!-- Modal for Google Pay -->
        <div class="modal fade" id="googlePayModal" tabindex="-1" aria-labelledby="googlePayModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered custom-modal-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="googlePayModalLabel">How To Find UTR for Google Pay?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="screenshot-container">
                            <img src="../img/upi.png" class="img-fluid" alt="Google Pay UPI">
                        </div>
                        <!-- Content for Google Pay UTR Instructions -->
                        <p>If you copy UPI to Pay, you must copy 12-digit UTR, then paste and submit.</p>
                        <h5>UPI ID: <span style="color: skyblue;font-size:25px">aradhyatoursand@axl</span></h5>
                        <!-- Repeat similar content as in your existing modal -->
                        
                        
                        <p>If you don't know how to copy UTR, please click view video and learn.</p>
                        <h5>UPI Copy Succeeded</h5>
                        <p>Paste and Submit UTR.</p>
                        <div class="screenshot-container">
                            <img src="../img/utr.png" class="img-fluid" alt="UTR" style="width: 150px;">
                            <!-- Add more images if needed -->
                        </div>
                        <form id="googlePayUTRForm" method="post">
                            <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">
                            <div class="mt-3 mb-3">
                                <label>Enter UTR ID</label>
                                <input type="text" class="form-control" id="googlePayUtrInput" name="utr">
                            </div>
                            <div>
                                <button type="submit" class="button button--full py-2 w-100 mb-3">Submit UTR ID</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal for PhonePe -->
        <div class="modal fade" id="phonePeModal" tabindex="-1" aria-labelledby="phonePeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered custom-modal-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="phonePeModalLabel">How To Find UTR for PhonePe?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <!-- Content for PhonePe UTR Instructions -->
                        <!-- Repeat similar content as in your existing modal -->
                        <div class="screenshot-container">
                            <img src="../img/phonepays.jpeg" class="img-fluid" alt="PhonePe UPI" style="width: 180px;">
                        </div>
                        <p>If Use PhonePe Scan QR code to Pay , You must copy the 12-digit UTR , Then Paste and Submit.</p>
                        <p>If you don't know how to copy UTR, please click view video and learn.</p>
                        <h5>UPI Copy Succeeded</h5>
                        <p>Paste and Submit UTR.</p>
                        <div class="screenshot-container">
                            <img src="../img/utr.png" class="img-fluid" alt="UTR" style="width: 150px;">
                            <!-- Add more images if needed -->
                        </div>
                        <form id="phonePeUTRForm" method="post">
                            <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">
                            <div class="mt-3 mb-3">
                                <label>Enter UTR ID</label>
                                <input type="text" class="form-control" id="phonePeUtrInput" name="utr">
                            </div>
                            <div>
                                <button type="submit" class="button button--full py-2 w-100 mb-3">Submit UTR ID</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <br>
        <div class="">
            <form id="utrForms" action="validate_utr.php" method="post">
                <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">
                <div class=" mt-3 mb-3">
                    <label>Enter UTR ID</label>
                    <input type="text" class="form-control" id="utrInput" name="utr">
                </div>
                <br>
                <div class="">
                    <button type="submit" class="button button--full py-2 w-100 mb-3 ">Submit UTR ID</button>
                </div>
            </form>
        </div>
    <div>
   <div>
        <h4>Dear Member , 100% Secure Payment Powered</h4>
   </div>
</div>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none">
  <!-- Google Pay Icon -->
  <symbol id="icon-google-pay" viewBox="0 0 640 512">
    <!-- <path d="M20 7h-4v-3c0-2.209-1.791-4-4-4s-4 1.791-4 4v3h-4l-2 17h20l-2-17zm-11-3c0-1.654 1.346-3 3-3s3 1.346 3 3v3h-6v-3zm-4.751 18l1.529-13h2.222v1.5c0 .276.224.5.5.5s.5-.224.5-.5v-1.5h6v1.5c0 .276.224.5.5.5s.5-.224.5-.5v-1.5h2.222l1.529 13h-15.502z" /> -->

    <path d="M105.7 215v41.3h57.1a49.7 49.7 0 0 1 -21.1 32.6c-9.5 6.6-21.7 10.3-36 10.3-27.6 0-50.9-18.9-59.3-44.2a65.6 65.6 0 0 1 0-41l0 0c8.4-25.5 31.7-44.4 59.3-44.4a56.4 56.4 0 0 1 40.5 16.1L176.5 155a101.2 101.2 0 0 0 -70.8-27.8 105.6 105.6 0 0 0 -94.4 59.1 107.6 107.6 0 0 0 0 96.2v.2a105.4 105.4 0 0 0 94.4 59c28.5 0 52.6-9.5 70-25.9 20-18.6 31.4-46.2 31.4-78.9A133.8 133.8 0 0 0 205.4 215zm389.4-4c-10.1-9.4-23.9-14.1-41.4-14.1-22.5 0-39.3 8.3-50.5 24.9l20.9 13.3q11.5-17 31.3-17a34.1 34.1 0 0 1 22.8 8.8A28.1 28.1 0 0 1 487.8 248v5.5c-9.1-5.1-20.6-7.8-34.6-7.8-16.4 0-29.7 3.9-39.5 11.8s-14.8 18.3-14.8 31.6a39.7 39.7 0 0 0 13.9 31.3c9.3 8.3 21 12.5 34.8 12.5 16.3 0 29.2-7.3 39-21.9h1v17.7h22.6V250C510.3 233.5 505.3 220.3 495.1 211zM475.9 300.3a37.3 37.3 0 0 1 -26.6 11.2A28.6 28.6 0 0 1 431 305.2a19.4 19.4 0 0 1 -7.8-15.6c0-7 3.2-12.8 9.5-17.4s14.5-7 24.1-7C470 265 480.3 268 487.6 273.9 487.6 284.1 483.7 292.9 475.9 300.3zm-93.7-142A55.7 55.7 0 0 0 341.7 142H279.1V328.7H302.7V253.1h39c16 0 29.5-5.4 40.5-15.9 .9-.9 1.8-1.8 2.7-2.7A54.5 54.5 0 0 0 382.3 158.3zm-16.6 62.2a30.7 30.7 0 0 1 -23.3 9.7H302.7V165h39.6a32 32 0 0 1 22.6 9.2A33.2 33.2 0 0 1 365.7 220.5zM614.3 201 577.8 292.7h-.5L539.9 201H514.2L566 320.6l-29.4 64.3H561L640 201z"/>
  </symbol>

  <!-- PhonePe Icon -->
  <symbol id="icon-phonepe" viewBox="0 0 24 24">
    <path d="M12 0C5.373 0 0 5.373 0 12c0 6.627 5.373 12 12 12 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12zm0 22C6.486 22 2 17.514 2 12S6.486 2 12 2s10 4.486 10 10-4.486 10-10 10zm.5-17h-1C7.215 5 4 8.215 4 12.5c0 4.284 3.215 7.5 7.5 7.5s7.5-3.216 7.5-7.5C19 8.215 15.785 5 12.5 5zm0 13c-3.037 0-5.5-2.462-5.5-5.5S9.463 7 12.5 7s5.5 2.462 5.5 5.5-2.463 5.5-5.5 5.5zm.5-7.5h-1V11h1v.5zm2.5 0h-1v-1.5h-2v3h3v2h-3v1h-2v-4c0-.276.224-.5.5-.5h3v-3h2v4z"/>

  </symbol>

  <!-- Paytm Icon -->
  <symbol id="icon-paytm" viewBox="0 0 24 24">
    <path d="M12 0c-6.627 0-12 5.373-12 12 0 6.627 5.373 12 12 12 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12zm0 22c-5.514 0-10-4.486-10-10 0-5.514 4.486-10 10-10 5.514 0 10 4.486 10 10 0 5.514-4.486 10-10 10zm-.5-14h-2v2h2v-2zm1 0h2v6h-2v-6zm4 0h-2v4h2v-4zm-8 0H7v4h2v-4z"/>
  </symbol>
</svg>


    <script>
        document.getElementById('utrForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('../controller/validate_utr.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.href = 'win.php'; // Redirect to wallet page or any other page
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>

    <script>
        document.getElementById('utrForms').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('../controller/validate_utr.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.href = 'win.php'; // Redirect to wallet page or any other page
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
