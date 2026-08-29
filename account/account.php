
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


$customer_id = (int) $_SESSION['customer_id'];


/* ==========================================
   GET CUSTOMER DETAILS
========================================== */

$query = mysqli_query(
    $conn,
    "SELECT *
     FROM customers
     WHERE id = $customer_id
     LIMIT 1"
);


if (!$query || mysqli_num_rows($query) !== 1) {

    session_destroy();

    header("Location: login.php");

    exit();

}


$customer = mysqli_fetch_assoc($query);


$first_name = $customer['first_name'];
$last_name  = $customer['last_name'];
$email      = $customer['email'];
$phone      = $customer['phone'];


/* ==========================================
   COUNT ORDERS
========================================== */

$order_count = 0;

$order_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM orders
     WHERE email = '" .
     mysqli_real_escape_string($conn, $email) .
     "'"
);


if ($order_query) {

    $order_data = mysqli_fetch_assoc($order_query);

    $order_count = (int) $order_data['total'];

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

<title>My Account | LoomWear</title>


<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
>


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

.account-header {

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


.header-right {

    display: flex;

    align-items: center;

    gap: 25px;

}


.header-right a {

    color: #111;

    text-decoration: none;

    font-size: 13px;

}


.logout-link {

    display: flex;

    align-items: center;

    gap: 7px;

}


.logout-link:hover {

    opacity: .6;

}


/* ==========================================
   MAIN
========================================== */

.account-main {

    max-width: 1180px;

    margin: auto;

    padding: 55px 25px 80px;

}


/* ==========================================
   WELCOME
========================================== */

.account-welcome {

    margin-bottom: 40px;

}


.account-label {

    font-size: 11px;

    letter-spacing: 3px;

    color: #777;

}


.account-welcome h1 {

    font-size: 36px;

    font-weight: 400;

    margin: 10px 0;

}


.account-welcome p {

    color: #777;

    margin: 0;

    font-size: 14px;

}


/* ==========================================
   ACCOUNT GRID
========================================== */

.account-grid {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 18px;

}


/* ==========================================
   ACCOUNT CARD
========================================== */

.account-card {

    background: #fff;

    border: 1px solid #e5e5e5;

    padding: 30px;

    text-decoration: none;

    color: #111;

    min-height: 190px;

    transition: .25s ease;

}


.account-card:hover {

    border-color: #111;

    transform: translateY(-3px);

}


.card-icon {

    width: 45px;

    height: 45px;

    border: 1px solid #ddd;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 17px;

}


.account-card h3 {

    font-size: 17px;

    font-weight: 500;

    margin: 20px 0 8px;

}


.account-card p {

    font-size: 13px;

    color: #777;

    line-height: 1.6;

    margin: 0;

}


/* ==========================================
   ORDER STAT
========================================== */

.order-stat {

    display: inline-block;

    margin-top: 15px;

    font-size: 13px;

    color: #111;

}


/* ==========================================
   ACCOUNT INFORMATION
========================================== */

.account-info {

    margin-top: 45px;

    background: #fff;

    border: 1px solid #e5e5e5;

    padding: 35px;

}


.account-info-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 25px;

}


.account-info-header h2 {

    font-size: 21px;

    font-weight: 500;

    margin: 0;

}


.edit-link {

    color: #111;

    font-size: 13px;

    text-decoration: underline;

}


.info-grid {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 20px;

}


.info-item {

    padding: 15px;

    background: #f8f8f8;

}


.info-item span {

    display: block;

    font-size: 11px;

    color: #777;

    margin-bottom: 6px;

    text-transform: uppercase;

    letter-spacing: 1px;

}


.info-item strong {

    font-size: 14px;

    font-weight: 500;

}


/* ==========================================
   FOOTER
========================================== */

.account-footer {

    text-align: center;

    padding: 25px;

    background: #111;

    color: #fff;

    font-size: 12px;

}


/* ==========================================
   MOBILE
========================================== */

@media (max-width: 800px) {

    .account-grid {

        grid-template-columns:
            repeat(2, 1fr);

    }

}


@media (max-width: 550px) {

    .account-header {

        padding: 0 20px;

    }


    .logo {

        font-size: 20px;

    }


    .header-right {

        gap: 12px;

    }


    .header-right a:first-child {

        display: none;

    }


    .account-main {

        padding: 35px 15px 50px;

    }


    .account-welcome h1 {

        font-size: 28px;

    }


    .account-grid {

        grid-template-columns: 1fr;

    }


    .account-info {

        padding: 22px;

    }


    .info-grid {

        grid-template-columns: 1fr;

    }

}

</style>

</head>


<body>


<!-- ==========================================
     HEADER
========================================== -->

<header class="account-header">


    <a
        href="../index.php"
        style="text-decoration:none;color:#111;"
    >

        <div class="logo">

            LOOMWEAR

        </div>

    </a>


    <div class="header-right">


        <a href="../shop.php">

            Continue Shopping

        </a>


        <a
            href="logout.php"
            class="logout-link"
        >

            <i class="fa-solid fa-arrow-right-from-bracket"></i>

            Logout

        </a>


    </div>


</header>



<!-- ==========================================
     MAIN
========================================== -->

<main class="account-main">


    <!-- WELCOME -->

    <section class="account-welcome">

        <span class="account-label">

            MY ACCOUNT

        </span>


        <h1>

            Hello,
            <?= htmlspecialchars($first_name); ?>

        </h1>


        <p>

            Welcome back to LoomWear.
            Manage your orders and account details here.

        </p>

    </section>



    <!-- ACCOUNT CARDS -->

    <section class="account-grid">


        <!-- ORDERS -->

        <a
            href="my-orders.php"
            class="account-card"
        >

            <div class="card-icon">

                <i class="fa-solid fa-box"></i>

            </div>


            <h3>

                My Orders

            </h3>


            <p>

                View your previous purchases
                and check your order status.

            </p>


            <span class="order-stat">

                <?= $order_count; ?>

                <?= $order_count == 1
                    ? "Order"
                    : "Orders"; ?>

            </span>

        </a>



        <!-- ACCOUNT DETAILS -->

        <a
            href="account-details.php"
            class="account-card"
        >

            <div class="card-icon">

                <i class="fa-regular fa-user"></i>

            </div>


            <h3>

                Account Details

            </h3>


            <p>

                Update your personal information,
                phone number and account details.

            </p>

        </a>



        <!-- WISHLIST -->

        <a
            href="../wishlist.php"
            class="account-card"
        >

            <div class="card-icon">

                <i class="fa-regular fa-heart"></i>

            </div>


            <h3>

                Wishlist

            </h3>


            <p>

                View the products you've saved
                for your next purchase.

            </p>

        </a>



        <!-- SHOP -->

        <a
            href="../shop.php"
            class="account-card"
        >

            <div class="card-icon">

                <i class="fa-solid fa-bag-shopping"></i>

            </div>


            <h3>

                Continue Shopping

            </h3>


            <p>

                Explore LoomWear's latest
                collections and new arrivals.

            </p>

        </a>


    </section>



    <!-- ==========================================
         ACCOUNT INFORMATION
    =========================================== -->

    <section class="account-info">


        <div class="account-info-header">

            <h2>

                Personal Information

            </h2>


            <a
                href="account-details.php"
                class="edit-link"
            >

                Edit

            </a>

        </div>


        <div class="info-grid">


            <div class="info-item">

                <span>

                    Name

                </span>


                <strong>

                    <?= htmlspecialchars(
                        $first_name . " " . $last_name
                    ); ?>

                </strong>

            </div>


            <div class="info-item">

                <span>

                    Email

                </span>


                <strong>

                    <?= htmlspecialchars($email); ?>

                </strong>

            </div>


            <div class="info-item">

                <span>

                    Phone

                </span>


                <strong>

                    <?= htmlspecialchars(
                        $phone ?: "Not added"
                    ); ?>

                </strong>

            </div>


            <div class="info-item">

                <span>

                    Member Since

                </span>


                <strong>

                    <?= date(
                        "F Y",
                        strtotime($customer['created_at'])
                    ); ?>

                </strong>

            </div>


        </div>


    </section>


</main>



<!-- ==========================================
     FOOTER
========================================== -->

<footer class="account-footer">

    © <?= date("Y"); ?> LoomWear.
    All Rights Reserved.

</footer>


</body>

</html>
