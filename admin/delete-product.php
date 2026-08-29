<?php

include "../includes/db.php";


if(isset($_GET['id'])){


$id = $_GET['id'];


// get image name

$imageQuery = mysqli_query($conn,
"SELECT image FROM products WHERE id='$id'");


$imageData=mysqli_fetch_assoc($imageQuery);



if($imageData){

$imagePath="../uploads/".$imageData['image'];

if(file_exists($imagePath)){

unlink($imagePath);

}

}


// delete product

$delete = mysqli_query($conn,
"DELETE FROM products WHERE id='$id'");



if($delete){

header("Location: products.php");

exit();

}


else{

echo mysqli_error($conn);

}


}

?>