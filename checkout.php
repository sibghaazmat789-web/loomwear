<?php

session_start();

include "includes/db.php";

include "includes/header.php";


$session = session_id();

$total = 0;

$shipping = 0;

$grand_total = 0;


/*
|--------------------------------------------------------------------------
| CHECK BUY NOW
|--------------------------------------------------------------------------
|
| Buy Now is only active when checkout.php?buy_now=1
|
*/

$isBuyNow =
    isset($_SESSION['buy_now']) &&
    isset($_GET['buy_now']) &&
    $_GET['buy_now'] == '1';


$buyNowProduct = null;


/*
|--------------------------------------------------------------------------
| BUY NOW
|--------------------------------------------------------------------------
*/

if ($isBuyNow) {

    $buyNow = $_SESSION['buy_now'];

    $product_id = (int)$buyNow['product_id'];

    $quantity = (int)$buyNow['quantity'];

    $size = $buyNow['size'] ?? '';

    $color = $buyNow['color'] ?? '';


    if ($quantity < 1) {

        $quantity = 1;

    }


    /*
    |--------------------------------------------------------------------------
    | GET BUY NOW PRODUCT
    |--------------------------------------------------------------------------
    */

    $buyQuery = mysqli_query(

        $conn,

        "SELECT *
         FROM products
         WHERE id='$product_id'
         LIMIT 1"

    );


    if (!$buyQuery) {

        die(
            "Could not get product: " .
            mysqli_error($conn)
        );

    }


    if (mysqli_num_rows($buyQuery) == 0) {

        unset($_SESSION['buy_now']);

        die("Product not found.");

    }


    $buyNowProduct = mysqli_fetch_assoc(
        $buyQuery
    );


    /*
    |--------------------------------------------------------------------------
    | CHECK STOCK
    |--------------------------------------------------------------------------
    */

    if ((int)$buyNowProduct['stock'] <= 0) {

        unset($_SESSION['buy_now']);

        die("This product is out of stock.");

    }


    if ($quantity > (int)$buyNowProduct['stock']) {

        $quantity = (int)$buyNowProduct['stock'];

    }


    /*
    |--------------------------------------------------------------------------
    | CALCULATE BUY NOW SUBTOTAL
    |--------------------------------------------------------------------------
    */

    $itemTotal =
        (float)$buyNowProduct['price']
        *
        $quantity;


    $total = $itemTotal;

}


/*
|--------------------------------------------------------------------------
| NORMAL SHOPPING CART
|--------------------------------------------------------------------------
*/

else {

    $query = mysqli_query(

        $conn,

        "SELECT

            cart.*,

            products.product_name,

            products.price,

            products.image

         FROM cart

         JOIN products

         ON cart.product_id = products.id

         WHERE cart.session_id='$session'"

    );


    if (!$query) {

        die(
            "Could not get cart items: " .
            mysqli_error($conn)
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CALCULATE CART SUBTOTAL
    |--------------------------------------------------------------------------
    */

    while (
        $row = mysqli_fetch_assoc($query)
    ) {

        $itemTotal =
            (float)$row['price']
            *
            (int)$row['quantity'];


        $total += $itemTotal;

    }

}


/*
|--------------------------------------------------------------------------
| CALCULATE SHIPPING
|--------------------------------------------------------------------------
|
| Below Rs. 3,000  = Rs. 250
| Rs. 3,000-4,999  = Rs. 150
| Rs. 5,000+       = FREE
|
*/

if ($total >= 5000) {

    $shipping = 0;

}
elseif ($total >= 3000) {

    $shipping = 150;

}
else {

    $shipping = 250;

}


/*
|--------------------------------------------------------------------------
| CALCULATE GRAND TOTAL
|--------------------------------------------------------------------------
*/

$grand_total = $total + $shipping;

?>



<div class="checkout-page">


    <!-- ==========================================
         LEFT SIDE
    =========================================== -->

    <div class="checkout-left">

        <h2>Shipping Details</h2>


        <form
            action="place-order.php"
            method="POST"
        >


            <!-- CUSTOMER NAME -->

            <input
                type="text"
                name="customer_name"
                placeholder="Full Name"
                required
            >


            <!-- EMAIL -->

            <input
                type="email"
                name="email"
                placeholder="Email Address"
                required
            >


            <!-- PHONE -->

            <input
                type="text"
                name="phone"
                placeholder="Phone Number"
                required
            >


            <!-- ADDRESS -->

            <textarea
                name="address"
                placeholder="Complete Address"
                required
            ></textarea>


            <!-- CITY -->

            <input
                type="text"
                name="city"
                placeholder="City"
                required
            >


            <!-- POSTAL CODE -->

            <input
                type="text"
                name="postal_code"
                placeholder="Postal Code"
                required
            >


            <!-- SESSION ID -->

            <input
                type="hidden"
                name="session_id"
                value="<?= htmlspecialchars(session_id()); ?>"
            >


            <!-- ======================================
                 BUY NOW FLAG
            ======================================= -->

            <?php if ($isBuyNow) { ?>

                <input
                    type="hidden"
                    name="buy_now"
                    value="1"
                >

                <input
                    type="hidden"
                    name="buy_now_product"
                    value="<?= $product_id; ?>"
                >

            <?php } ?>


            <!-- ======================================
                 PAYMENT METHODS
            ======================================= -->

            <div class="payment-section">

                <h3>Payment Method</h3>


                <!-- CASH ON DELIVERY -->

                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment_method"
                        value="Cash On Delivery"
                        checked
                        onchange="showPaymentDetails('cod')"
                    >

                    <span>

                        <strong>
                            Cash on Delivery
                        </strong>

                        <small>
                            Pay when your order is delivered.
                        </small>

                    </span>

                </label>


                <!-- JAZZCASH -->

                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment_method"
                        value="JazzCash"
                        onchange="showPaymentDetails('jazzcash')"
                    >

                    <span>

                        <strong>
                            JazzCash
                        </strong>

                        <small>
                            Pay using your JazzCash account.
                        </small>

                    </span>

                </label>


                <!-- EASYPAISA -->

                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment_method"
                        value="EasyPaisa"
                        onchange="showPaymentDetails('easypaisa')"
                    >

                    <span>

                        <strong>
                            EasyPaisa
                        </strong>

                        <small>
                            Pay using your EasyPaisa account.
                        </small>

                    </span>

                </label>


                <!-- BANK TRANSFER -->

                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment_method"
                        value="Bank Transfer"
                        onchange="showPaymentDetails('bank')"
                    >

                    <span>

                        <strong>
                            Bank Transfer
                        </strong>

                        <small>
                            Transfer payment directly to our bank account.
                        </small>

                    </span>

                </label>


                <!-- ==================================
                     COD DETAILS
                =================================== -->

                <div
                    id="cod-details"
                    class="payment-details"
                >

                    <h4>
                        Cash on Delivery
                    </h4>

                    <p>
                        Pay the complete amount when your order arrives.
                    </p>

                </div>


                <!-- ==================================
                     JAZZCASH DETAILS
                =================================== -->

                <div
                    id="jazzcash-details"
                    class="payment-details"
                    style="display:none;"
                >

                    <h4>
                        JazzCash Payment
                    </h4>

                    <p>
                        Send your payment to:
                    </p>

                    <p>

                        <strong>
                            JazzCash Number: 03XX-XXXXXXX
                        </strong>

                    </p>

                    <p>
                        Enter your transaction ID below.
                    </p>

                    <label>
                        Transaction ID
                    </label>

                    <input
                        type="text"
                        name="payment_reference"
                        id="payment_reference_jazzcash"
                        placeholder="Enter JazzCash Transaction ID"
                        disabled
                    >

                </div>


                <!-- ==================================
                     EASYPAISA DETAILS
                =================================== -->

                <div
                    id="easypaisa-details"
                    class="payment-details"
                    style="display:none;"
                >

                    <h4>
                        EasyPaisa Payment
                    </h4>

                    <p>
                        Send your payment to:
                    </p>

                    <p>

                        <strong>
                            EasyPaisa Number: 03XX-XXXXXXX
                        </strong>

                    </p>

                    <p>
                        Enter your transaction ID below.
                    </p>

                    <label>
                        Transaction ID
                    </label>

                    <input
                        type="text"
                        name="payment_reference"
                        id="payment_reference_easypaisa"
                        placeholder="Enter EasyPaisa Transaction ID"
                        disabled
                    >

                </div>


                <!-- ==================================
                     BANK TRANSFER
                =================================== -->

                <div
                    id="bank-details"
                    class="payment-details"
                    style="display:none;"
                >

                    <h4>
                        Bank Transfer
                    </h4>

                    <p>
                        Bank:
                        <strong>
                            Your Bank Name
                        </strong>
                    </p>

                    <p>
                        Account Title:
                        <strong>
                            LoomWear
                        </strong>
                    </p>

                    <p>
                        Account Number:
                        <strong>
                            XXXXXXXXXXXX
                        </strong>
                    </p>

                    <p>
                        IBAN:
                        <strong>
                            PKXX XXXX XXXX XXXX XXXX
                        </strong>
                    </p>

                    <label>
                        Transaction / Reference Number
                    </label>

                    <input
                        type="text"
                        name="payment_reference"
                        id="payment_reference_bank"
                        placeholder="Enter transaction/reference number"
                        disabled
                    >

                </div>

            </div>


            <!-- ======================================
                 PLACE ORDER
            ======================================= -->

            <button
                type="submit"
                name="place_order"
                class="place-order"
            >

                Place Order

            </button>


        </form>

    </div>



    <!-- ==========================================
         RIGHT SIDE
    =========================================== -->

    <div class="checkout-right">

        <h2>
            Order Summary
        </h2>


        <?php if ($isBuyNow) { ?>


            <!-- ==================================
                 BUY NOW PRODUCT
            =================================== -->

            <div class="summary-item">


                <img
                    src="uploads/products/<?= htmlspecialchars($buyNowProduct['image']); ?>"
                    alt="<?= htmlspecialchars($buyNowProduct['product_name']); ?>"
                >


                <div>

                    <h4>
                        <?= htmlspecialchars(
                            $buyNowProduct['product_name']
                        ); ?>
                    </h4>


                    <p>

                        Colour:

                        <?= htmlspecialchars(
                            $color ?: 'Not selected'
                        ); ?>

                    </p>


                    <p>

                        Size:

                        <?= htmlspecialchars(
                            $size ?: 'Not selected'
                        ); ?>

                    </p>


                    <p>

                        Qty:

                        <?= $quantity; ?>

                    </p>

                </div>


                <span>

                    Rs.
                    <?= number_format($itemTotal); ?>

                </span>


            </div>


        <?php } else { ?>


            <!-- ==================================
                 NORMAL CART
            =================================== -->

            <?php

            /*
            |----------------------------------------------------------
            | Run the cart query AGAIN because the previous while loop
            | already consumed its result.
            |----------------------------------------------------------
            */

            $summary_query = mysqli_query(

                $conn,

                "SELECT

                    cart.*,

                    products.product_name,

                    products.price,

                    products.image

                 FROM cart

                 JOIN products

                 ON cart.product_id = products.id

                 WHERE cart.session_id='$session'"

            );


            if (!$summary_query) {

                die(
                    "Could not load order summary: " .
                    mysqli_error($conn)
                );

            }


            if (mysqli_num_rows($summary_query) == 0) {

            ?>

                <p class="empty-checkout">

                    Your cart is empty.

                </p>

            <?php

            }


            while (
                $row = mysqli_fetch_assoc($summary_query)
            ) {

                $itemTotal =
                    (float)$row['price']
                    *
                    (int)$row['quantity'];

            ?>

                <div class="summary-item">


                    <img
                        src="uploads/products/<?= htmlspecialchars($row['image']); ?>"
                        alt="<?= htmlspecialchars($row['product_name']); ?>"
                    >


                    <div>


                        <h4>

                            <?= htmlspecialchars(
                                $row['product_name']
                            ); ?>

                        </h4>


                        <p>

                            Colour:

                            <?= !empty($row['color'])
                                ? htmlspecialchars($row['color'])
                                : 'Not selected'; ?>

                        </p>


                        <p>

                            Size:

                            <?= !empty($row['size'])
                                ? htmlspecialchars($row['size'])
                                : 'Not selected'; ?>

                        </p>


                        <p>

                            Qty:

                            <?= (int)$row['quantity']; ?>

                        </p>


                    </div>


                    <span>

                        Rs.
                        <?= number_format($itemTotal); ?>

                    </span>


                </div>

            <?php } ?>


        <?php } ?>


        <!-- ======================================
             TOTALS
        ======================================= -->

        <hr>


        <div class="checkout-totals">


            <!-- SUBTOTAL -->

            <div class="total-row">

                <span>
                    Subtotal
                </span>

                <strong>

                    Rs.
                    <?= number_format($total); ?>

                </strong>

            </div>


            <!-- SHIPPING -->

            <div class="total-row">

                <span>
                    Shipping
                </span>

                <strong>

                    <?php if ($shipping == 0) { ?>

                        FREE

                    <?php } else { ?>

                        Rs.
                        <?= number_format($shipping); ?>

                    <?php } ?>

                </strong>

            </div>


            <!-- GRAND TOTAL -->

            <div class="total-row grand-total">

                <span>
                    Total
                </span>

                <strong>

                    Rs.
                    <?= number_format($grand_total); ?>

                </strong>

            </div>


        </div>


    </div>

</div>



<!-- ==========================================
     PAYMENT JAVASCRIPT
=========================================== -->

<script>

function showPaymentDetails(method) {

    document.getElementById('cod-details').style.display = 'none';

    document.getElementById('jazzcash-details').style.display = 'none';

    document.getElementById('easypaisa-details').style.display = 'none';

    document.getElementById('bank-details').style.display = 'none';


    document.getElementById('payment_reference_jazzcash').disabled = true;

    document.getElementById('payment_reference_easypaisa').disabled = true;

    document.getElementById('payment_reference_bank').disabled = true;


    document.getElementById('payment_reference_jazzcash').required = false;

    document.getElementById('payment_reference_easypaisa').required = false;

    document.getElementById('payment_reference_bank').required = false;


    if (method === 'cod') {

        document.getElementById('cod-details').style.display = 'block';

    }


    if (method === 'jazzcash') {

        document.getElementById('jazzcash-details').style.display = 'block';

        document.getElementById('payment_reference_jazzcash').disabled = false;

        document.getElementById('payment_reference_jazzcash').required = true;

    }


    if (method === 'easypaisa') {

        document.getElementById('easypaisa-details').style.display = 'block';

        document.getElementById('payment_reference_easypaisa').disabled = false;

        document.getElementById('payment_reference_easypaisa').required = true;

    }


    if (method === 'bank') {

        document.getElementById('bank-details').style.display = 'block';

        document.getElementById('payment_reference_bank').disabled = false;

        document.getElementById('payment_reference_bank').required = true;

    }

}

</script>



<?php include "includes/footer.php"; ?>