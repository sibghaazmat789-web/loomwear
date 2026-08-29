<?php

session_start();

include "../includes/db.php";

$errors = [];

if(isset($_POST['register'])){

    $first_name = mysqli_real_escape_string($conn, trim($_POST['first_name']));
    $last_name  = mysqli_real_escape_string($conn, trim($_POST['last_name']));
    $email      = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone      = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $gender     = mysqli_real_escape_string($conn, $_POST['gender']);
    $dob        = $_POST['dob'];

    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // Validation

    if(empty($first_name))
        $errors[] = "First name is required.";

    if(empty($last_name))
        $errors[] = "Last name is required.";

    if(empty($email))
        $errors[] = "Email is required.";

    if(empty($phone))
        $errors[] = "Phone number is required.";

    if(strlen($password) < 6)
        $errors[] = "Password must be at least 6 characters.";

    if($password != $confirm)
        $errors[] = "Passwords do not match.";

    // Check Email

    $check = mysqli_query($conn,
    "SELECT id FROM customers WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){

        $errors[] = "Email already exists.";

    }

    if(empty($errors)){

        $hash = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn,

        "INSERT INTO customers
        (
            first_name,
            last_name,
            email,
            phone,
            password,
            gender,
            date_of_birth
        )

        VALUES

        (
            '$first_name',
            '$last_name',
            '$email',
            '$phone',
            '$hash',
            '$gender',
            '$dob'
        )");

        $_SESSION['success']="Account created successfully.";

        header("Location: login.php");

        exit();

    }

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Create Account | LoomWear</title>

<link rel="stylesheet" href="../assets/css/account.css">

</head>

<body>

<div class="account-container">

<div class="account-box">

<h1>Create Account</h1>

<p>Join LoomWear and start shopping.</p>

<?php

if(!empty($errors)){

echo "<div class='error-box'>";

foreach($errors as $error){

echo "<p>$error</p>";

}

echo "</div>";

}

?>

<form method="POST">

<div class="row">

<input
type="text"
name="first_name"
placeholder="First Name"
required>

<input
type="text"
name="last_name"
placeholder="Last Name"
required>

</div>

<input
type="email"
name="email"
placeholder="Email Address"
required>

<input
type="text"
name="phone"
placeholder="Phone Number"
required>

<div class="row">

<select name="gender">

<option value="">Gender</option>

<option>Male</option>

<option>Female</option>

<option>Other</option>

</select>

<input
type="date"
name="dob">

</div>

<input
type="password"
name="password"
placeholder="Password"
required>

<input
type="password"
name="confirm_password"
placeholder="Confirm Password"
required>

<button
type="submit"
name="register">

Create Account

</button>

</form>

<p class="bottom-text">

Already have an account?

<a href="login.php">

Sign In

</a>

</p>

</div>

</div>

</body>

</html>