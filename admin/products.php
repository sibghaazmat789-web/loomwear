<?php

include "../includes/db.php";


/* =====================================================
   GET ALL PRODUCTS
===================================================== */

$query = "SELECT * FROM products ORDER BY id DESC";

$result = mysqli_query($conn, $query);


if (!$result) {

    die("SQL Error: " . mysqli_error($conn));

}

?>


<?php include "includes/header.php"; ?>

<?php include "includes/sidebar.php"; ?>


<div class="main">


<?php include "includes/navbar.php"; ?>


<div class="content">


<!-- =====================================================
     PAGE HEADER
===================================================== -->

<div class="page-header">

    <h1>
        Products
    </h1>


    <a
        href="add-product.php"
        class="btn-primary"
    >

        <i class="fa-solid fa-plus"></i>

        Add Product

    </a>

</div>



<!-- =====================================================
     FILTER BAR
===================================================== -->

<div class="filter-bar">


    <input
        type="text"
        placeholder="Search Product..."
    >


    <select>

        <option>
            All Categories
        </option>

        <option>
            Men
        </option>

        <option>
            Women
        </option>

        <option>
            Boys
        </option>

        <option>
            Girls
        </option>

        <option>
            Baby & Toddler
        </option>

    </select>


    <select>

        <option>
            All Badges
        </option>

        <option>
            NEW
        </option>

        <option>
            SALE
        </option>

        <option>
            FEATURED
        </option>

    </select>


</div>



<!-- =====================================================
     PRODUCTS TABLE
===================================================== -->

<table>


<thead>

<tr>

    <th>Image</th>

    <th>Product</th>

    <th>Category</th>

    <th>Price</th>

    <th>Stock</th>

    <th>New Arrival</th>

    <th>Back to School</th>

    <th>School Category</th>

    <th>Actions</th>

</tr>

</thead>



<tbody>


<?php while ($row = mysqli_fetch_assoc($result)) { ?>


<tr>


    <!-- =================================================
         IMAGE
    ================================================== -->

    <td>

        <img
            src="../uploads/products/<?= htmlspecialchars($row['image']); ?>"
            alt="<?= htmlspecialchars($row['product_name']); ?>"
            style="width:70px;height:85px;object-fit:cover;"
        >

    </td>



    <!-- =================================================
         PRODUCT
    ================================================== -->

    <td>

        <strong>

            <?= htmlspecialchars(
                $row['product_name']
            ); ?>

        </strong>


        <br>


        <small>

            <?= htmlspecialchars(
                $row['fit']
            ); ?>

            •


            <?= htmlspecialchars(
                $row['material']
            ); ?>

        </small>


        <br>


        <small>

            SKU:
            <?= htmlspecialchars(
                $row['sku']
            ); ?>

        </small>

    </td>



    <!-- =================================================
         CATEGORY
    ================================================== -->

    <td>

        <strong>

            <?= htmlspecialchars(
                $row['category']
            ); ?>

        </strong>


        <br>


        <small>

            <?= htmlspecialchars(
                $row['sub_category']
            ); ?>

        </small>


        <br>


        <small>

            <?= htmlspecialchars(
                $row['gender']
            ); ?>

        </small>

    </td>



    <!-- =================================================
         PRICE
    ================================================== -->

    <td>

        <strong>

            Rs.
            <?= number_format(
                $row['price']
            ); ?>

        </strong>


        <?php if (!empty($row['old_price'])) { ?>

            <br>

            <del>

                Rs.
                <?= number_format(
                    $row['old_price']
                ); ?>

            </del>

        <?php } ?>

    </td>



    <!-- =================================================
         STOCK
    ================================================== -->

    <td>


        <?php

        if ($row['stock'] > 20) {

        ?>

            <span class="stock-green">

                <?= $row['stock']; ?>

            </span>

        <?php

        } else {

        ?>

            <span class="stock-red">

                <?= $row['stock']; ?>

            </span>

        <?php

        }

        ?>

    </td>



    <!-- =================================================
         NEW ARRIVAL
    ================================================== -->

    <td>

        <?php if ($row['is_new_arrival'] == 1) { ?>

            <span class="badge">

                YES

            </span>

        <?php } else { ?>

            <span>

                No

            </span>

        <?php } ?>

    </td>



    <!-- =================================================
         BACK TO SCHOOL
    ================================================== -->

    <td>

        <?php if ($row['is_back_to_school'] == 1) { ?>

            <span class="badge">

                YES

            </span>

        <?php } else { ?>

            <span>

                No

            </span>

        <?php } ?>

    </td>



    <!-- =================================================
         SCHOOL CATEGORY
    ================================================== -->

    <td>

        <?php

        if (
            $row['is_back_to_school'] == 1
            &&
            !empty($row['school_category'])
        ) {

            echo htmlspecialchars(
                $row['school_category']
            );

        } else {

            echo "—";

        }

        ?>

    </td>



    <!-- =================================================
         ACTIONS
    ================================================== -->

    <td>


        <a
            href="product-details.php?id=<?= $row['id']; ?>"
            title="View"
        >

            👁

        </a>


        &nbsp;


        <a
            href="edit-product.php?id=<?= $row['id']; ?>"
            title="Edit"
        >

            ✏

        </a>


        &nbsp;


        <a
            href="delete-product.php?id=<?= $row['id']; ?>"
            title="Delete"
            onclick="return confirm('Are you sure you want to delete this product?')"
        >

            🗑

        </a>


    </td>


</tr>


<?php } ?>


</tbody>


</table>


</div>


</div>


<?php include "includes/footer.php"; ?>