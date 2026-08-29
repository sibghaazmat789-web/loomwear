
<?php

session_start();

include "../includes/db.php";


/* ==========================================
   CHECK LOGIN
========================================== */

if (!isset($_SESSION['customer_id'])) {

    header("Location: login.php");
    exit();

}


/* ==========================================
   CHECK ORDER ID
========================================== */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: my-orders.php");
    exit();

}


$order_id = (int) $_GET['id'];

$email = $_SESSION['customer_email'];

$email_safe = mysqli_real_escape_string(
    $conn,
    $email
);


/* ==========================================
   GET ORDER
   IMPORTANT:
   Match both ID AND customer email
========================================== */

$query = mysqli_query(
    $conn,
    "SELECT *
     FROM orders
     WHERE id = $order_id
     AND email = '$email_safe'
     LIMIT 1"
);


if (!$query || mysqli_num_rows($query) !== 1) {

    header("Location: my-orders.php");
    exit();

}


$order = mysqli_fetch_assoc($query);


/* ==========================================
   ORDER INFORMATION
========================================== */

$order_number =
    !empty($order['order_number'])
    ? $order['order_number']
    : 'LW-' . $order['id'];


$status = strtolower(
    trim($order['status'] ?? 'pending')
);


/* ==========================================
   NORMALIZE STATUS
========================================== */

$status = str_replace(
    '_',
    ' ',
    $status
);


/* ==========================================
   TRACKING STEPS
========================================== */

$steps = [

    'pending' => [
        'title' => 'Order Placed',
        'description' =>
            'Your order has been received successfully.'
    ],

    'confirmed' => [
        'title' => 'Order Confirmed',
        'description' =>
            'Your order has been confirmed by LoomWear.'
    ],

    'processing' => [
        'title' => 'Processing',
        'description' =>
            'Your order is being prepared for shipment.'
    ],

    'shipped' => [
        'title' => 'Shipped',
        'description' =>
            'Your order has been handed over to the courier.'
    ],

    'out for delivery' => [
        'title' => 'Out for Delivery',
        'description' =>
            'Your order is on the way to your delivery address.'
    ],

    'delivered' => [
        'title' => 'Delivered',
        'description' =>
            'Your order has been delivered successfully.'
    ]

];


/* ==========================================
   CURRENT STEP
========================================== */

$status_order = [

    'pending' => 1,

    'confirmed' => 2,

    'processing' => 3,

    'shipped' => 4,

    'out for delivery' => 5,

    'delivered' => 6

];


$current_step =
    $status_order[$status] ?? 1;


/* ==========================================
   CANCELLED
========================================== */

$is_cancelled =
    ($status === 'cancelled');


/* ==========================================
   DISPLAY STATUS
========================================== */

$display_status =
    ucwords($status);


/* ==========================================
   TOTAL
========================================== */

$total = 0;


if (
    isset($order['total']) &&
    is_numeric($order['total'])
) {

    $total = $order['total'];

}

elseif (
    isset($order['total_amount']) &&
    is_numeric($order['total_amount'])
) {

    $total = $order['total_amount'];

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

<title>
Track Order <?= htmlspecialchars($order_number); ?>
| LoomWear
</title>


<style>

/* ==========================================
   RESET
========================================== */

* {

    box-sizing: border-box;

}


body {

    margin: 0;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    background: #f7f7f7;

    color: #111;

}


/* ==========================================
   HEADER
========================================== */

.header {

    height: 70px;

    background: #fff;

    border-bottom: 1px solid #e5e5e5;

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 0 6%;

}


.logo {

    font-size: 24px;

    font-weight: 700;

    letter-spacing: 4px;

}


.header-links {

    display: flex;

    gap: 25px;

}


.header-links a {

    color: #111;

    text-decoration: none;

    font-size: 13px;

}


.header-links a:hover {

    opacity: .6;

}


/* ==========================================
   PAGE
========================================== */

.page {

    max-width: 1000px;

    margin: auto;

    padding: 50px 20px 80px;

}


.back {

    color: #555;

    font-size: 13px;

    text-decoration: none;

}


.back:hover {

    color: #111;

}


/* ==========================================
   HEADING
========================================== */

.heading {

    margin: 30px 0;

}


.heading span {

    font-size: 11px;

    color: #777;

    letter-spacing: 3px;

}


.heading h1 {

    font-size: 32px;

    font-weight: 400;

    margin: 10px 0;

}


.heading p {

    color: #777;

    font-size: 14px;

}


/* ==========================================
   ORDER SUMMARY
========================================== */

.order-summary {

    background: #fff;

    border: 1px solid #e3e3e3;

    padding: 25px;

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 20px;

    margin-bottom: 25px;

}


.summary-item span {

    display: block;

    color: #888;

    font-size: 10px;

    text-transform: uppercase;

    letter-spacing: 1px;

    margin-bottom: 7px;

}


.summary-item strong {

    font-size: 14px;

    font-weight: 500;

}


/* ==========================================
   TRACKING CARD
========================================== */

.tracking-card {

    background: #fff;

    border: 1px solid #e3e3e3;

    padding: 40px;

}


/* ==========================================
   CURRENT STATUS
========================================== */

.current-status {

    text-align: center;

    padding-bottom: 35px;

    border-bottom: 1px solid #eee;

}


.current-status span {

    color: #777;

    font-size: 11px;

    letter-spacing: 2px;

    text-transform: uppercase;

}


.current-status h2 {

    font-size: 26px;

    font-weight: 400;

    margin: 10px 0 5px;

}


.current-status p {

    color: #777;

    font-size: 13px;

    margin: 0;

}


/* ==========================================
   TIMELINE
========================================== */

.timeline {

    max-width: 650px;

    margin: 45px auto 10px;

}


.timeline-item {

    position: relative;

    display: flex;

    min-height: 90px;

}


.timeline-left {

    width: 45px;

    display: flex;

    flex-direction: column;

    align-items: center;

}


.timeline-dot {

    width: 18px;

    height: 18px;

    border-radius: 50%;

    border: 2px solid #ccc;

    background: #fff;

    position: relative;

    z-index: 2;

}


.timeline-line {

    width: 2px;

    flex: 1;

    background: #ddd;

}


.timeline-item.completed
.timeline-dot {

    border-color: #111;

    background: #111;

}


.timeline-item.completed
.timeline-line {

    background: #111;

}


.timeline-content {

    padding-left: 20px;

    padding-bottom: 25px;

}


.timeline-content h3 {

    margin: 0 0 6px;

    font-size: 16px;

    font-weight: 500;

}


.timeline-content p {

    margin: 0;

    color: #777;

    font-size: 13px;

    line-height: 1.5;

}


.timeline-item.active
.timeline-content h3 {

    font-weight: 700;

}


/* ==========================================
   CANCELLED
========================================== */

.cancelled-box {

    background: #fff0f0;

    border: 1px solid #f0cccc;

    color: #a00000;

    padding: 20px;

    text-align: center;

}


.cancelled-box h3 {

    margin: 0 0 7px;

    font-size: 17px;

    font-weight: 500;

}


.cancelled-box p {

    margin: 0;

    font-size: 13px;

}


/* ==========================================
   DELIVERY INFO
========================================== */

.delivery-info {

    margin-top: 25px;

    background: #fff;

    border: 1px solid #e3e3e3;

    padding: 30px;

}


.delivery-info h2 {

    font-size: 20px;

    font-weight: 500;

    margin: 0 0 20px;

}


.delivery-grid {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 20px;

}


.delivery-item span {

    display: block;

    font-size: 10px;

    color: #888;

    letter-spacing: 1px;

    text-transform: uppercase;

    margin-bottom: 6px;

}


.delivery-item strong {

    font-size: 14px;

    font-weight: 400;

    line-height: 1.6;

}


/* ==========================================
   MOBILE
========================================== */

@media (max-width: 700px) {

    .header {

        padding: 0 20px;

    }


    .logo {

        font-size: 20px;

    }


    .header-links {

        gap: 12px;

    }


    .header-links a:first-child {

        display: none;

    }


    .page {

        padding: 35px 15px 50px;

    }


    .heading h1 {

        font-size: 27px;

    }


    .order-summary {

        grid-template-columns:
            repeat(2, 1fr);

    }


    .tracking-card {

        padding: 25px 18px;

    }


    .delivery-grid {

        grid-template-columns: 1fr;

    }

}


@media (max-width: 450px) {

    .order-summary {

        grid-template-columns: 1fr;

    }

}

</style>

</head>


<body>


<!-- ==========================================
     HEADER
========================================== -->

<header class="header">


    <a
        href="../index.php"
        style="text-decoration:none;color:#111;"
    >

        <div class="logo">

            LOOMWEAR

        </div>

    </a>


    <div class="header-links">

        <a href="account.php">

            My Account

        </a>


        <a href="logout.php">

            Logout

        </a>

    </div>


</header>



<!-- ==========================================
     PAGE
========================================== -->

<main class="page">


    <a
        href="my-orders.php"
        class="back"
    >

        ← Back to My Orders

    </a>



    <div class="heading">

        <span>

            ORDER TRACKING

        </span>


        <h1>

            Track Your Order

        </h1>


        <p>

            Follow the progress of your
            LoomWear order.

        </p>

    </div>



    <!-- ==========================================
         ORDER SUMMARY
    =========================================== -->

    <div class="order-summary">


        <div class="summary-item">

            <span>

                Order Number

            </span>


            <strong>

                <?= htmlspecialchars(
                    $order_number
                ); ?>

            </strong>

        </div>



        <div class="summary-item">

            <span>

                Order Date

            </span>


            <strong>

                <?php

                if (!empty($order['created_at'])) {

                    echo date(
                        "F j, Y",
                        strtotime(
                            $order['created_at']
                        )
                    );

                }

                ?>

            </strong>

        </div>



        <div class="summary-item">

            <span>

                Payment

            </span>


            <strong>

                <?= htmlspecialchars(
                    $order['payment_method']
                    ?? 'Not available'
                ); ?>

            </strong>

        </div>



        <div class="summary-item">

            <span>

                Total

            </span>


            <strong>

                Rs.
                <?= number_format(
                    (float) $total
                ); ?>

            </strong>

        </div>


    </div>



    <!-- ==========================================
         TRACKING
    =========================================== -->

    <div class="tracking-card">


        <?php if ($is_cancelled): ?>


            <div class="cancelled-box">

                <h3>

                    Order Cancelled

                </h3>


                <p>

                    Unfortunately, this order has
                    been cancelled.

                </p>

            </div>


        <?php else: ?>


            <div class="current-status">

                <span>

                    Current Status

                </span>


                <h2>

                    <?= htmlspecialchars(
                        $display_status
                    ); ?>

                </h2>


                <p>

                    <?php

                    if (
                        isset(
                            $steps[$status]
                        )
                    ) {

                        echo htmlspecialchars(
                            $steps[$status]['description']
                        );

                    } else {

                        echo "Your order is being processed.";

                    }

                    ?>

                </p>

            </div>



            <!-- TIMELINE -->

            <div class="timeline">


                <?php

                $step_number = 0;

                foreach (
                    $steps as $step_key => $step
                ):

                    $step_number++;


                    $completed =
                        $step_number <= $current_step;


                    $active =
                        $step_key === $status;

                ?>


                    <div
                        class="timeline-item
                        <?= $completed
                            ? 'completed'
                            : ''; ?>
                        <?= $active
                            ? 'active'
                            : ''; ?>"
                    >


                        <div class="timeline-left">


                            <div class="timeline-dot"></div>


                            <?php if (
                                $step_number <
                                count($steps)
                            ): ?>

                                <div
                                    class="timeline-line"
                                ></div>

                            <?php endif; ?>


                        </div>


                        <div class="timeline-content">


                            <h3>

                                <?= htmlspecialchars(
                                    $step['title']
                                ); ?>

                            </h3>


                            <p>

                                <?= htmlspecialchars(
                                    $step['description']
                                ); ?>

                            </p>


                        </div>


                    </div>


                <?php endforeach; ?>


            </div>


        <?php endif; ?>


    </div>



    <!-- ==========================================
         DELIVERY INFORMATION
    =========================================== -->

    <div class="delivery-info">


        <h2>

            Delivery Information

        </h2>


        <div class="delivery-grid">


            <div class="delivery-item">

                <span>

                    Customer

                </span>


                <strong>

                    <?= htmlspecialchars(
                        $order['customer_name']
                        ?? ''
                    ); ?>

                </strong>

            </div>



            <div class="delivery-item">

                <span>

                    Phone

                </span>


                <strong>

                    <?= htmlspecialchars(
                        $order['phone']
                        ?? ''
                    ); ?>

                </strong>

            </div>



            <div class="delivery-item">

                <span>

                    City

                </span>


                <strong>

                    <?= htmlspecialchars(
                        $order['city']
                        ?? ''
                    ); ?>

                </strong>

            </div>



            <div class="delivery-item">

                <span>

                    Postal Code

                </span>


                <strong>

                    <?= htmlspecialchars(
                        $order['postal_code']
                        ?? ''
                    ); ?>

                </strong>

            </div>



            <div class="delivery-item">

                <span>

                    Delivery Address

                </span>


                <strong>

                    <?= htmlspecialchars(
                        $order['address']
                        ?? ''
                    ); ?>

                </strong>

            </div>


        </div>


    </div>


</main>


</body>

</html>


