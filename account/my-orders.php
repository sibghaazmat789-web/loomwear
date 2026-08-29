
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
   CUSTOMER EMAIL
========================================== */

$email = $_SESSION['customer_email'];

$email_safe = mysqli_real_escape_string(
    $conn,
    $email
);


/* ==========================================
   GET CUSTOMER ORDERS
========================================== */

$query = mysqli_query(
    $conn,
    "SELECT *
     FROM orders
     WHERE email = '$email_safe'
     ORDER BY id DESC"
);


if (!$query) {

    die("Unable to load orders.");

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

<title>My Orders | LoomWear</title>


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

    text-decoration: none;

    color: #111;

    font-size: 13px;

}


.header-links a:hover {

    opacity: .6;

}


/* ==========================================
   PAGE
========================================== */

.orders-page {

    max-width: 1100px;

    margin: auto;

    padding: 55px 20px 80px;

}


.back-link {

    color: #555;

    text-decoration: none;

    font-size: 13px;

}


.back-link:hover {

    color: #111;

}


/* ==========================================
   HEADING
========================================== */

.page-heading {

    margin: 30px 0 35px;

}


.page-heading span {

    color: #777;

    font-size: 11px;

    letter-spacing: 3px;

}


.page-heading h1 {

    font-size: 34px;

    font-weight: 400;

    margin: 10px 0;

}


.page-heading p {

    color: #777;

    font-size: 14px;

    margin: 0;

}


/* ==========================================
   ORDER CARD
========================================== */

.order-card {

    background: #fff;

    border: 1px solid #e3e3e3;

    margin-bottom: 18px;

}


/* ==========================================
   ORDER TOP
========================================== */

.order-top {

    padding: 22px 25px;

    border-bottom: 1px solid #eee;

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

}


.order-number {

    font-size: 14px;

    font-weight: 600;

}


.order-date {

    font-size: 12px;

    color: #777;

    margin-top: 6px;

}


/* ==========================================
   STATUS
========================================== */

.status {

    padding: 7px 14px;

    font-size: 11px;

    text-transform: uppercase;

    letter-spacing: .5px;

    background: #f1f1f1;

}


/* ==========================================
   STATUS COLORS
========================================== */

.status.pending {

    background: #fff6df;

    color: #8a6100;

}


.status.confirmed {

    background: #eaf4ff;

    color: #185a8d;

}


.status.processing {

    background: #f1ecff;

    color: #6242a5;

}


.status.shipped {

    background: #e8f7ef;

    color: #217346;

}


.status.out {

    background: #e8f7ef;

    color: #217346;

}


.status.delivered {

    background: #e6f7e6;

    color: #267326;

}


.status.cancelled {

    background: #fff0f0;

    color: #a00000;

}


/* ==========================================
   ORDER BODY
========================================== */

.order-body {

    padding: 25px;

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 25px;

}


.order-info span {

    display: block;

    color: #888;

    font-size: 11px;

    text-transform: uppercase;

    letter-spacing: 1px;

    margin-bottom: 7px;

}


.order-info strong {

    font-size: 14px;

    font-weight: 500;

}


/* ==========================================
   ORDER FOOTER
========================================== */

.order-footer {

    padding: 18px 25px;

    border-top: 1px solid #eee;

    display: flex;

    align-items: center;

    justify-content: space-between;

}


.total {

    font-size: 14px;

}


.total strong {

    font-size: 17px;

    margin-left: 8px;

}


.track-button {

    display: inline-block;

    padding: 11px 20px;

    background: #111;

    color: #fff;

    text-decoration: none;

    font-size: 12px;

    letter-spacing: .5px;

    transition: .2s;

}


.track-button:hover {

    background: #333;

}


/* ==========================================
   EMPTY ORDERS
========================================== */

.empty-orders {

    background: #fff;

    border: 1px solid #e3e3e3;

    padding: 70px 30px;

    text-align: center;

}


.empty-icon {

    width: 60px;

    height: 60px;

    border: 1px solid #ddd;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    margin: 0 auto 20px;

    font-size: 22px;

}


.empty-orders h2 {

    font-size: 22px;

    font-weight: 400;

    margin: 0 0 10px;

}


.empty-orders p {

    color: #777;

    font-size: 14px;

    margin-bottom: 25px;

}


.shop-button {

    display: inline-block;

    background: #111;

    color: #fff;

    padding: 13px 25px;

    text-decoration: none;

    font-size: 12px;

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


    .orders-page {

        padding: 35px 15px 50px;

    }


    .page-heading h1 {

        font-size: 28px;

    }


    .order-top {

        align-items: flex-start;

        flex-direction: column;

    }


    .order-body {

        grid-template-columns: 1fr;

        gap: 18px;

    }


    .order-footer {

        align-items: flex-start;

        flex-direction: column;

        gap: 15px;

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

<main class="orders-page">


    <a
        href="account.php"
        class="back-link"
    >

        ← Back to My Account

    </a>



    <div class="page-heading">

        <span>

            MY ACCOUNT

        </span>


        <h1>

            My Orders

        </h1>


        <p>

            View your LoomWear purchases and
            track your orders.

        </p>

    </div>



    <?php if (mysqli_num_rows($query) > 0): ?>


        <?php while ($order = mysqli_fetch_assoc($query)): ?>


            <?php

            $status = strtolower(
                trim($order['status'] ?? 'Pending')
            );


            /* Determine status class */

            $status_class = 'pending';


            if ($status === 'confirmed') {

                $status_class = 'confirmed';

            }

            elseif ($status === 'processing') {

                $status_class = 'processing';

            }

            elseif ($status === 'shipped') {

                $status_class = 'shipped';

            }

            elseif (
                $status === 'out for delivery' ||
                $status === 'out_for_delivery'
            ) {

                $status_class = 'out';

            }

            elseif ($status === 'delivered') {

                $status_class = 'delivered';

            }

            elseif ($status === 'cancelled') {

                $status_class = 'cancelled';

            }


            $display_status =
                ucwords(
                    str_replace(
                        '_',
                        ' ',
                        $status
                    )
                );


            /* Order number */

            $order_number =
                !empty($order['order_number'])
                ? $order['order_number']
                : 'LW-' . $order['id'];


            /* Total */

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


            <div class="order-card">


                <!-- ORDER TOP -->

                <div class="order-top">


                    <div>

                        <div class="order-number">

                            Order #

                            <?= htmlspecialchars(
                                $order_number
                            ); ?>

                        </div>


                        <div class="order-date">

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

                        </div>

                    </div>


                    <span
                        class="status <?= $status_class; ?>"
                    >

                        <?= htmlspecialchars(
                            $display_status
                        ); ?>

                    </span>


                </div>



                <!-- ORDER BODY -->

                <div class="order-body">


                    <div class="order-info">

                        <span>

                            Payment Method

                        </span>


                        <strong>

                            <?= htmlspecialchars(
                                $order['payment_method']
                                ?? 'Not available'
                            ); ?>

                        </strong>

                    </div>



                    <div class="order-info">

                        <span>

                            Delivery City

                        </span>


                        <strong>

                            <?= htmlspecialchars(
                                $order['city']
                                ?? 'Not available'
                            ); ?>

                        </strong>

                    </div>



                    <div class="order-info">

                        <span>

                            Phone

                        </span>


                        <strong>

                            <?= htmlspecialchars(
                                $order['phone']
                                ?? 'Not available'
                            ); ?>

                        </strong>

                    </div>


                </div>



                <!-- ORDER FOOTER -->

                <div class="order-footer">


                    <div class="total">

                        Total:

                        <strong>

                            Rs.
                            <?= number_format(
                                (float) $total
                            ); ?>

                        </strong>

                    </div>


                    <a
                        href="track-order.php?id=<?= (int) $order['id']; ?>"
                        class="track-button"
                    >

                        TRACK ORDER

                    </a>


                </div>


            </div>


        <?php endwhile; ?>


    <?php else: ?>


        <!-- ==========================================
             NO ORDERS
        =========================================== -->

        <div class="empty-orders">


            <div class="empty-icon">

                🛍

            </div>


            <h2>

                You haven't placed an order yet.

            </h2>


            <p>

                Discover the latest LoomWear
                collections and find something
                you'll love.

            </p>


            <a
                href="../shop.php"
                class="shop-button"
            >

                START SHOPPING

            </a>


        </div>


    <?php endif; ?>


</main>


</body>

</html>

