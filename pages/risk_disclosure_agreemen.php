
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
                           <h6>Risk Disclosure Agreement</h4>
                        <!-- </a> -->
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12">
                        <div class="contents">
                            <h4>Chapter 1.Booking/Collection Description</h4>

                            <p>Prepayment Booking/Recycling Customer should read and understand the business content carefully before making prepayment bookings (prepayment lock price, payment settlement and shipment) /recovery or repurchase (prepayment lock price, shipping payment) before making prepayment bookings to Terion Shop:</p>

                            <p>1. Before making an appointment/restoring the prepayment business, the customer should complete the real name authentication in the mall and ensure that the name, ID number, bank account number, delivery address and other information filled in are true, accurate and valid; Otherwise, the user will be liable for the consequences of false information.</p>

                            <p>2. Customers can order gold and silver products in advance at the shopping centre. Orders can be cancelled by 01:30 a.m. on the same Saturday. When the customer pays the end payment, the mall receives the final payment and arranges the delivery.</p>

                            <p>If the customer does not pay the final pick-up by 01:30 a.m. on Saturday, the customer is deemed to have made the last offer before the inventory and the booking is cancelled.</p>

                            <p>3. Customers can make an appointment to recycle gold and silver products purchased at the gold point. Pre-purchase recovery requires a credit margin and confirmation of actual possession of gold and silver products purchased from the mall. Customers can cancel their reservation at any time before 01:30 on Saturday and the credit mark will be refunded after deducting the increase or decrease in the value of the goods within the corresponding time.</p>

                            <p>If the customer fails to deliver the goods to a shopping mall or shopping center at the designated collection point by Saturday within the same week, or if the goods delivered do not meet the recycling standard test, the customer will be deemed to have cancelled the reservation recovery and will bear the logistics and testing costs.</p>

                            <p>4. Counting time: Daily 01:30-05:30 for the mall warehouse inventory time. During the inventory period, the mall stops accepting advance payments for reservations/receipts.</p>

                            <p>5. For further details, please refer to the Business Guidelines in the front page of the mall, Understanding Terion Shop.</p>


                            <h4>Chapter 2 Reveals the business model of Terion Shop</h4>

                            <p>Booking/repurchase orders, the business model for clearing balance shipments, uncertainties such as potential benefits and potential risks to the value of its merchandise due to real-time fluctuations in the gold and silver market, and the extent to which booking/repo risk stake is understood for customer booking/repo risk, Risk control ability and understanding of related products have high requirements. Customer selects pre-payment booking/repurchase, fully informed on behalf of the customer and understand the risks of prepayments/repurchase business and agree to and accept Terion Shop current and future relevant booking/repurchase business processes and management systems (collectively, the Process Systems) to develop, modify and publish. This Risk Disclosure (Disclosure) is intended to fully disclose to the Client the risk of the prepayment booking/repurchase business and is intended only to provide reference for the client to assess and determine its own risk tolerance. The risk disclosures described in this disclosure are for example only. All risk factors associated with Terion Shop Advance Booking/Repurchase are not detailed. Customers should also carefully understand and understand other possible risk factors before starting or participating in Terion Shop pre-payment booking/repurchase business. If the customer is not aware of or is not aware of this disclosure, they should consult Terion Shop Customer Service or the relevant regional service provider in a timely manner. If the Customer ultimately clicks on Risk Disclosure, it is deemed that the Customer fully agrees and accepts the full contents of this disclosure.</p>

                            <h4>Warm tips</h4>

                            <p>1.Minors under the age of 18 are not permitted to participate in The Terion Shop Advance Booking/Recycling.

                            <p>2.Terion Shop Advance Booking/Repo is only available to customers who meet all of the following criteria:</p>

                            <p>① Natural persons with full civil capacity, legal persons of enterprises or other economic organizations registered in accordance with the law.</p>

                            <p>② To fully understand all risks associated with Terion Shop Advance Booking/Repurchase business and have a certain risk tolerance.</p>

                            <p>③ Have a certain understanding of gold and silver and its products:</p>

                            <p>A. Policy-related risk disclosure, such as changes in national laws, regulations and policies, contingency measures, implementation of appropriate regulatory measures, Terion Shop regulatory system and changes in management methods and regulations, etc., all risks that may affect customer bookings/repurchases, etc., the customer must bear the losses incurred.</p>

                            <p>B. Price fluctuations, gold, silver and other precious metals and their accessories are affected by a variety of factors, such as the international economic situation, foreign exchange, related market trends, supply and demand, and political situation and energy prices. The pricing mechanism for gold, silver and other precious metals products is very complex, making it difficult for customers to fully grasp in practice, so decisions such as advance booking/buyback are possible Mistakes, if the risk cannot be effectively controlled, may suffer losses and the customer must bear all the losses incurred as a result.</p>

                            <p>④ Terion Shop has enabled the provision of services through electronic communication technology and Internet technology. Communication services and hardware and software services are provided by different vendors and may be at risk in terms of quality and stability. Interruptions or delays due to communication or network failures may affect customer prepayment bookings/repurchases. In addition, the customers computer system may be attacked by viruses and/or cyber-hackers, resulting in the customers advance payment booking/repurchase not being properly and/or timely.</p>

                            <p>There is also a risk that the above uncertainties may affect the customer’s advance payment booking/repurchase.</p>

                            <p>A. The price quoted by the Terion Shop Prepayment Booking/Repo System is based on the systems real-time trading price and may differ slightly from the commodity prices in other markets.</p>

                            <p>Terion Shop cannot guarantee that the above prepayment booking//repurchase price is fully consistent with other markets.</p>

                            <p>B. At Terion Shop;, once the customers pre-payment booking/repurchase application submitted through the online terminal is completed, it cannot be withdrawn and the customer must accept the risks associated with such a subscription.</p>

                            <p>C. Terion Shop prohibits regional service providers and their staff from providing any profit guarantee to customers, from engaging in prepaid bookings/repurchases on behalf of customers, or from sharing profits or risks with customers. Customer should be aware that any profit guarantee or commitment that Terion Shop advance booking/repurchase does not have a loss, profit share or risk-sharing is impossible, unfounded, and incorrect.</p>

                            <p>D. The customers pre-paid booking / repurchase application must be based on the customers own decision. Terion Shop and regional service providers and employees do not provide booking / buyback to the client, nor does it constitute any commitment if the client makes a booking / buyback decision accordingly.</p>

                            <p>E. In advance booking / buyback process, there may be occasional apparent errors in the offer.</p>

                            <h4>⑤ RISK-AGREEMENT</h4>

                            <p>Typhoons, floods, fires, wars, disturbances, rule revisions, changes or adjustments in government regulatory policies and regulatory requirements, and electricity, To ensure that you fully understand the relevant provisions and risks of booking / repurchase business, customers should be based on their own booking experience, booking / repurchase / purchase of commodities, read all the contents of the advance booking / repurchase notice carefully, and fully understand and agree to all the contents, I am willing to take all risks to start or participate in Terion Shop. In case of above mentioned condition I shall be him-self liable to any financial as well as monitory loss. By accepting this I shall be no more eligible to claims any statutory legal benefits given to Indian citizen by Law of India.</p>

                            <p>Note: I have carefully read all contents of this app including Privacy Statement, Risk Disclosure Agreement and Risk Agreement and I am agreed to continue with my own risk.</p>

                            <h4>Cancellation and refundable Policy</h4>

                            <p>In case of any discrepancy we can cancel any of the orders placed by you. A few reasons for cancellation from our end usually include limitation of the product in the inventory, error in pricing, error in product information etc. We also have the right to check out for extra information for the purpose of accepting orders in a few cases. We make sure to notify you if in case your order is cancelled partially or completely or if in case any extra data is required for the purpose of accepting your order.</p>

                            <p>Once you place the order, such order can be cancelled from your end before the shipping is undertaken to the destination. Once the request of cancellation for ready for shipping product is received by us, we make sure to refund the amount through the same mode of payment within 5 working days. Cancellation of the order of Gold coin(exchanged by integrals) shall not be accepted as under Company’s policies.</p>

                            <p>We don’t accept Cancellation requests for Smart Buy orders or customized jewellery orders. In specific situations when the customer wants the money back or wants to exchange it with other products, making charges of the product and stone charges, if there is any stone on the product shall be deducted from the payment and balance will be refunded back to customer account within 5 working days.</p>

                            <p>If in case the amount is deducted from your account and the transaction has failed, the same will be refunded back to your account within 72 hours.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Start -->
            <?php include 'include/footer.php'; ?>
            <!-- Footer End -->
        </div>

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php include 'include/script.php'; ?>
</body>
</html>