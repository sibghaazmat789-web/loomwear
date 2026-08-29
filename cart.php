<?php

session_start();

include "includes/db.php";

$session_id = session_id();


// ==========================================
// GET CART ITEMS
// ==========================================

$query = mysqli_query(
    $conn,
    "
    SELECT
        cart.*,
        products.product_name,
        products.price,
        products.image,
        products.stock

    FROM cart

    JOIN products
    ON cart.product_id = products.id

    WHERE cart.session_id='$session_id'
    "
);


if (!$query) {

    die(
        "Could not load shopping bag: " .
        mysqli_error($conn)
    );

}


$subtotal = 0;


// ==========================================
// HEADER
// ==========================================

include "includes/header.php";

?>

<div class="cart-page">

    <h1>Shopping Bag</h1>


    <?php if (mysqli_num_rows($query) > 0) { ?>


        <!-- ==========================================
             CART TABLE
        =========================================== -->

        <table class="cart-table">

            <thead>

                <tr>

                    <th>Product</th>

                    <th>Colour</th>

                    <th>Size</th>

                    <th>Quantity</th>

                    <th>Price</th>

                    <th>Total</th>

                    <th></th>

                </tr>

            </thead>


            <tbody>


                <?php

                while (
                    $row = mysqli_fetch_assoc($query)
                ) {


                    $item_total =
                        (float)$row['price']
                        *
                        (int)$row['quantity'];


                    $subtotal += $item_total;

                ?>

                    <tr>


                        <!-- PRODUCT -->

                        <td class="cart-product">

                            <img
                                src="uploads/products/<?= htmlspecialchars($row['image']); ?>"
                                alt="<?= htmlspecialchars($row['product_name']); ?>"
                            >


                            <div>

                                <h3>

                                    <?= htmlspecialchars(
                                        $row['product_name']
                                    ); ?>

                                </h3>

                            </div>

                        </td>


                        <!-- COLOUR -->

                        <td>

                            <?= htmlspecialchars(
                                $row['color']
                            ); ?>

                        </td>


                        <!-- SIZE -->

                        <td>

                            <?= htmlspecialchars(
                                $row['size']
                            ); ?>

                        </td>


                        <!-- QUANTITY -->

                        <td>

                            <form
                                action="update-cart.php"
                                method="POST"
                            >

                                <input
                                    type="hidden"
                                    name="cart_id"
                                    value="<?= (int)$row['id']; ?>"
                                >


                                <input
                                    type="number"
                                    name="quantity"
                                    min="1"
                                    max="<?= (int)$row['stock']; ?>"
                                    value="<?= (int)$row['quantity']; ?>"
                                    onchange="this.form.submit()"
                                >

                            </form>

                        </td>


                        <!-- PRICE -->

                        <td>

                            Rs.
                            <?= number_format(
                                $row['price']
                            ); ?>

                        </td>


                        <!-- ITEM TOTAL -->

                        <td>

                            Rs.
                            <?= number_format(
                                $item_total
                            ); ?>

                        </td>


                        <!-- REMOVE -->

                        <td>

                            <a
                                href="remove-cart.php?id=<?= (int)$row['id']; ?>"
                            >

                                Remove

                            </a>

                        </td>


                    </tr>


                <?php } ?>


            </tbody>

        </table>



        <!-- ==========================================
             SHIPPING CALCULATION
        =========================================== -->

        <?php

        if ($subtotal >= 5000) {

            $shipping = 0;

        }
        elseif ($subtotal >= 3000) {

            $shipping = 150;

        }
        else {

            $shipping = 250;

        }


        // ==========================================
        // GRAND TOTAL
        // ==========================================

        $grand_total =
            $subtotal + $shipping;

        ?>



        <!-- ==========================================
             CART SUMMARY
        =========================================== -->

        <div class="cart-summary">

            <h2>
                Order Summary
            </h2>


            <!-- SUBTOTAL -->

            <p>

                <span>
                    Subtotal
                </span>

                <span>

                    Rs.
                    <?= number_format(
                        $subtotal
                    ); ?>

                </span>

            </p>


            <!-- SHIPPING -->

            <p>

                <span>
                    Shipping
                </span>

                <span>

                    <?php if ($shipping == 0) { ?>

                        FREE

                    <?php } else { ?>

                        Rs.
                        <?= number_format(
                            $shipping
                        ); ?>

                    <?php } ?>

                </span>

            </p>


            <hr>


            <!-- GRAND TOTAL -->

            <h3>

                <span>
                    Total
                </span>

                <span>

                    Rs.
                    <?= number_format(
                        $grand_total
                    ); ?>

                </span>

            </h3>


            <!-- CHECKOUT -->

            <a
                href="checkout.php"
                class="checkout-btn"
            >

                Proceed to Checkout

            </a>

        </div>


    <?php } else { ?>


        <!-- ==========================================
             EMPTY CART
        =========================================== -->

        <h2>
            Your shopping bag is empty.
        </h2>


        <a href="index.php">

            Continue Shopping

        </a>


    <?php } ?>


</div>


<?php

include "includes/footer.php";

?>