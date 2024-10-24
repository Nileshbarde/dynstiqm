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
    <title>H Dynasta</title>
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

            <div class="container-fluid pt-4 px-4"> 
                <div class="row">
                    <div class="col-sm-12 col-xl-4">
                        <!-- <a href="levels_view.php" class="btn btn-info text-white mb-3"> -->
                           <h6>Presale Rule</h4>
                        <!-- </a> -->
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12">
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
        </div>   
                            

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
</body>

</html>