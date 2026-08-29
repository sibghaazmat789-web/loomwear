
<?php

session_start();

include "../includes/db.php";


/* ==========================================
   CHECK ORDER ID
========================================== */

if (
    !isset($_GET['id']) ||
    !is_numeric($_GET['id'])
) {

    header("Location: orders.php");
    exit();

}


$order_id = (int) $_GET['id'];


/* ==========================================
   GET ORDER
========================================== */

$orderQuery = mysqli_query(
    $conn,
    "SELECT *
     FROM orders
     WHERE id = $order_id
     LIMIT 1"
);


if (!$orderQuery || mysqli_num_rows($orderQuery) === 0) {

    die("Order not found.");

}


$order = mysqli_fetch_assoc($orderQuery);



/* ==========================================
   GET ORDER ITEMS
========================================== */

$items = [];


/*
   Try common order-items table names.
   If your project uses order_items, this
   will automatically load the products.
*/

$itemQuery = mysqli_query(
    $conn,
    "SELECT
        oi.id,
        oi.order_id,
        oi.product_id,
        oi.color,
        oi.size,
        oi.quantity,
        oi.price AS item_price,
        p.product_name,
        p.price AS product_price

     FROM order_items oi

     LEFT JOIN products p
        ON oi.product_id = p.id

     WHERE oi.order_id = $order_id

     ORDER BY oi.id ASC"
);

if ($itemQuery) {

    while ($item = mysqli_fetch_assoc($itemQuery)) {

        $items[] = $item;

    }

}


/* ==========================================
   STATUS
========================================== */

$status =
    $order['status'] ?? 'Pending';


$statusClass =
    strtolower(
        str_replace(
            ' ',
            '-',
            $status
        )
    );


/* ==========================================
   ORDER NUMBER
========================================== */

$orderNumber =
    !empty($order['order_number'])
    ? $order['order_number']
    : 'LW-' . $order['id'];


/* ==========================================
   TOTAL
========================================== */

$total = (float)$order['total_amount'];

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

Order #<?= htmlspecialchars($orderNumber); ?>

| LoomWear Admin

</title>


<link
rel="stylesheet"
href="assets/css/admin.css"
>


<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
>


<style>

/* ==========================================
   PAGE
========================================== */

.order-details-page {

    padding:30px;

}


.back-link {

    display:inline-block;

    margin-bottom:20px;

    color:#555;

    text-decoration:none;

    font-size:13px;

}


.back-link:hover {

    color:#111;

}


.order-heading {

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    margin-bottom:25px;

}


.order-heading h1 {

    margin:0;

    font-size:28px;

}


.order-heading p {

    margin:7px 0 0;

    color:#777;

    font-size:13px;

}


/* ==========================================
   STATUS
========================================== */

.status-badge {

    display:inline-block;

    padding:8px 14px;

    border-radius:20px;

    font-size:12px;

    background:#f0f0f0;

}


.status-pending {

    background:#fff4d6;

    color:#8a6500;

}


.status-confirmed {

    background:#e8f1ff;

    color:#245a9c;

}


.status-processing {

    background:#eee;

    color:#333;

}


.status-shipped {

    background:#e9f7ef;

    color:#237a48;

}


.status-delivered {

    background:#dff5e8;

    color:#176638;

}


.status-cancelled {

    background:#ffe8e8;

    color:#a00000;

}


/* ==========================================
   GRID
========================================== */

.details-grid {

    display:grid;

    grid-template-columns:
        2fr 1fr;

    gap:25px;

}


/* ==========================================
   CARD
========================================== */

.card {

    background:#fff;

    border-radius:10px;

    padding:25px;

    margin-bottom:25px;

    box-shadow:
        0 2px 10px rgba(0,0,0,.05);

}


.card h2 {

    margin:0 0 20px;

    font-size:18px;

}


/* ==========================================
   INFO
========================================== */

.info-row {

    display:flex;

    justify-content:space-between;

    gap:20px;

    padding:12px 0;

    border-bottom:1px solid #eee;

    font-size:13px;

}


.info-row:last-child {

    border-bottom:0;

}


.info-label {

    color:#777;

}


.info-value {

    text-align:right;

    font-weight:500;

}


/* ==========================================
   TOTAL
========================================== */

.total-box {

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-top:20px;

    padding-top:20px;

    border-top:2px solid #111;

}


.total-box span {

    color:#666;

}


.total-box strong {

    font-size:22px;

}


/* ==========================================
   CUSTOMER
========================================== */

.customer-name {

    font-size:18px;

    font-weight:600;

    margin-bottom:15px;

}


.customer-info {

    color:#666;

    font-size:13px;

    line-height:1.8;

}


/* ==========================================
   ADDRESS
========================================== */

.address-box {

    background:#f7f7f7;

    padding:18px;

    font-size:13px;

    line-height:1.7;

}


/* ==========================================
   PRODUCTS
========================================== */

.product-table {

    width:100%;

    border-collapse:collapse;

}


.product-table th {

    background:#f7f7f7;

    padding:12px;

    text-align:left;

    font-size:11px;

    text-transform:uppercase;

}


.product-table td {

    padding:15px 12px;

    border-bottom:1px solid #eee;

    font-size:13px;

}


/* ==========================================
   UPDATE STATUS
========================================== */

.status-form {

    display:flex;

    gap:10px;

}


.status-form select {

    flex:1;

    padding:11px;

    border:1px solid #ddd;

    border-radius:5px;

}


.status-form button {

    background:#111;

    color:#fff;

    border:0;

    padding:11px 18px;

    border-radius:5px;

    cursor:pointer;

}


.status-form button:hover {

    background:#333;

}


/* ==========================================
   MOBILE
========================================== */

@media(max-width:900px) {

    .order-details-page {

        padding:20px;

    }


    .details-grid {

        grid-template-columns:1fr;

    }


    .order-heading {

        flex-direction:column;

        gap:15px;

    }

}


@media(max-width:600px) {

    .status-form {

        flex-direction:column;

    }


    .product-table {

        min-width:600px;

    }

}

</style>

</head>


<body>


<?php include "includes/sidebar.php"; ?>


<div class="main-content">


<?php include "includes/navbar.php"; ?>


<div class="order-details-page">


    <!-- BACK -->

    <a
        href="orders.php"
        class="back-link"
    >

        ← Back to Orders

    </a>



    <!-- HEADING -->

    <div class="order-heading">


        <div>

            <h1>

                Order #<?= htmlspecialchars(
                    $orderNumber
                ); ?>

            </h1>


            <p>

                Order placed

                <?php

                if (
                    !empty(
                        $order['created_at']
                    )
                ) {

                    echo date(
                        "F j, Y — g:i A",
                        strtotime(
                            $order['created_at']
                        )
                    );

                }

                ?>

            </p>

        </div>


        <span
            class="status-badge
            status-<?= $statusClass; ?>"
        >

            <?= htmlspecialchars(
                $status
            ); ?>

        </span>


    </div>



    <div class="details-grid">


        <!-- ==================================
             LEFT COLUMN
        =================================== -->

        <div>


            <!-- ORDER INFORMATION -->

            <div class="card">


                <h2>

                    Order Information

                </h2>


                <div class="info-row">

                    <span class="info-label">

                        Order Number

                    </span>


                    <span class="info-value">

                        #<?= htmlspecialchars(
                            $orderNumber
                        ); ?>

                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">

                        Payment Method

                    </span>


                    <span class="info-value">

                        <?= htmlspecialchars(
                            $order['payment_method']
                            ?? 'N/A'
                        ); ?>

                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">

                        Order Status

                    </span>


                    <span class="info-value">

                        <?= htmlspecialchars(
                            $status
                        ); ?>

                    </span>

                </div>


                <div class="total-box">

                    <span>

                        Order Total

                    </span>


                    <strong>
    Rs. <?= number_format($total, 2); ?>
</strong>
                </div>


            </div>



            <!-- PRODUCTS -->

            <div class="card">


                <h2>

                    Products

                </h2>


                <?php if (
                    count($items) > 0
                ): ?>


                    <div
                        style="
                            overflow-x:auto;
                        "
                    >

                        <table
                            class="product-table"
                        >

                            <thead>

                                <tr>

                                    <th>
                                        Product
                                    </th>

                                    <th>
                                        Size
                                    </th>

                                    <th>
                                        Color
                                    </th>

                                    <th>
                                        Qty
                                    </th>

                                    <th>
                                        Price
                                    </th>

                                </tr>

                            </thead>


                            <tbody>


                            <?php foreach (
                                $items
                                as $item
                            ): ?>


                                <tr>

                                    <td>

                                        <strong>

                                            <?= htmlspecialchars(
                                                $item['product_name']
                                                ?? 'Product'
                                            ); ?>

                                        </strong>

                                    </td>


                                    <td>

                                        <?= htmlspecialchars(
                                            $item['size']
                                            ?? 'N/A'
                                        ); ?>

                                    </td>


                                    <td>

                                        <?= htmlspecialchars(
                                            $item['color']
                                            ?? 'N/A'
                                        ); ?>

                                    </td>


                                    <td>

                                        <?= (int)(
                                            $item['quantity']
                                            ?? 1
                                        ); ?>

                                    </td>


                                    <td>

                                        Rs.

                                        <?= number_format(
    (float)(
        $item['item_price']
        ?? $item['product_price']
        ?? 0
    )
); ?>
                                    </td>

                                </tr>


                            <?php endforeach; ?>


                            </tbody>

                        </table>

                    </div>


                <?php else: ?>


                    <p style="
                        color:#777;
                        font-size:13px;
                    ">

                        Product details are not
                        available for this order.

                    </p>


                <?php endif; ?>


            </div>



            <!-- SHIPPING ADDRESS -->

            <div class="card">


                <h2>

                    Shipping Address

                </h2>


                <div class="address-box">

                    <strong>

                        <?= htmlspecialchars(
                            $order['customer_name']
                        ); ?>

                    </strong>

                    <br>

                    <?= htmlspecialchars(
                        $order['address']
                        ?? ''
                    ); ?>

                    <br>

                    <?= htmlspecialchars(
                        $order['city']
                        ?? ''
                    ); ?>

                    -

                    <?= htmlspecialchars(
                        $order['postal_code']
                        ?? ''
                    ); ?>

                    <br>

                    Phone:

                    <?= htmlspecialchars(
                        $order['phone']
                        ?? ''
                    ); ?>

                    <br>

                    Email:

                    <?= htmlspecialchars(
                        $order['email']
                        ?? ''
                    ); ?>

                </div>


            </div>


        </div>



        <!-- ==================================
             RIGHT COLUMN
        =================================== -->

        <div>


            <!-- CUSTOMER -->

            <div class="card">


                <h2>

                    Customer

                </h2>


                <div class="customer-name">

                    <?= htmlspecialchars(
                        $order['customer_name']
                    ); ?>

                </div>


                <div class="customer-info">

                    <strong>Email</strong><br>

                    <?= htmlspecialchars(
                        $order['email']
                    ); ?>


                    <br><br>


                    <strong>Phone</strong><br>

                    <?= htmlspecialchars(
                        $order['phone']
                        ?? 'N/A'
                    ); ?>

                </div>


            </div>



            <!-- UPDATE STATUS -->

            <div class="card">


                <h2>

                    Update Order Status

                </h2>


                <form
                    method="POST"
                    action="orders.php"
                    class="status-form"
                >

                    <input
                        type="hidden"
                        name="order_id"
                        value="<?= $order['id']; ?>"
                    >


                    <select name="status">

                        <?php

                        $statuses = [

                            'Pending',
                            'Confirmed',
                            'Processing',
                            'Shipped',
                            'Out for Delivery',
                            'Delivered',
                            'Cancelled'

                        ];

                        foreach (
                            $statuses
                            as $option
                        ):

                        ?>

                            <option
                                value="<?= $option; ?>"
                                <?= (
                                    strtolower($option)
                                    ===
                                    strtolower($status)
                                )
                                    ? 'selected'
                                    : ''
                                ?>
                            >

                                <?= $option; ?>

                            </option>

                        <?php endforeach; ?>

                    </select>


                    <button
                        type="submit"
                        name="update_status"
                    >

                        Update

                    </button>

                </form>


            </div>


        </div>


    </div>


</div>


</div>


</body>

</html>
