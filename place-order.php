<?php

session_start();

require_once "includes/db.php";
require_once "includes/send-order-email.php";


// ==========================================
// CHECK PLACE ORDER BUTTON
// ==========================================

if (!isset($_POST['place_order'])) {

    header("Location: checkout.php");
    exit;

}


// ==========================================
// GET SESSION ID
// ==========================================

$session_id = session_id();


// ==========================================
// GET CUSTOMER INFORMATION
// ==========================================

$customer_name = mysqli_real_escape_string(
    $conn,
    $_POST['customer_name'] ?? ''
);

$email = mysqli_real_escape_string(
    $conn,
    $_POST['email'] ?? ''
);

$phone = mysqli_real_escape_string(
    $conn,
    $_POST['phone'] ?? ''
);

$address = mysqli_real_escape_string(
    $conn,
    $_POST['address'] ?? ''
);

$city = mysqli_real_escape_string(
    $conn,
    $_POST['city'] ?? ''
);

$postal_code = mysqli_real_escape_string(
    $conn,
    $_POST['postal_code'] ?? ''
);


// ==========================================
// PAYMENT METHOD
// ==========================================

$payment_method = mysqli_real_escape_string(
    $conn,
    $_POST['payment_method'] ?? 'Cash On Delivery'
);


// ==========================================
// PAYMENT REFERENCE
// ==========================================

$payment_reference = '';

if (
    isset($_POST['payment_reference'])
    && !empty(trim($_POST['payment_reference']))
) {

    $payment_reference = mysqli_real_escape_string(
        $conn,
        trim($_POST['payment_reference'])
    );

}


// ==========================================
// DETERMINE PURCHASE TYPE
// ==========================================

$isBuyNow = isset($_POST['buy_now'])
    && $_POST['buy_now'] == '1';


// ==========================================
// VARIABLES
// ==========================================

$total = 0;

$shipping = 0;

$grand_total = 0;

$orderItems = [];


// ==========================================
// BUY NOW ORDER
// ==========================================

if ($isBuyNow) {


    // ==========================================
    // CHECK BUY NOW SESSION
    // ==========================================

    if (!isset($_SESSION['buy_now'])) {

        die("Buy Now session expired. Please try again.");

    }


    $buyNow = $_SESSION['buy_now'];


    $product_id = (int)$buyNow['product_id'];

    $quantity = (int)$buyNow['quantity'];

    $size = isset($buyNow['size'])
        ? trim($buyNow['size'])
        : '';

    $color = isset($buyNow['color'])
        ? trim($buyNow['color'])
        : '';


    // ==========================================
    // VALIDATE PRODUCT
    // ==========================================

    if ($product_id <= 0) {

        die("Invalid product.");

    }


    if ($quantity < 1) {

        $quantity = 1;

    }


    // ==========================================
    // GET PRODUCT
    // ==========================================

    $product_query = mysqli_query(

        $conn,

        "SELECT *
         FROM products
         WHERE id='$product_id'
         LIMIT 1"

    );


    if (!$product_query) {

        die(
            "Product query failed: " .
            mysqli_error($conn)
        );

    }


    if (mysqli_num_rows($product_query) == 0) {

        die("Product not found.");

    }


    $product = mysqli_fetch_assoc(
        $product_query
    );


    // ==========================================
    // CHECK STOCK
    // ==========================================

    if ((int)$product['stock'] <= 0) {

        die("This product is out of stock.");

    }


    if ($quantity > (int)$product['stock']) {

        $quantity = (int)$product['stock'];

    }


    // ==========================================
    // CALCULATE BUY NOW SUBTOTAL
    // ==========================================

    $total =
        (float)$product['price']
        *
        $quantity;


    // ==========================================
    // CREATE ORDER ITEM
    // ==========================================

    $orderItems[] = [

        'product_id' => $product_id,

        'quantity' => $quantity,

        'color' => $color,

        'size' => $size

    ];

}


// ==========================================
// NORMAL CART ORDER
// ==========================================

else {


    // ==========================================
    // CHECK CART
    // ==========================================

    $cart_check = mysqli_query(

        $conn,

        "SELECT *
         FROM cart
         WHERE session_id='$session_id'"

    );


    if (!$cart_check) {

        die(
            "Cart error: " .
            mysqli_error($conn)
        );

    }


    if (mysqli_num_rows($cart_check) == 0) {

        echo "

        <script>

            alert('Your cart is empty.');

            window.location='shop.php';

        </script>

        ";

        exit;

    }


    // ==========================================
    // GET CART ITEMS
    // ==========================================

    $cart_query = mysqli_query(

        $conn,

        "SELECT
            cart.*,
            products.price

         FROM cart

         JOIN products
         ON cart.product_id = products.id

         WHERE cart.session_id='$session_id'"

    );


    if (!$cart_query) {

        die(
            "Could not get cart items: " .
            mysqli_error($conn)
        );

    }


    // ==========================================
    // CALCULATE CART SUBTOTAL
    // ==========================================

    while (
        $item = mysqli_fetch_assoc($cart_query)
    ) {


        $product_id =
            (int)$item['product_id'];


        $quantity =
            (int)$item['quantity'];


        if ($quantity < 1) {

            $quantity = 1;

        }


        // ======================================
        // ADD PRODUCT PRICE
        // ======================================

        $total +=
            (float)$item['price']
            *
            $quantity;


        // ======================================
        // COLOR
        // ======================================

        $color = isset($item['color'])
            ? trim($item['color'])
            : '';


        // ======================================
        // SIZE
        // ======================================

        $size = isset($item['size'])
            ? trim($item['size'])
            : '';


        // ======================================
        // CREATE ORDER ITEM
        // ======================================

        $orderItems[] = [

            'product_id' => $product_id,

            'quantity' => $quantity,

            'color' => $color,

            'size' => $size

        ];

    }

}


// ==========================================
// CALCULATE SHIPPING
// ==========================================

if ($total >= 5000) {

    $shipping = 0;

}
elseif ($total >= 3000) {

    $shipping = 150;

}
else {

    $shipping = 250;

}


// ==========================================
// CALCULATE GRAND TOTAL
// ==========================================

$grand_total = $total + $shipping;


// ==========================================
// GENERATE ORDER NUMBER
// ==========================================

$order_number =
    'LW-' .
    date('Ymd') .
    '-' .
    strtoupper(substr(uniqid(), -5));


// ==========================================
// INSERT ORDER
// ==========================================

$order_query = mysqli_query(

    $conn,

    "INSERT INTO orders

    (
        order_number,
        customer_name,
        email,
        phone,
        address,
        city,
        postal_code,
        payment_method,
        payment_reference,
        total_amount,
        shipping_amount,
        total,
        session_id,
        status
    )

    VALUES

    (
        '$order_number',
        '$customer_name',
        '$email',
        '$phone',
        '$address',
        '$city',
        '$postal_code',
        '$payment_method',
        '$payment_reference',
        '$total',
        '$shipping',
        '$grand_total',
        '$session_id',
        'Pending'
    )"

);


if (!$order_query) {

    die(

        "Order could not be created: " .
        mysqli_error($conn)

    );

}


// ==========================================
// GET ORDER ID
// ==========================================

$order_id = mysqli_insert_id($conn);


// ==========================================
// INSERT ORDER ITEMS
// ==========================================

foreach ($orderItems as $item) {


    $product_id =
        (int)$item['product_id'];


    $quantity =
        (int)$item['quantity'];


    $color = mysqli_real_escape_string(

        $conn,

        $item['color']

    );


    $size = mysqli_real_escape_string(

        $conn,

        $item['size']

    );


    // ======================================
    // INSERT ORDER ITEM
    // ======================================

    $item_query = mysqli_query(

        $conn,

        "INSERT INTO order_items

        (
            order_id,
            product_id,
            color,
            size,
            quantity
        )

        VALUES

        (
            '$order_id',
            '$product_id',
            '$color',
            '$size',
            '$quantity'
        )"

    );


    if (!$item_query) {

        die(

            "Could not save order item: " .
            mysqli_error($conn)

        );

    }

}


// ==========================================
// GET COMPLETE ORDER
// ==========================================

$order_result = mysqli_query(

    $conn,

    "SELECT *
     FROM orders
     WHERE id='$order_id'
     LIMIT 1"

);


if (!$order_result) {

    die(

        "Could not retrieve order: " .
        mysqli_error($conn)

    );

}


$order = mysqli_fetch_assoc(
    $order_result
);


// ==========================================
// GET ORDER ITEMS FOR EMAIL
// ==========================================

$items = [];


$items_result = mysqli_query(

    $conn,

    "SELECT

        oi.*,

        p.product_name,

        p.price

     FROM order_items oi

     LEFT JOIN products p
     ON oi.product_id = p.id

     WHERE oi.order_id='$order_id'"

);


if (!$items_result) {

    die(

        "Could not retrieve order items: " .
        mysqli_error($conn)

    );

}


while (
    $item = mysqli_fetch_assoc($items_result)
) {

    $items[] = $item;

}


// ==========================================
// SEND ORDER EMAILS
// ==========================================

sendOrderEmails(

    $order,
    $items

);


// ==========================================
// CLEAR NORMAL CART
// ==========================================

mysqli_query(

    $conn,

    "DELETE FROM cart
     WHERE session_id='$session_id'"

);


// ==========================================
// CLEAR BUY NOW SESSION
// ==========================================

unset($_SESSION['buy_now']);


// ==========================================
// ORDER SUCCESS
// ==========================================

echo "

<script>

    alert(
        'Order placed successfully! Your order number is #$order_number'
    );

    window.location='order-success.php?order=$order_number';

</script>

";

exit;

?>