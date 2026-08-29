<?php

include "../includes/db.php";

$products = mysqli_query(
    $conn,
    "SELECT id, product_name FROM products"
);

if(isset($_POST['upload'])){

    $product_id = $_POST['product_id'];

    $sort_order = $_POST['sort_order'];

    $image = time() . "_" . basename($_FILES['image']['name']);

    $tmp = $_FILES['image']['tmp_name'];

    $destination = realpath(__DIR__ . "/../uploads/products")
                  . DIRECTORY_SEPARATOR
                  . $image;

    echo "Destination: " . $destination . "<br>";

    echo "Upload Error: " . $_FILES['image']['error'] . "<br>";
echo "Temporary File: " . $_FILES['image']['tmp_name'] . "<br>";
echo "File Exists: " . (file_exists($_FILES['image']['tmp_name']) ? "YES" : "NO") . "<br>";

    if(move_uploaded_file($tmp, $destination)){

        $query = "INSERT INTO product_images
                  (product_id,image,sort_order)
                  VALUES
                  ('$product_id','$image','$sort_order')";

        if(mysqli_query($conn, $query)){

            echo "Image Uploaded Successfully.";

        } else {

            die(mysqli_error($conn));

        }

    } else {

        echo "Upload Failed.";

    }

}   

$gallery = mysqli_query($conn, "
SELECT
    product_images.id,
    product_images.image,
    product_images.sort_order,
    products.product_name
FROM product_images
JOIN products
ON product_images.product_id = products.id
ORDER BY products.product_name, product_images.sort_order
");

?>

<!DOCTYPE html>

<html>

<head>

<title>Product Gallery</title>

</head>

<body>

<h1>Product Gallery</h1>

<form method="POST"
enctype="multipart/form-data">

<label>Select Product</label>

<select name="product_id">

<?php

while($row=mysqli_fetch_assoc($products)){

?>

<option value="<?= $row['id']; ?>">

<?= $row['product_name']; ?>

</option>

<?php } ?>

</select>

<label>Gallery Image</label>

<input type="file" name="image" required>

<label>Sort Order</label>

<input type="number"
name="sort_order"
value="1">

<button
type="submit"
name="upload">

Upload Image

</button>

</form>

<h2>Gallery Images</h2>

<table border="1" cellpadding="10" cellspacing="0">

<tr>
    <th>ID</th>
    <th>Product</th>
    <th>Image</th>
    <th>Sort Order</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($gallery)){ ?>

<tr>

    <td><?= $row['id']; ?></td>

    <td><?= $row['product_name']; ?></td>

    <td>
        <img src="../uploads/products/<?= $row['image']; ?>" width="80">
    </td>

    <td><?= $row['sort_order']; ?></td>

    <td>
        <a href="delete-gallery.php?id=<?= $row['id']; ?>"
           onclick="return confirm('Delete this image?')">
           Delete
        </a>
    </td>

</tr>

<?php } ?>

</table>

</body>

</html>

