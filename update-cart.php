<?php

session_start();

include "includes/db.php";

$id=(int)$_POST['cart_id'];

$qty=(int)$_POST['quantity'];

if($qty<1){

$qty=1;

}

mysqli_query($conn,

"UPDATE cart

SET quantity='$qty'

WHERE id='$id'");

header("Location:cart.php");

exit();

?>