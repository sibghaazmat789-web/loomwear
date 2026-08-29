
<?php

session_start();

include "../includes/db.php";

$error = "";


/* ==========================================
   LOGIN
========================================== */

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];


    if (empty($email) || empty($password)) {

        $error = "Please enter your email and password.";

    } else {

        $email = mysqli_real_escape_string($conn, $email);


        /* Find customer */

        $query = mysqli_query(
            $conn,
            "SELECT *
             FROM customers
             WHERE email='$email'
             LIMIT 1"
        );


        if (mysqli_num_rows($query) == 1) {

            $customer = mysqli_fetch_assoc($query);


            /* Verify password */

            if (password_verify($password, $customer['password'])) {


                /* ==========================================
                   CREATE CUSTOMER SESSION
                ========================================== */

                $_SESSION['customer_id'] = $customer['id'];

                $_SESSION['customer_first_name'] =
                    $customer['first_name'];

                $_SESSION['customer_last_name'] =
                    $customer['last_name'];

                $_SESSION['customer_name'] =
                    $customer['first_name'] . " " .
                    $customer['last_name'];

                $_SESSION['customer_email'] =
                    $customer['email'];

                $_SESSION['customer_phone'] =
                    $customer['phone'];


                /* Redirect */

                header("Location: account.php");

                exit();

            } else {

                $error = "Incorrect password.";

            }

        } else {

            $error = "No account found with this email.";

        }

    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

<title>Sign In | LoomWear</title>


<style>

/* ==========================================
   RESET
========================================== */

* {
    box-sizing: border-box;
}


body {

    margin: 0;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    background: #f7f7f7;

    color: #111;

}


/* ==========================================
   LOGIN PAGE
========================================== */

.login-page {

    min-height: 100vh;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 40px 20px;

}


/* ==========================================
   LOGIN BOX
========================================== */

.login-box {

    width: 100%;

    max-width: 440px;

    background: #fff;

    padding: 45px;

    box-shadow:
        0 10px 40px
        rgba(0,0,0,0.08);

}


/* ==========================================
   LOGO
========================================== */

.logo {

    text-align: center;

    font-size: 25px;

    font-weight: 700;

    letter-spacing: 4px;

    margin-bottom: 12px;

}


.login-heading {

    text-align: center;

    margin-bottom: 30px;

}


.login-heading h1 {

    font-size: 28px;

    font-weight: 500;

    margin: 10px 0;

}


.login-heading p {

    color: #777;

    font-size: 14px;

    margin: 0;

}


/* ==========================================
   ERROR
========================================== */

.error-box {

    background: #fff0f0;

    color: #b00020;

    border: 1px solid #f2cccc;

    padding: 12px 15px;

    margin-bottom: 20px;

    font-size: 13px;

}


/* ==========================================
   FORM
========================================== */

.form-group {

    margin-bottom: 20px;

}


.form-group label {

    display: block;

    font-size: 13px;

    font-weight: 500;

    margin-bottom: 8px;

}


.form-group input {

    width: 100%;

    padding: 14px 13px;

    border: 1px solid #d8d8d8;

    background: #fff;

    font-size: 14px;

    outline: none;

    transition: .2s;

}


.form-group input:focus {

    border-color: #111;

}


/* ==========================================
   PASSWORD AREA
========================================== */

.password-wrapper {

    position: relative;

}


.password-wrapper input {

    padding-right: 45px;

}


.show-password {

    position: absolute;

    right: 14px;

    top: 50%;

    transform: translateY(-50%);

    border: none;

    background: none;

    cursor: pointer;

    color: #777;

}


/* ==========================================
   LOGIN BUTTON
========================================== */

.login-button {

    width: 100%;

    border: none;

    background: #111;

    color: #fff;

    padding: 15px;

    font-size: 13px;

    font-weight: 600;

    letter-spacing: 1px;

    cursor: pointer;

    transition: .25s;

}


.login-button:hover {

    background: #333;

}


/* ==========================================
   REGISTER
========================================== */

.register-section {

    text-align: center;

    margin-top: 25px;

    padding-top: 25px;

    border-top: 1px solid #eee;

    font-size: 14px;

    color: #777;

}


.register-section a {

    color: #111;

    font-weight: 600;

    text-decoration: none;

}


.register-section a:hover {

    text-decoration: underline;

}


/* ==========================================
   HOME
========================================== */

.home-link {

    display: block;

    text-align: center;

    margin-top: 20px;

    color: #777;

    font-size: 13px;

    text-decoration: none;

}


.home-link:hover {

    color: #111;

}


/* ==========================================
   MOBILE
========================================== */

@media (max-width: 500px) {

    .login-box {

        padding: 30px 22px;

    }

    .login-heading h1 {

        font-size: 24px;

    }

}

</style>

</head>


<body>


<div class="login-page">


    <div class="login-box">


        <!-- LOGO -->

        <div class="logo">

            LOOMWEAR

        </div>


        <!-- HEADING -->

        <div class="login-heading">

            <h1>

                Welcome Back

            </h1>

            <p>

                Sign in to your LoomWear account.

            </p>

        </div>


        <!-- ERROR -->

        <?php if (!empty($error)): ?>

            <div class="error-box">

                <?= htmlspecialchars($error); ?>

            </div>

        <?php endif; ?>


        <!-- LOGIN FORM -->

        <form method="POST">


            <!-- EMAIL -->

            <div class="form-group">

                <label>

                    Email Address

                </label>


                <input

                    type="email"

                    name="email"

                    placeholder="Enter your email address"

                    value="<?= htmlspecialchars(
                        $_POST['email'] ?? ''
                    ); ?>"

                    required

                >

            </div>


            <!-- PASSWORD -->

            <div class="form-group">

                <label>

                    Password

                </label>


                <div class="password-wrapper">

                    <input

                        type="password"

                        name="password"

                        id="loginPassword"

                        placeholder="Enter your password"

                        required

                    >


                    <button

                        type="button"

                        class="show-password"

                        onclick="togglePassword()"

                    >

                        <i
                        class="fa-solid fa-eye"
                        id="passwordIcon"
                        ></i>

                    </button>

                </div>

            </div>


            <!-- LOGIN -->

            <button

                type="submit"

                name="login"

                class="login-button"

            >

                SIGN IN

            </button>


        </form>


        <!-- REGISTER -->

        <div class="register-section">

            Don't have an account?

            <a href="register.php">

                Create Account

            </a>

        </div>


        <!-- HOME -->

        <a

            href="../index.php"

            class="home-link"

        >

            ← Back to LoomWear

        </a>


    </div>


</div>


<script>

/* ==========================================
   SHOW / HIDE PASSWORD
========================================== */

function togglePassword() {

    const password =
        document.getElementById("loginPassword");

    const icon =
        document.getElementById("passwordIcon");


    if (password.type === "password") {

        password.type = "text";

        icon.classList.remove("fa-eye");

        icon.classList.add("fa-eye-slash");

    } else {

        password.type = "password";

        icon.classList.remove("fa-eye-slash");

        icon.classList.add("fa-eye");

    }

}

</script>


<!-- FONT AWESOME -->

<script
src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js">
</script>


</body>

</html>

