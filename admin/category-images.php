<?php
include "../includes/db.php";

if(isset($_POST['upload']))
{

    $category=$_POST['category'];

    $subcategory=$_POST['sub_category'];

    $image=$_FILES['image']['name'];

    $tmp=$_FILES['image']['tmp_name'];

    move_uploaded_file($tmp,"../uploads/category/".$image);

    mysqli_query($conn,"INSERT INTO category_images(category,sub_category,image)

    VALUES('$category','$subcategory','$image')");

    header("Location: category-images.php");

}
?>

<?php include "includes/header.php"; ?>

<div class="content">

<h2>Category Images</h2>

<form method="POST" enctype="multipart/form-data">

<label>Category</label>

<select name="category" id="category" required>

    <option value="">Select Category</option>

    <option value="Men">Men</option>
    <option value="Women">Women</option>
    <option value="Girls">Girls</option>
    <option value="Boys">Boys</option>
    <option value="Baby & Toddler">Baby & Toddler</option>

</select>

<br><br>

<label>Sub Category</label>

<select name="sub_category" id="sub_category" required>

    <option value="">Select Sub Category</option>

</select>

<br><br>

<label>Image</label>

<input type="file" name="image" required>

<br><br>

<button type="submit" name="upload">

Upload

</button>

</form>

<hr>

<h2>Uploaded Categories</h2>

<table>

<tr>

<th>ID</th>

<th>Image</th>

<th>Category</th>

<th>Sub Category</th>

<th>Action</th>

</tr>

<?php

$query=mysqli_query($conn,"SELECT * FROM category_images ORDER BY id DESC");

while($row=mysqli_fetch_assoc($query))

{

?>

<tr>

<td><?= $row['id']; ?></td>

<td>

<img src="../uploads/category/<?= $row['image']; ?>"

width="100">

</td>

<td><?= $row['category']; ?></td>

<td><?= $row['sub_category']; ?></td>

<td>

<a href="delete-category-image.php?id=<?= $row['id']; ?>">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

<script src="assets/js/admin.js"></script>

<?php include "includes/footer.php"; ?>