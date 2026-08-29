<?php

include "../includes/db.php";

// Fetch products
$products = mysqli_query($conn,
"SELECT id, product_name FROM products");

if(isset($_POST['save'])){

    $product_id = $_POST['product_id'];

    $size = $_POST['size'];

    $stock = $_POST['stock'];

    $query = "INSERT INTO product_sizes
    (product_id,size,stock)
    VALUES
    ('$product_id','$size','$stock')";

    mysqli_query($conn,$query);

    header("Location: product-sizes.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Product Sizes</title>

<style>

body{

font-family:Arial;

padding:40px;

}

form{

width:450px;

display:flex;

flex-direction:column;

gap:15px;

}

input,
select,
button{

padding:12px;

font-size:16px;

}

button{

background:#111;

color:#fff;

border:none;

cursor:pointer;

}

</style>

</head>

<body>

<h2>Product Sizes</h2>

<form method="POST">

<label>Select Product</label>

<select name="product_id">

<?php while($row=mysqli_fetch_assoc($products)){ ?>

<option value="<?= $row['id']; ?>">

<?= $row['product_name']; ?>

</option>

<?php } ?>

</select>

<label>Size</label>

<select name="size">

<option>S</option>

<option>M</option>

<option>L</option>

<option>XL</option>

<option>XXL</option>

</select>

<label>Stock</label>

<input
type="number"
name="stock"
value="10">

<button
type="submit"
name="save">

Save Size

</button>

</form>

<?php

$sizes = mysqli_query($conn,

"SELECT product_sizes.*,
products.product_name

FROM product_sizes

JOIN products

ON products.id=product_sizes.product_id

ORDER BY product_name");

?>

<h2>Saved Sizes</h2>

<table border="1" cellpadding="10">

<tr>

<th>Product</th>

<th>Size</th>

<th>Stock</th>

</tr>

<?php while($size=mysqli_fetch_assoc($sizes)){ ?>

<tr>

<td><?= $size['product_name']; ?></td>

<td><?= $size['size']; ?></td>

<td><?= $size['stock']; ?></td>

</tr>

<?php } ?>

</table>

</body>

</html>