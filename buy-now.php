<?php

session_start();

include "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$product_id = isset($_POST['product_id'])
    ? (int)$_POST['product_id']
    : 0;

$size = isset($_POST['selectedSize'])
    ? trim($_POST['selectedSize'])
    : '';

$color = isset($_POST['selectedColor'])
    ? trim($_POST['selectedColor'])
    : '';

$quantity = isset($_POST['quantity'])
    ? (int)$_POST['quantity']
    : 1;

if ($product_id <= 0) {
    die("Product not found.");
}

if ($quantity < 1) {
    $quantity = 1;
}

/* Get product */

$query = mysqli_query(
    $conn,
    "SELECT * FROM products WHERE id = $product_id LIMIT 1"
);

if (!$query || mysqli_num_rows($query) == 0) {
    die("Product not found.");
}

$product = mysqli_fetch_assoc($query);

/* Check stock */

if ((int)$product['stock'] <= 0) {
    die("This product is out of stock.");
}

if ($quantity > (int)$product['stock']) {
    $quantity = (int)$product['stock'];
}

/* Save Buy Now item */

$_SESSION['buy_now'] = [
    'product_id' => $product_id,
    'quantity'   => $quantity,
    'size'       => $size,
    'color'      => $color
];

/* Go to checkout as BUY NOW */

header("Location: checkout.php?buy_now=1");
exit();

?>