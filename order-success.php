<?php

session_start();

require_once "includes/db.php";


// ==========================================
// CHECK ORDER NUMBER
// ==========================================

if (!isset($_GET['order']) || empty($_GET['order'])) {

    header("Location: index.php");
    exit;

}


$order_number = mysqli_real_escape_string(
    $conn,
    $_GET['order']
);


// ==========================================
// GET ORDER
// ==========================================

$orderQuery = mysqli_query(
    $conn,

    "SELECT *
     FROM orders
     WHERE order_number='$order_number'
     LIMIT 1"
);


if (!$orderQuery || mysqli_num_rows($orderQuery) == 0) {

    header("Location: index.php");
    exit;

}


$order = mysqli_fetch_assoc($orderQuery);


// ==========================================
// FORMAT TOTAL
// ==========================================

$total = number_format(
    (float)$order['total_amount'],
    2
);

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
        Order Confirmed | LoomWear
    </title>


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <style>

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f6f6f4;

            color: #111;

        }


        /* ==================================
           HEADER
        ================================== */

        .success-header {

            height: 75px;

            background: #111;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .success-logo {

            color: #fff;

            text-decoration: none;

            font-size: 28px;

            font-weight: 700;

            letter-spacing: -1px;

        }


        .success-logo span {

            font-weight: 400;

        }


        /* ==================================
           MAIN
        ================================== */

        .success-page {

            min-height: calc(100vh - 75px);

            display: flex;

            justify-content: center;

            padding: 60px 20px;

        }


        .success-card {

            width: 100%;

            max-width: 800px;

            background: #fff;

            padding: 55px;

            text-align: center;

            box-shadow:
                0 10px 40px
                rgba(0,0,0,0.06);

        }


        /* ==================================
           CHECK ICON
        ================================== */

        .success-icon {

            width: 80px;

            height: 80px;

            margin: 0 auto 25px;

            border-radius: 50%;

            background: #111;

            color: #fff;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 32px;

        }


        .success-card h1 {

            margin: 0 0 12px;

            font-size: 32px;

            font-weight: 600;

        }


        .success-message {

            color: #666;

            font-size: 15px;

            line-height: 1.7;

            max-width: 560px;

            margin: 0 auto 35px;

        }


        /* ==================================
           ORDER NUMBER
        ================================== */

        .order-number-box {

            background: #f5f5f3;

            padding: 22px;

            margin-bottom: 35px;

        }


        .order-number-box span {

            display: block;

            color: #777;

            font-size: 11px;

            letter-spacing: 1.5px;

            text-transform: uppercase;

            margin-bottom: 8px;

        }


        .order-number-box strong {

            font-size: 22px;

            letter-spacing: .5px;

        }


        /* ==================================
           DETAILS
        ================================== */

        .order-details {

            border-top: 1px solid #eee;

            border-bottom: 1px solid #eee;

            padding: 25px 0;

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;

            margin-bottom: 35px;

        }


        .detail-box {

            text-align: center;

        }


        .detail-box span {

            display: block;

            color: #888;

            font-size: 11px;

            text-transform: uppercase;

            letter-spacing: 1px;

            margin-bottom: 7px;

        }


        .detail-box strong {

            font-size: 14px;

        }


        /* ==================================
           TOTAL
        ================================== */

        .order-total {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 18px 0;

            font-size: 16px;

        }


        .order-total strong {

            font-size: 24px;

        }


        /* ==================================
           EMAIL MESSAGE
        ================================== */

        .email-notice {

            margin: 25px 0 35px;

            padding: 18px;

            background: #f7f7f7;

            color: #555;

            font-size: 13px;

            line-height: 1.6;

        }


        .email-notice i {

            margin-right: 8px;

        }


        /* ==================================
           BUTTONS
        ================================== */

        .success-actions {

            display: flex;

            justify-content: center;

            gap: 12px;

        }


        .success-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding: 15px 28px;

            text-decoration: none;

            font-size: 13px;

            font-weight: 600;

            transition: .25s;

        }


        .primary-btn {

            background: #111;

            color: #fff;

        }


        .primary-btn:hover {

            background: #333;

        }


        .secondary-btn {

            border: 1px solid #222;

            color: #111;

            background: #fff;

        }


        .secondary-btn:hover {

            background: #111;

            color: #fff;

        }


        /* ==================================
           MOBILE
        ================================== */

        @media (max-width: 600px) {

            .success-page {

                padding: 25px 15px;

            }


            .success-card {

                padding: 35px 20px;

            }


            .success-card h1 {

                font-size: 26px;

            }


            .order-details {

                grid-template-columns: 1fr;

            }


            .success-actions {

                flex-direction: column;

            }


            .success-btn {

                width: 100%;

            }

        }

    </style>

</head>


<body>


<!-- ==========================================
     HEADER
========================================== -->

<header class="success-header">

    <a
        href="index.php"
        class="success-logo"
    >

        Loom<span>Wear</span>

    </a>

</header>


<!-- ==========================================
     SUCCESS
========================================== -->

<main class="success-page">

    <div class="success-card">


        <!-- Check -->

        <div class="success-icon">

            <i class="fas fa-check"></i>

        </div>


        <!-- Heading -->

        <h1>

            Order Confirmed!

        </h1>


        <p class="success-message">

            Thank you,
            <strong>
                <?= htmlspecialchars(
                    $order['customer_name']
                ); ?>
            </strong>!

            Your order has been successfully
            placed and is now being processed.

        </p>


        <!-- Order Number -->

        <div class="order-number-box">

            <span>
                Your Order Number
            </span>

            <strong>

                #
                <?= htmlspecialchars(
                    $order['order_number']
                ); ?>

            </strong>

        </div>


        <!-- Order Details -->

        <div class="order-details">


            <div class="detail-box">

                <span>
                    Order Status
                </span>

                <strong>

                    <?= htmlspecialchars(
                        $order['status']
                    ); ?>

                </strong>

            </div>


            <div class="detail-box">

                <span>
                    Payment
                </span>

                <strong>

                    <?= htmlspecialchars(
                        $order['payment_method']
                    ); ?>

                </strong>

            </div>


            <div class="detail-box">

                <span>
                    City
                </span>

                <strong>

                    <?= htmlspecialchars(
                        $order['city']
                    ); ?>

                </strong>

            </div>


        </div>


        <!-- Total -->

        <div class="order-total">

            <span>
                Order Total
            </span>

            <strong>

                Rs.
                <?= $total; ?>

            </strong>

        </div>


        <!-- Email -->

        <div class="email-notice">

            <i class="fas fa-envelope"></i>

            A confirmation email has been sent to

            <strong>
                <?= htmlspecialchars(
                    $order['email']
                ); ?>
            </strong>.

        </div>


        <!-- Buttons -->

        <div class="success-actions">


            <a
                href="shop.php"
                class="success-btn primary-btn"
            >

                Continue Shopping

                <i class="fas fa-arrow-right"></i>

            </a>


            <a
                href="index.php"
                class="success-btn secondary-btn"
            >

                Back to Home

            </a>


        </div>


    </div>

</main>


</body>

</html>