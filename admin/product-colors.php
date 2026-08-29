<?php

include "../includes/db.php";

// Get Products
$products = mysqli_query($conn,
"SELECT id, product_name FROM products");

if(isset($_POST['save'])){

    $product_id = $_POST['product_id'];

    $color_name = $_POST['color_name'];

    $color_code = $_POST['color_code'];

    // Upload Image
    $image = $_FILES['image']['name'];

    $tmp = $_FILES['image']['tmp_name'];

    if($image!=""){

        move_uploaded_file(
            $tmp,
            "../uploads/colors/".$image
        );

    }

    $query = "INSERT INTO product_colors
    (product_id,color_name,color_code,image)
    VALUES
    ('$product_id','$color_name','$color_code','$image')";

    mysqli_query($conn,$query);

    header("Location: product-colors.php");
    exit;

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Product Colours</title>

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

<h2>Product Colours</h2>

<form method="POST" enctype="multipart/form-data">

<label>Select Product</label>

<select name="product_id" required>

<?php while($row=mysqli_fetch_assoc($products)){ ?>

<option value="<?= $row['id']; ?>">

<?= $row['product_name']; ?>

</option>

<?php } ?>

</select>

<label>Colour Name</label>

<input
type="text"
name="color_name"
placeholder="Black"
required>

<label>Colour Code</label>

<input
type="color"
name="color_code"
required>

<label>Colour Image</label>

<input
type="file"
name="image">

<button
type="submit"
name="save">

Save Colour

</button>

</form>

<?php

$colors = mysqli_query($conn,

"SELECT product_colors.*,
products.product_name

FROM product_colors

JOIN products

ON products.id = product_colors.product_id

ORDER BY product_name");

?>

<h2>Saved Colours</h2>

<table border="1" cellpadding="10">

<tr>

<th>Image</th>

<th>Product</th>

<th>Colour</th>

<th>Code</th>

</tr>

<?php while($color=mysqli_fetch_assoc($colors)){ ?>

<tr>

<td>

<?php if($color['image']!=""){ ?>

<img
src="../uploads/colors/<?= $color['image']; ?>"
width="60">

<?php } ?>

</td>

<td><?= $color['product_name']; ?></td>

<td><?= $color['color_name']; ?></td>

<td>

<span
style="
display:inline-block;
width:25px;
height:25px;
border-radius:50%;
background:<?= $color['color_code']; ?>;
border:1px solid #ccc;">
</span>

<?= $color['color_code']; ?>

</td>

</tr>

<?php } ?>

</table>

</body>

</html>

