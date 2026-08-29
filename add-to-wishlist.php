<?php

session_start();

include "includes/db.php";

$product=(int)$_GET['product'];

$session=session_id();

$check=mysqli_query($conn,"
SELECT *
FROM wishlist
WHERE session_id='$session'
AND product_id='$product'
");

if(mysqli_num_rows($check)==0){

mysqli_query($conn,"
INSERT INTO wishlist(session_id,product_id)
VALUES('$session','$product')
");

}

header("Location: wishlist.php");

exit();

?>