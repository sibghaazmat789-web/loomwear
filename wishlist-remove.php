<?php

session_start();

include "includes/db.php";

$id = (int)$_GET['id'];

$session = session_id();

mysqli_query($conn,"
DELETE FROM wishlist
WHERE product_id='$id'
AND session_id='$session'
");

header("Location:wishlist.php");

exit();

?>