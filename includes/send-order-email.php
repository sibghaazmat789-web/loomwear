<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';

require_once __DIR__ . '/email-config.php';

// ==========================================
// SEND ORDER EMAILS
// ==========================================

function sendOrderEmails($order, $items)
{
    $customerEmail = $order['email'];
    $customerName  = $order['customer_name'];
    $orderNumber   = $order['order_number'];

    $total = number_format(
        (float)$order['total_amount'],
        2
    );


    // ==========================================
    // BUILD PRODUCT ROWS
    // ==========================================

    $productRows = '';

    foreach ($items as $item) {

        $productName = htmlspecialchars(
            $item['product_name']
        );

        $size = !empty($item['size'])
            ? htmlspecialchars($item['size'])
            : 'N/A';

        $color = !empty($item['color'])
            ? htmlspecialchars($item['color'])
            : 'N/A';

        $quantity = (int)$item['quantity'];

        $price = number_format(
            (float)$item['price'],
            2
        );


        $productRows .= "

        <tr>

            <td style='padding:18px 10px;
                       border-bottom:1px solid #eeeeee;'>

                <strong>{$productName}</strong>

                <br>

                <span style='font-size:13px;color:#777;'>
                    Size: {$size}
                    &nbsp; | &nbsp;
                    Color: {$color}
                </span>

            </td>


            <td style='padding:18px 10px;
                       text-align:center;
                       border-bottom:1px solid #eeeeee;'>

                {$quantity}

            </td>


            <td style='padding:18px 10px;
                       text-align:right;
                       border-bottom:1px solid #eeeeee;'>

                Rs. {$price}

            </td>

        </tr>

        ";
    }


    // ==========================================
    // CUSTOMER EMAIL
    // ==========================================

    $customerMail = new PHPMailer(true);

    try {

        $customerMail->isSMTP();

        $customerMail->Host = MAIL_HOST;

        $customerMail->SMTPAuth = true;

        $customerMail->Username = MAIL_USERNAME;

        $customerMail->Password = MAIL_PASSWORD;

        $customerMail->SMTPSecure =
            PHPMailer::ENCRYPTION_SMTPS;

        $customerMail->Port = 465;


        // Sender
        $customerMail->setFrom(
            MAIL_FROM,
            MAIL_FROM_NAME
        );


        // Customer
        $customerMail->addAddress(
            $customerEmail,
            $customerName
        );


        $customerMail->isHTML(true);


        $customerMail->Subject =
            "Order Confirmed! #{$orderNumber} | LoomWear";


        $customerMail->Body = "

        <!DOCTYPE html>

        <html>

        <body style='margin:0;
                     padding:0;
                     background:#f5f5f5;
                     font-family:Arial,Helvetica,sans-serif;'>

            <div style='max-width:650px;
                        margin:30px auto;
                        background:#ffffff;'>


                <!-- HEADER -->

                <div style='background:#111111;
                            padding:30px;
                            text-align:center;'>

                    <div style='font-size:30px;
                                font-weight:bold;
                                color:#ffffff;'>

                        Loom<span style='font-weight:normal;'>
                            Wear
                        </span>

                    </div>

                </div>


                <!-- CONTENT -->

                <div style='padding:40px;'>


                    <div style='text-align:center;
                                margin-bottom:35px;'>

                        <div style='font-size:45px;'>
                            ✓
                        </div>

                        <h1 style='font-size:26px;
                                   font-weight:600;
                                   margin:10px 0;'>

                            Thank you for your order!

                        </h1>

                        <p style='color:#666;
                                  font-size:14px;
                                  line-height:1.7;'>

                            Hi {$customerName}, we've received your
                            order and we're getting it ready.

                        </p>

                    </div>


                    <!-- ORDER INFO -->

                    <div style='background:#f7f7f7;
                                padding:20px;
                                margin-bottom:30px;'>

                        <table width='100%'>

                            <tr>

                                <td>
                                    <strong>Order Number</strong>
                                </td>

                                <td style='text-align:right;'>
                                    #{$orderNumber}
                                </td>

                            </tr>


                            <tr>

                                <td style='padding-top:10px;'>
                                    <strong>Status</strong>
                                </td>

                                <td style='text-align:right;
                                           padding-top:10px;'>
                                    Pending
                                </td>

                            </tr>


                            <tr>

                                <td style='padding-top:10px;'>
                                    <strong>Payment</strong>
                                </td>

                                <td style='text-align:right;
                                           padding-top:10px;'>

                                    {$order['payment_method']}

                                </td>

                            </tr>

                        </table>

                    </div>


                    <!-- PRODUCTS -->

                    <h2 style='font-size:18px;
                               margin-bottom:10px;'>

                        Order Summary

                    </h2>


                    <table width='100%'
                           cellspacing='0'
                           cellpadding='0'>

                        <tr>

                            <th style='text-align:left;
                                       padding:10px;
                                       border-bottom:2px solid #111;'>

                                Product

                            </th>

                            <th style='padding:10px;
                                       border-bottom:2px solid #111;'>

                                Qty

                            </th>

                            <th style='text-align:right;
                                       padding:10px;
                                       border-bottom:2px solid #111;'>

                                Price

                            </th>

                        </tr>

                        {$productRows}

                    </table>


                    <!-- TOTAL -->

                    <div style='text-align:right;
                                margin-top:25px;
                                padding-top:20px;
                                border-top:2px solid #111;'>

                        <span style='font-size:14px;
                                     color:#666;'>

                            Total

                        </span>

                        <br>

                        <strong style='font-size:24px;'>

                            Rs. {$total}

                        </strong>

                    </div>


                    <!-- SHIPPING -->

                    <div style='margin-top:35px;'>

                        <h2 style='font-size:18px;'>
                            Shipping Address
                        </h2>

                        <p style='font-size:14px;
                                  color:#666;
                                  line-height:1.8;'>

                            {$order['customer_name']}<br>

                            {$order['address']}<br>

                            {$order['city']} -
                            {$order['postal_code']}<br>

                            Phone: {$order['phone']}

                        </p>

                    </div>


                    <!-- CTA -->

                    <div style='text-align:center;
                                margin-top:35px;'>

                        <a href='http://localhost/loomwear/index.php'

                           style='display:inline-block;
                                  background:#111111;
                                  color:#ffffff;
                                  padding:15px 30px;
                                  text-decoration:none;
                                  font-size:13px;'>

                            Continue Shopping

                        </a>

                    </div>


                </div>


                <!-- FOOTER -->

                <div style='background:#f5f5f5;
                            padding:25px;
                            text-align:center;'>

                    <p style='font-size:12px;
                              color:#777;
                              margin:0;'>

                        Thank you for shopping with LoomWear.

                    </p>

                    <p style='font-size:12px;
                              color:#999;'>

                        If you have any questions,
                        please contact our support team.

                    </p>

                    <p style='font-size:11px;
                              color:#aaa;'>

                        © 2026 LoomWear. All Rights Reserved.

                    </p>

                </div>


            </div>

        </body>

        </html>

        ";


        $customerMail->AltBody =
            "Thank you for your order, {$customerName}!

            Order Number: #{$orderNumber}

            Total: Rs. {$total}

            Your LoomWear order has been received
            and is currently being processed.";


        $customerMail->send();


    } catch (Exception $e) {

        error_log(
            "Customer email error: " .
            $customerMail->ErrorInfo
        );

    }


    // ==========================================
    // ADMIN EMAIL
    // ==========================================

    $adminMail = new PHPMailer(true);

    try {

        $adminMail->isSMTP();

        $adminMail->Host = MAIL_HOST;

        $adminMail->SMTPAuth = true;

        $adminMail->Username = MAIL_USERNAME;

        $adminMail->Password = MAIL_PASSWORD;

        $adminMail->SMTPSecure =
            PHPMailer::ENCRYPTION_SMTPS;

        $adminMail->Port = 465;


        // Sender
        $adminMail->setFrom(
            MAIL_FROM,
            'LoomWear Orders'
        );


        // Admin
        $adminMail->addAddress(
            ADMIN_EMAIL,
            ADMIN_NAME
        );


        // Customer email as reply-to
        $adminMail->addReplyTo(
            $customerEmail,
            $customerName
        );


        $adminMail->isHTML(true);


        $adminMail->Subject =
            "🛍️ New LoomWear Order #{$orderNumber}";


        $adminMail->Body = "

        <!DOCTYPE html>

        <html>

        <body style='margin:0;
                     padding:30px;
                     background:#f5f5f5;
                     font-family:Arial,Helvetica,sans-serif;'>


            <div style='max-width:700px;
                        margin:auto;
                        background:white;
                        padding:35px;'>


                <h1 style='margin-top:0;'>
                    New Order Received
                </h1>


                <p style='color:#666;'>
                    A new order has been placed on LoomWear.
                </p>


                <div style='background:#111;
                            color:white;
                            padding:20px;
                            margin:25px 0;'>

                    <strong style='font-size:20px;'>

                        Order #{$orderNumber}

                    </strong>

                    <br><br>

                    Total:
                    <strong>
                        Rs. {$total}
                    </strong>

                </div>


                <h2>Customer Information</h2>

                <table width='100%' cellpadding='8'>

                    <tr>
                        <td><strong>Name</strong></td>
                        <td>{$customerName}</td>
                    </tr>

                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{$customerEmail}</td>
                    </tr>

                    <tr>
                        <td><strong>Phone</strong></td>
                        <td>{$order['phone']}</td>
                    </tr>

                    <tr>
                        <td><strong>Address</strong></td>
                        <td>{$order['address']}</td>
                    </tr>

                    <tr>
                        <td><strong>City</strong></td>
                        <td>{$order['city']}</td>
                    </tr>

                    <tr>
                        <td><strong>Postal Code</strong></td>
                        <td>{$order['postal_code']}</td>
                    </tr>

                    <tr>
                        <td><strong>Payment</strong></td>
                        <td>{$order['payment_method']}</td>
                    </tr>

                </table>


                <h2 style='margin-top:35px;'>
                    Products
                </h2>


                <table width='100%'
                       cellspacing='0'
                       cellpadding='10'
                       style='border-collapse:collapse;'>

                    <tr style='background:#f5f5f5;'>

                        <th style='text-align:left;'>
                            Product
                        </th>

                        <th>
                            Qty
                        </th>

                        <th style='text-align:right;'>
                            Price
                        </th>

                    </tr>

                    {$productRows}

                </table>


                <div style='text-align:right;
                            margin-top:25px;
                            font-size:22px;'>

                    <strong>
                        Total: Rs. {$total}
                    </strong>

                </div>


            </div>

        </body>

        </html>

        ";


        $adminMail->AltBody =
            "New LoomWear Order #{$orderNumber}

            Customer: {$customerName}
            Email: {$customerEmail}
            Phone: {$order['phone']}
            Total: Rs. {$total}";


        $adminMail->send();


    } catch (Exception $e) {

        error_log(
            "Admin email error: " .
            $adminMail->ErrorInfo
        );

    }

}
// ==========================================
// SEND ORDER STATUS UPDATE EMAIL
// ==========================================

function sendOrderStatusEmail($order)
{
    $customerEmail = $order['email'];
    $customerName  = $order['customer_name'];
    $orderNumber   = $order['order_number'];

    $status = strtolower(
        trim($order['status'] ?? 'pending')
    );

    $status = str_replace(
        '_',
        ' ',
        $status
    );


    // ==========================================
    // STATUS INFORMATION
    // ==========================================

    $statusData = [

        'pending' => [
            'title' => 'Order Received',
            'message' =>
                'We have received your order and it is waiting to be processed.'
        ],

        'confirmed' => [
            'title' => 'Order Confirmed',
            'message' =>
                'Great news! Your LoomWear order has been confirmed and will be prepared shortly.'
        ],

        'processing' => [
            'title' => 'Order Being Prepared',
            'message' =>
                'Your LoomWear order is now being prepared for shipment.'
        ],

        'shipped' => [
            'title' => 'Your Order Has Shipped',
            'message' =>
                'Your order has been shipped and is now on its way to you.'
        ],

        'out for delivery' => [
            'title' => 'Out for Delivery',
            'message' =>
                'Your order is out for delivery. Please keep your phone available for the courier.'
        ],

        'delivered' => [
            'title' => 'Order Delivered',
            'message' =>
                'Your LoomWear order has been delivered successfully. We hope you love your purchase!'
        ],

        'cancelled' => [
            'title' => 'Order Cancelled',
            'message' =>
                'Unfortunately, your LoomWear order has been cancelled.'
        ]

    ];


    if (isset($statusData[$status])) {

        $statusTitle =
            $statusData[$status]['title'];

        $statusMessage =
            $statusData[$status]['message'];

    } else {

        $statusTitle =
            ucwords($status);

        $statusMessage =
            'Your LoomWear order status has been updated.';

    }


    $displayStatus =
        ucwords($status);


    // ==========================================
    // TOTAL
    // ==========================================

    $total = number_format(
        (float)($order['total_amount'] ?? 0),
        2
    );


    // ==========================================
    // CREATE MAIL
    // ==========================================

    $mail = new PHPMailer(true);


    try {

        // ==========================================
        // SMTP
        // ==========================================

        $mail->isSMTP();

        $mail->Host = MAIL_HOST;

        $mail->SMTPAuth = true;

        $mail->Username = MAIL_USERNAME;

        $mail->Password = MAIL_PASSWORD;

        $mail->SMTPSecure =
            PHPMailer::ENCRYPTION_SMTPS;

        $mail->Port = 465;


        // ==========================================
        // SENDER
        // ==========================================

        $mail->setFrom(
            MAIL_FROM,
            MAIL_FROM_NAME
        );


        // ==========================================
        // CUSTOMER
        // ==========================================

        $mail->addAddress(
            $customerEmail,
            $customerName
        );


        $mail->isHTML(true);


        // ==========================================
        // SUBJECT
        // ==========================================

        $mail->Subject =
            "{$statusTitle} | Order #{$orderNumber} | LoomWear";


        // ==========================================
        // EMAIL BODY
        // ==========================================

        $mail->Body = "

        <!DOCTYPE html>

        <html>

        <body style='
            margin:0;
            padding:0;
            background:#f5f5f5;
            font-family:Arial,Helvetica,sans-serif;
            color:#111;
        '>


            <div style='
                max-width:650px;
                margin:30px auto;
                background:#ffffff;
            '>


                <!-- HEADER -->

                <div style='
                    background:#111111;
                    padding:30px;
                    text-align:center;
                '>

                    <div style='
                        font-size:30px;
                        font-weight:bold;
                        color:#ffffff;
                        letter-spacing:4px;
                    '>

                        LOOMWEAR

                    </div>

                </div>


                <!-- CONTENT -->

                <div style='
                    padding:40px;
                '>


                    <div style='
                        text-align:center;
                        margin-bottom:30px;
                    '>

                        <div style='
                            font-size:42px;
                            margin-bottom:10px;
                        '>

                            ✓

                        </div>


                        <h1 style='
                            font-size:26px;
                            font-weight:500;
                            margin:10px 0;
                        '>

                            {$statusTitle}

                        </h1>


                        <p style='
                            color:#666;
                            font-size:14px;
                            line-height:1.7;
                        '>

                            Hi " .
                            htmlspecialchars($customerName) .
                            ",

                        </p>


                        <p style='
                            color:#666;
                            font-size:14px;
                            line-height:1.7;
                        '>

                            " .
                            htmlspecialchars($statusMessage) .
                            "

                        </p>

                    </div>


                    <!-- ORDER DETAILS -->

                    <div style='
                        background:#f7f7f7;
                        padding:25px;
                        margin:30px 0;
                    '>


                        <h2 style='
                            font-size:17px;
                            margin:0 0 20px;
                        '>

                            Order Details

                        </h2>


                        <table width='100%'>

                            <tr>

                                <td style='
                                    padding:8px 0;
                                    color:#777;
                                '>

                                    Order Number

                                </td>


                                <td style='
                                    padding:8px 0;
                                    text-align:right;
                                    font-weight:bold;
                                '>

                                    #{$orderNumber}

                                </td>

                            </tr>


                            <tr>

                                <td style='
                                    padding:8px 0;
                                    color:#777;
                                '>

                                    Status

                                </td>


                                <td style='
                                    padding:8px 0;
                                    text-align:right;
                                    font-weight:bold;
                                '>

                                    {$displayStatus}

                                </td>

                            </tr>


                            <tr>

                                <td style='
                                    padding:8px 0;
                                    color:#777;
                                '>

                                    Total

                                </td>


                                <td style='
                                    padding:8px 0;
                                    text-align:right;
                                    font-weight:bold;
                                '>

                                    Rs. {$total}

                                </td>

                            </tr>

                        </table>

                    </div>


                    <!-- TRACK ORDER -->

                    <div style='
                        text-align:center;
                        margin:35px 0;
                    '>

                        <a
                            href='http://localhost/loomwear/account/my-orders.php'

                            style='
                                display:inline-block;
                                background:#111111;
                                color:#ffffff;
                                padding:15px 30px;
                                text-decoration:none;
                                font-size:13px;
                                letter-spacing:1px;
                            '
                        >

                            VIEW MY ORDERS

                        </a>

                    </div>


                    <p style='
                        color:#777;
                        font-size:13px;
                        line-height:1.7;
                    '>

                        Thank you for shopping with LoomWear.

                        We appreciate your business.

                    </p>


                    <p style='
                        font-size:13px;
                    '>

                        — LoomWear Team

                    </p>


                </div>


                <!-- FOOTER -->

                <div style='
                    background:#f5f5f5;
                    padding:25px;
                    text-align:center;
                '>

                    <p style='
                        color:#777;
                        font-size:12px;
                        margin:0;
                    '>

                        © 2026 LoomWear.
                        All Rights Reserved.

                    </p>

                </div>


            </div>

        </body>

        </html>

        ";


        // ==========================================
        // PLAIN TEXT VERSION
        // ==========================================

        $mail->AltBody =
            "Hi {$customerName},

            Your LoomWear order #{$orderNumber}
            has been updated.

            Status: {$displayStatus}

            {$statusMessage}

            Total: Rs. {$total}

            Thank you for shopping with LoomWear.";


        // ==========================================
        // SEND
        // ==========================================

        $mail->send();


        return true;


    } catch (Exception $e) {

        error_log(
            "Order status email error: " .
            $mail->ErrorInfo
        );

        return false;

    }

}



?>