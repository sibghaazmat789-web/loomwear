
<?php

session_start();

include "../includes/db.php";

require_once "../includes/send-order-email.php";
/* ==========================================
   UPDATE ORDER STATUS + SEND EMAIL
========================================== */

if (isset($_POST['update_status'])) {

    $order_id = (int) $_POST['order_id'];

    $new_status = mysqli_real_escape_string(
        $conn,
        trim($_POST['status'])
    );


    $allowed_statuses = [
        'Pending',
        'Confirmed',
        'Processing',
        'Shipped',
        'Out for Delivery',
        'Delivered',
        'Cancelled'
    ];


    if (in_array($new_status, $allowed_statuses)) {


        /* ==========================================
           GET CURRENT ORDER
        ========================================== */

        $orderQuery = mysqli_query(
            $conn,
            "SELECT *
             FROM orders
             WHERE id = $order_id
             LIMIT 1"
        );


        if (
            $orderQuery &&
            mysqli_num_rows($orderQuery) > 0
        ) {

            $order = mysqli_fetch_assoc(
                $orderQuery
            );


            $old_status =
                $order['status'] ?? 'Pending';


            /* ==========================================
               UPDATE STATUS
            ========================================== */

            $update = mysqli_query(
                $conn,
                "UPDATE orders
                 SET status = '$new_status'
                 WHERE id = $order_id"
            );


            if ($update) {


                /* ==========================================
                   ONLY SEND EMAIL IF STATUS CHANGED
                ========================================== */

                if ($old_status !== $new_status) {


                    /* ==========================================
                       GET ORDER ITEMS
                    ========================================== */

                    $items = [];


                    $itemsQuery = mysqli_query(
                        $conn,

                        "SELECT
                            oi.*,
                            p.product_name

                         FROM order_items oi

                         LEFT JOIN products p
                            ON oi.product_id = p.id

                         WHERE oi.order_id = $order_id

                         ORDER BY oi.id ASC"
                    );


                    if ($itemsQuery) {

                        while (
                            $item =
                            mysqli_fetch_assoc(
                                $itemsQuery
                            )
                        ) {

                            $items[] = $item;

                        }

                    }


                    /* ==========================================
                       SEND STATUS EMAIL
                    ========================================== */

$order['status'] = $new_status;

sendOrderStatusEmail($order);

                }

            }

        }

    }

}

/* ==========================================
   GET ORDERS
========================================== */

$query = mysqli_query(
    $conn,
    "SELECT *
     FROM orders
     ORDER BY id DESC"
);


if (!$query) {

    die(
        "Orders query failed: " .
        mysqli_error($conn)
    );

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

<title>Orders | LoomWear Admin</title>


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
   ORDERS PAGE
========================================== */

.orders-page {

    padding: 30px;

}


.page-header {

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

}


.page-header h1 {

    margin:0;

    font-size:28px;

}


.page-header p {

    margin:7px 0 0;

    color:#777;

    font-size:14px;

}


/* ==========================================
   TABLE
========================================== */

.orders-card {

    background:#fff;

    border-radius:10px;

    overflow:hidden;

    box-shadow:
        0 2px 10px rgba(0,0,0,.05);

}


.orders-table {

    width:100%;

    border-collapse:collapse;

}


.orders-table th {

    background:#111;

    color:#fff;

    padding:15px;

    text-align:left;

    font-size:12px;

    text-transform:uppercase;

    letter-spacing:.5px;

}


.orders-table td {

    padding:15px;

    border-bottom:1px solid #eee;

    font-size:13px;

    vertical-align:middle;

}


.orders-table tr:hover {

    background:#fafafa;

}


/* ==========================================
   STATUS
========================================== */

.status-form {

    display:flex;

    gap:7px;

    align-items:center;

}


.status-form select {

    padding:8px 10px;

    border:1px solid #ddd;

    border-radius:5px;

    background:#fff;

    font-size:12px;

}


.status-form button {

    border:0;

    background:#111;

    color:#fff;

    padding:8px 12px;

    border-radius:5px;

    cursor:pointer;

    font-size:11px;

}


.status-form button:hover {

    background:#333;

}


/* ==========================================
   STATUS BADGES
========================================== */

.status-badge {

    display:inline-block;

    padding:6px 10px;

    border-radius:20px;

    font-size:11px;

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
   VIEW BUTTON
========================================== */

.view-order {

    display:inline-block;

    padding:8px 12px;

    background:#f3f3f3;

    color:#111;

    text-decoration:none;

    border-radius:5px;

    font-size:11px;

}


.view-order:hover {

    background:#ddd;

}


/* ==========================================
   EMPTY
========================================== */

.empty-orders {

    text-align:center;

    padding:70px 20px;

    color:#777;

}


.empty-orders i {

    font-size:40px;

    margin-bottom:15px;

    color:#ccc;

}


/* ==========================================
   MOBILE
========================================== */

@media(max-width:900px) {

    .orders-page {

        padding:20px;

    }


    .orders-card {

        overflow-x:auto;

    }


    .orders-table {

        min-width:1000px;

    }

}

</style>

</head>


<body>


<?php include "includes/sidebar.php"; ?>


<div class="main-content">


<?php include "includes/navbar.php"; ?>


<div class="orders-page">


    <!-- HEADER -->

    <div class="page-header">

        <div>

            <h1>

                Orders

            </h1>

            <p>

                Manage LoomWear customer orders

            </p>

        </div>

    </div>



    <!-- ORDERS -->

    <div class="orders-card">


    <?php if (mysqli_num_rows($query) > 0): ?>


        <table class="orders-table">


            <thead>

                <tr>

                    <th>Order</th>

                    <th>Customer</th>

                    <th>Email</th>

                    <th>Total</th>

                    <th>Payment</th>

                    <th>Status</th>

                    <th>Date</th>

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>


            <?php while ($order = mysqli_fetch_assoc($query)): ?>


                <?php

                $status = $order['status'] ?? 'Pending';

                $status_class =
                    strtolower(
                        str_replace(
                            ' ',
                            '-',
                            $status
                        )
                    );

                ?>


                <tr>


                    <!-- ORDER -->

                    <td>

                        <strong>

                            #<?= htmlspecialchars(
                                $order['order_number']
                                ?: 'LW-' . $order['id']
                            ); ?>

                        </strong>

                    </td>


                    <!-- CUSTOMER -->

                    <td>

                        <?= htmlspecialchars(
                            $order['customer_name']
                        ); ?>

                    </td>


                    <!-- EMAIL -->

                    <td>

                        <?= htmlspecialchars(
                            $order['email']
                        ); ?>

                    </td>


                    <!-- TOTAL -->

                    <td>

                        <strong>

                            Rs.

                            <?= number_format(
                                (float)(
                                    $order['total_amount']
                                    ?? $order['total']
                                    ?? 0
                                )
                            ); ?>

                        </strong>

                    </td>


                    <!-- PAYMENT -->

                    <td>

                        <?= htmlspecialchars(
                            $order['payment_method']
                            ?? 'N/A'
                        ); ?>

                    </td>


                    <!-- STATUS -->

                    <td>

                        <span
                            class="status-badge
                            status-<?= $status_class; ?>"
                        >

                            <?= htmlspecialchars(
                                $status
                            ); ?>

                        </span>


                        <form
                            method="POST"
                            class="status-form"
                            style="margin-top:7px;"
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

                                foreach ($statuses as $option):

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

                    </td>


                    <!-- DATE -->

                    <td>

                        <?php

                        if (!empty(
                            $order['created_at']
                        )) {

                            echo date(
                                "M d, Y",
                                strtotime(
                                    $order['created_at']
                                )
                            );

                        }

                        ?>

                    </td>


                    <!-- ACTION -->

                    <td>

                        <a
                            href="order-details.php?id=<?= $order['id']; ?>"
                            class="view-order"
                        >

                            <i class="fa-solid fa-eye"></i>

                            View

                        </a>

                    </td>


                </tr>


            <?php endwhile; ?>


            </tbody>


        </table>


    <?php else: ?>


        <div class="empty-orders">

            <i class="fa-solid fa-cart-shopping"></i>

            <h3>

                No Orders Yet

            </h3>

            <p>

                Customer orders will appear here.

            </p>

        </div>


    <?php endif; ?>


    </div>


</div>


</div>


</body>

</html>
