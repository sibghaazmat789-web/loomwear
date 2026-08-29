<?php

session_start();

include "includes/db.php";


if (isset($_POST['add_to_cart'])) {

    // ==========================================
    // GET SESSION ID
    // ==========================================

    $session_id = session_id();


    // ==========================================
    // GET PRODUCT DATA
    // ==========================================

    $product_id = isset($_POST['product_id'])
        ? (int)$_POST['product_id']
        : 0;

    $color = isset($_POST['selectedColor'])
        ? mysqli_real_escape_string(
            $conn,
            trim($_POST['selectedColor'])
        )
        : '';

    $size = isset($_POST['selectedSize'])
        ? mysqli_real_escape_string(
            $conn,
            trim($_POST['selectedSize'])
        )
        : '';

    $quantity = isset($_POST['quantity'])
        ? (int)$_POST['quantity']
        : 1;


    // ==========================================
    // VALIDATE QUANTITY
    // ==========================================

    if ($quantity < 1) {

        $quantity = 1;

    }


    // ==========================================
    // VALIDATE PRODUCT
    // ==========================================

    if ($product_id <= 0) {

        die("Invalid product.");

    }


    // ==========================================
    // CHECK SIZE AND COLOR
    // ==========================================

    if (empty($color) || empty($size)) {

        echo "

        <script>

            alert('Please select a colour and size.');

            history.back();

        </script>

        ";

        exit();

    }


    // ==========================================
    // CHECK PRODUCT STOCK
    // ==========================================

    $product_query = mysqli_query(

        $conn,

        "SELECT stock
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


    if ((int)$product['stock'] <= 0) {

        die("This product is out of stock.");

    }


    if ($quantity > (int)$product['stock']) {

        $quantity = (int)$product['stock'];

    }


    // ==========================================
    // ADD TO CART
    // ==========================================

    $check = mysqli_query(

        $conn,

        "SELECT *
         FROM cart
         WHERE session_id='$session_id'
         AND product_id='$product_id'
         AND color='$color'
         AND size='$size'"

    );


    if (!$check) {

        die(
            "Cart check failed: " .
            mysqli_error($conn)
        );

    }


    if (mysqli_num_rows($check) > 0) {


        // ======================================
        // PRODUCT ALREADY IN CART
        // ======================================

        $update = mysqli_query(

            $conn,

            "UPDATE cart

             SET quantity = quantity + $quantity

             WHERE session_id='$session_id'

             AND product_id='$product_id'

             AND color='$color'

             AND size='$size'"

        );


        if (!$update) {

            die(
                "Could not update cart: " .
                mysqli_error($conn)
            );

        }

    }

    else {


        // ======================================
        // NEW CART ITEM
        // ======================================

        $insert = mysqli_query(

            $conn,

            "INSERT INTO cart

            (
                session_id,
                product_id,
                color,
                size,
                quantity
            )

            VALUES

            (
                '$session_id',
                '$product_id',
                '$color',
                '$size',
                '$quantity'
            )"

        );


        if (!$insert) {

            die(
                "Could not add product to cart: " .
                mysqli_error($conn)
            );

        }

    }


    // ==========================================
    // CLEAR OLD BUY NOW SESSION
    // ==========================================

    unset($_SESSION['buy_now']);


    // ==========================================
    // GO TO CART
    // ==========================================

    header("Location: cart.php");

    exit();

}


header("Location: index.php");

exit();

?>