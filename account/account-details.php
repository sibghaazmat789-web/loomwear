
<?php

session_start();

include "../includes/db.php";


/* ==========================================
   CHECK LOGIN
========================================== */

if (!isset($_SESSION['customer_id'])) {

    header("Location: login.php");
    exit();

}


$customer_id = (int) $_SESSION['customer_id'];

$errors = [];
$success = "";


/* ==========================================
   UPDATE ACCOUNT
========================================== */

if (isset($_POST['update_account'])) {

    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $gender     = $_POST['gender'] ?? '';
    $dob        = $_POST['date_of_birth'] ?? '';


    /* Validation */

    if ($first_name === '') {

        $errors[] = "First name is required.";

    }


    if ($last_name === '') {

        $errors[] = "Last name is required.";

    }


    if ($phone === '') {

        $errors[] = "Phone number is required.";

    }


    /* Validate gender */

    if (
        $gender !== '' &&
        !in_array($gender, ['Male', 'Female', 'Other'], true)
    ) {

        $errors[] = "Invalid gender selected.";

    }


    /* ==========================================
       UPDATE DATABASE
    ========================================== */

    if (empty($errors)) {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE customers
             SET first_name = ?,
                 last_name = ?,
                 phone = ?,
                 gender = ?,
                 date_of_birth = NULLIF(?, '')
             WHERE id = ?"
        );


        mysqli_stmt_bind_param(
            $stmt,
            "sssssi",
            $first_name,
            $last_name,
            $phone,
            $gender,
            $dob,
            $customer_id
        );


        if (mysqli_stmt_execute($stmt)) {

            /* Update session */

            $_SESSION['customer_first_name'] =
                $first_name;

            $_SESSION['customer_last_name'] =
                $last_name;

            $_SESSION['customer_name'] =
                $first_name . " " . $last_name;

            $_SESSION['customer_phone'] =
                $phone;


            $success =
                "Your account details have been updated successfully.";

        } else {

            $errors[] =
                "Unable to update your account. Please try again.";

        }


        mysqli_stmt_close($stmt);

    }

}


/* ==========================================
   GET CUSTOMER
========================================== */

$stmt = mysqli_prepare(
    $conn,
    "SELECT
        first_name,
        last_name,
        email,
        phone,
        gender,
        date_of_birth,
        created_at
     FROM customers
     WHERE id = ?
     LIMIT 1"
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $customer_id
);


mysqli_stmt_execute($stmt);


$result = mysqli_stmt_get_result($stmt);


if (mysqli_num_rows($result) !== 1) {

    session_destroy();

    header("Location: login.php");
    exit();

}


$customer = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

<title>Account Details | LoomWear</title>


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
   HEADER
========================================== */

.account-header {

    height: 70px;

    background: #fff;

    border-bottom: 1px solid #e5e5e5;

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 0 6%;

}


.logo {

    font-size: 24px;

    font-weight: 700;

    letter-spacing: 4px;

}


.header-links {

    display: flex;

    align-items: center;

    gap: 25px;

}


.header-links a {

    text-decoration: none;

    color: #111;

    font-size: 13px;

}


.header-links a:hover {

    opacity: .6;

}


/* ==========================================
   PAGE
========================================== */

.page {

    max-width: 850px;

    margin: auto;

    padding: 55px 20px 80px;

}


/* ==========================================
   BACK LINK
========================================== */

.back-link {

    color: #555;

    text-decoration: none;

    font-size: 13px;

}


.back-link:hover {

    color: #111;

}


/* ==========================================
   HEADING
========================================== */

.heading {

    margin: 30px 0;

}


.heading span {

    font-size: 11px;

    color: #777;

    letter-spacing: 3px;

}


.heading h1 {

    font-size: 34px;

    font-weight: 400;

    margin: 10px 0;

}


.heading p {

    color: #777;

    font-size: 14px;

}


/* ==========================================
   FORM CARD
========================================== */

.form-card {

    background: #fff;

    border: 1px solid #e3e3e3;

    padding: 40px;

}


/* ==========================================
   MESSAGES
========================================== */

.success {

    background: #f0f8f0;

    border: 1px solid #cfe3cf;

    color: #285c28;

    padding: 13px 15px;

    margin-bottom: 25px;

    font-size: 13px;

}


.error {

    background: #fff0f0;

    border: 1px solid #f0cccc;

    color: #a00000;

    padding: 13px 15px;

    margin-bottom: 25px;

    font-size: 13px;

}


.error p {

    margin: 4px 0;

}


/* ==========================================
   FORM
========================================== */

.form-grid {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 20px;

}


.form-group {

    margin-bottom: 20px;

}


.form-group.full {

    grid-column: 1 / -1;

}


.form-group label {

    display: block;

    font-size: 12px;

    font-weight: 600;

    margin-bottom: 8px;

}


.form-group input,
.form-group select {

    width: 100%;

    height: 48px;

    padding: 0 13px;

    border: 1px solid #d8d8d8;

    background: #fff;

    outline: none;

    font-size: 14px;

}


.form-group input:focus,
.form-group select:focus {

    border-color: #111;

}


/* ==========================================
   EMAIL
========================================== */

.email-note {

    margin-top: 8px;

    color: #888;

    font-size: 11px;

}


/* ==========================================
   BUTTON
========================================== */

.update-button {

    margin-top: 10px;

    width: 100%;

    height: 50px;

    border: none;

    background: #111;

    color: #fff;

    font-size: 13px;

    font-weight: 600;

    letter-spacing: 1px;

    cursor: pointer;

    transition: .2s;

}


.update-button:hover {

    background: #333;

}


/* ==========================================
   ACCOUNT INFO
========================================== */

.member-info {

    margin-top: 25px;

    padding-top: 25px;

    border-top: 1px solid #eee;

    color: #777;

    font-size: 12px;

}


/* ==========================================
   MOBILE
========================================== */

@media (max-width: 600px) {

    .account-header {

        padding: 0 20px;

    }


    .logo {

        font-size: 20px;

    }


    .header-links {

        gap: 12px;

    }


    .header-links a:first-child {

        display: none;

    }


    .page {

        padding: 35px 15px 50px;

    }


    .heading h1 {

        font-size: 28px;

    }


    .form-card {

        padding: 25px 20px;

    }


    .form-grid {

        grid-template-columns: 1fr;

    }


    .form-group.full {

        grid-column: auto;

    }

}

</style>

</head>


<body>


<!-- ==========================================
     HEADER
========================================== -->

<header class="account-header">


    <a
        href="../index.php"
        style="text-decoration:none;color:#111;"
    >

        <div class="logo">

            LOOMWEAR

        </div>

    </a>


    <div class="header-links">

        <a href="account.php">

            My Account

        </a>


        <a href="logout.php">

            Logout

        </a>

    </div>


</header>



<!-- ==========================================
     PAGE
========================================== -->

<main class="page">


    <a
        href="account.php"
        class="back-link"
    >

        ← Back to My Account

    </a>



    <div class="heading">

        <span>

            ACCOUNT SETTINGS

        </span>


        <h1>

            Account Details

        </h1>


        <p>

            Keep your personal information up to date.

        </p>

    </div>



    <div class="form-card">


        <!-- SUCCESS -->

        <?php if ($success !== ''): ?>

            <div class="success">

                <?= htmlspecialchars($success); ?>

            </div>

        <?php endif; ?>



        <!-- ERRORS -->

        <?php if (!empty($errors)): ?>

            <div class="error">

                <?php foreach ($errors as $message): ?>

                    <p>

                        <?= htmlspecialchars($message); ?>

                    </p>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>



        <!-- FORM -->

        <form method="POST">


            <div class="form-grid">


                <!-- FIRST NAME -->

                <div class="form-group">

                    <label>

                        FIRST NAME

                    </label>


                    <input

                        type="text"

                        name="first_name"

                        value="<?= htmlspecialchars(
                            $customer['first_name']
                        ); ?>"

                        required

                    >

                </div>



                <!-- LAST NAME -->

                <div class="form-group">

                    <label>

                        LAST NAME

                    </label>


                    <input

                        type="text"

                        name="last_name"

                        value="<?= htmlspecialchars(
                            $customer['last_name']
                        ); ?>"

                        required

                    >

                </div>



                <!-- EMAIL -->

                <div class="form-group full">

                    <label>

                        EMAIL ADDRESS

                    </label>


                    <input

                        type="email"

                        value="<?= htmlspecialchars(
                            $customer['email']
                        ); ?>"

                        readonly

                    >


                    <div class="email-note">

                        Your email address cannot be changed here.

                    </div>

                </div>



                <!-- PHONE -->

                <div class="form-group">

                    <label>

                        PHONE NUMBER

                    </label>


                    <input

                        type="text"

                        name="phone"

                        value="<?= htmlspecialchars(
                            $customer['phone'] ?? ''
                        ); ?>"

                        required

                    >

                </div>



                <!-- GENDER -->

                <div class="form-group">

                    <label>

                        GENDER

                    </label>


                    <select name="gender">


                        <option value="">

                            Select Gender

                        </option>


                        <option
                            value="Male"
                            <?= $customer['gender'] === 'Male'
                                ? 'selected'
                                : ''; ?>
                        >

                            Male

                        </option>


                        <option
                            value="Female"
                            <?= $customer['gender'] === 'Female'
                                ? 'selected'
                                : ''; ?>
                        >

                            Female

                        </option>


                        <option
                            value="Other"
                            <?= $customer['gender'] === 'Other'
                                ? 'selected'
                                : ''; ?>
                        >

                            Other

                        </option>


                    </select>

                </div>



                <!-- DATE OF BIRTH -->

                <div class="form-group">

                    <label>

                        DATE OF BIRTH

                    </label>


                    <input

                        type="date"

                        name="date_of_birth"

                        value="<?= htmlspecialchars(
                            $customer['date_of_birth'] ?? ''
                        ); ?>"

                    >

                </div>


            </div>



            <!-- UPDATE -->

            <button

                type="submit"

                name="update_account"

                class="update-button"

            >

                SAVE CHANGES

            </button>


        </form>



        <!-- MEMBER INFO -->

        <div class="member-info">

            LoomWear member since

            <strong>

                <?= date(
                    "F Y",
                    strtotime($customer['created_at'])
                ); ?>

            </strong>

        </div>


    </div>


</main>


</body>

</html>

