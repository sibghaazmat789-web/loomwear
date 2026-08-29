<?php

include "../includes/db.php";

$id = (int)$_GET['id'];

// Get image filename
$result = mysqli_query($conn, "SELECT image FROM product_images WHERE id = $id");

if($row = mysqli_fetch_assoc($result)){

    $file = "../uploads/products/" . $row['image'];

    if(file_exists($file)){
        unlink($file);
    }

    mysqli_query($conn, "DELETE FROM product_images WHERE id = $id");
}

header("Location: gallery.php");
exit;