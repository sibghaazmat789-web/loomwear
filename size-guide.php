
<?php

$category = isset($_GET['category']) ? strtolower($_GET['category']) : 'men';

$allowed_categories = ['men', 'women', 'boys', 'girls', 'baby'];

if (!in_array($category, $allowed_categories)) {
    $category = 'men';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LoomWear Size Guide</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff;
            color: #111;
        }


        /* ==========================================
           TOP HEADER
        ========================================== */

        .size-header {
            border-bottom: 1px solid #e5e5e5;
            padding: 22px 6%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .size-logo {
            font-size: 25px;
            font-weight: 700;
            letter-spacing: 3px;
        }

        .back-link {
            color: #111;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-link:hover {
            text-decoration: underline;
        }


        /* ==========================================
           HERO
        ========================================== */

        .size-hero {
            text-align: center;
            padding: 70px 20px 55px;
            background: #f7f7f7;
        }

        .size-hero span {
            display: block;
            font-size: 11px;
            letter-spacing: 3px;
            color: #777;
            margin-bottom: 15px;
        }

        .size-hero h1 {
            font-size: 46px;
            font-weight: 500;
            letter-spacing: -1px;
            margin-bottom: 15px;
        }

        .size-hero p {
            max-width: 650px;
            margin: auto;
            color: #666;
            line-height: 1.7;
            font-size: 15px;
        }


        /* ==========================================
           MAIN CONTAINER
        ========================================== */

        .size-container {
            max-width: 1150px;
            margin: 0 auto;
            padding: 55px 25px 80px;
        }


        /* ==========================================
           CATEGORY TABS
        ========================================== */

        .category-tabs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 55px;
            flex-wrap: wrap;
        }

        .category-tabs a {
            text-decoration: none;
            color: #111;
            border: 1px solid #d5d5d5;
            padding: 13px 28px;
            font-size: 13px;
            transition: 0.25s ease;
            background: #fff;
        }

        .category-tabs a:hover,
        .category-tabs a.active {
            background: #111;
            color: #fff;
            border-color: #111;
        }


        /* ==========================================
           SECTION TITLE
        ========================================== */

        .guide-heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .guide-heading h2 {
            font-size: 28px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .guide-heading p {
            color: #777;
            font-size: 14px;
        }


        /* ==========================================
           TABLE
        ========================================== */

        .table-wrapper {
            overflow-x: auto;
            margin-bottom: 60px;
        }

        .size-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        .size-table th {
            background: #111;
            color: #fff;
            padding: 17px 15px;
            text-align: center;
            font-size: 12px;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .size-table td {
            padding: 17px 15px;
            border-bottom: 1px solid #e5e5e5;
            text-align: center;
            font-size: 14px;
        }

        .size-table tr:nth-child(even) {
            background: #fafafa;
        }

        .size-table tr:hover {
            background: #f2f2f2;
        }

        .size-table td:first-child {
            font-weight: 600;
        }


        /* ==========================================
           HOW TO MEASURE
        ========================================== */

        .measure-section {
            margin-top: 20px;
        }

        .measure-heading {
            text-align: center;
            margin-bottom: 35px;
        }

        .measure-heading h2 {
            font-size: 28px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .measure-heading p {
            color: #777;
            font-size: 14px;
        }

        .measure-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .measure-card {
            border: 1px solid #e5e5e5;
            padding: 30px 25px;
            text-align: center;
        }

        .measure-icon {
            width: 55px;
            height: 55px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .measure-card h3 {
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .measure-card p {
            color: #777;
            font-size: 13px;
            line-height: 1.7;
        }


        /* ==========================================
           FIT NOTE
        ========================================== */

        .fit-note {
            margin-top: 55px;
            background: #f7f7f7;
            padding: 30px;
            text-align: center;
        }

        .fit-note h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .fit-note p {
            max-width: 700px;
            margin: auto;
            color: #666;
            font-size: 14px;
            line-height: 1.7;
        }


        /* ==========================================
           FOOTER
        ========================================== */

        .size-footer {
            border-top: 1px solid #e5e5e5;
            text-align: center;
            padding: 25px;
            color: #777;
            font-size: 12px;
        }


        /* ==========================================
           TABLET
        ========================================== */

        @media (max-width: 800px) {

            .size-hero {
                padding: 55px 20px 45px;
            }

            .size-hero h1 {
                font-size: 38px;
            }

            .measure-grid {
                grid-template-columns: 1fr;
            }

        }


        /* ==========================================
           MOBILE
        ========================================== */

        @media (max-width: 600px) {

            .size-header {
                padding: 18px 20px;
            }

            .size-logo {
                font-size: 20px;
                letter-spacing: 2px;
            }

            .back-link {
                font-size: 12px;
            }

            .size-hero {
                padding: 45px 18px 40px;
            }

            .size-hero h1 {
                font-size: 32px;
            }

            .size-hero p {
                font-size: 13px;
            }

            .size-container {
                padding: 40px 15px 60px;
            }

            .category-tabs {
                gap: 7px;
                margin-bottom: 40px;
            }

            .category-tabs a {
                padding: 11px 17px;
                font-size: 12px;
            }

            .guide-heading h2,
            .measure-heading h2 {
                font-size: 24px;
            }

            .fit-note {
                padding: 25px 18px;
            }

        }

    </style>

</head>


<body>


<!-- ==========================================
     HEADER
========================================== -->

<header class="size-header">

    <div class="size-logo">
        LOOMWEAR
    </div>


<a href="index.php" class="back-link">
    <i class="fa-solid fa-arrow-left"></i>
    Back to LoomWear
</a>



</header>


<!-- ==========================================
     HERO
========================================== -->

<section class="size-hero">

    <span>LOOMWEAR FIT GUIDE</span>

    <h1>Find Your Perfect Fit</h1>

    <p>
        Use our size guide to find the right fit before you order.
        Measurements are provided in inches and are intended as a general
        guide. If you're between sizes, we recommend choosing the larger size.
    </p>

</section>


<main class="size-container">


    <!-- ==========================================
         CATEGORY TABS
    ========================================== -->

    <div class="category-tabs">

        <a href="size-guide.php?category=men"
           class="<?= $category === 'men' ? 'active' : ''; ?>">
            Men
        </a>

        <a href="size-guide.php?category=women"
           class="<?= $category === 'women' ? 'active' : ''; ?>">
            Women
        </a>

        <a href="size-guide.php?category=boys"
           class="<?= $category === 'boys' ? 'active' : ''; ?>">
            Boys
        </a>

        <a href="size-guide.php?category=girls"
           class="<?= $category === 'girls' ? 'active' : ''; ?>">
            Girls
        </a>

        <a href="size-guide.php?category=baby"
           class="<?= $category === 'baby' ? 'active' : ''; ?>">
            Baby & Toddler
        </a>

    </div>


    <!-- ==========================================
         MEN
    ========================================== -->

    <?php if ($category === 'men'): ?>

        <div class="guide-heading">

            <h2>Men's Clothing</h2>

            <p>
                Find your recommended size based on your body measurements.
            </p>

        </div>

        <div class="table-wrapper">

            <table class="size-table">

                <thead>

                    <tr>
                        <th>SIZE</th>
                        <th>CHEST</th>
                        <th>WAIST</th>
                        <th>HIP</th>
                        <th>INSEAM</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>XS</td>
                        <td>34–36"</td>
                        <td>28–30"</td>
                        <td>34–36"</td>
                        <td>30"</td>
                    </tr>

                    <tr>
                        <td>S</td>
                        <td>36–38"</td>
                        <td>30–32"</td>
                        <td>36–38"</td>
                        <td>31"</td>
                    </tr>

                    <tr>
                        <td>M</td>
                        <td>38–40"</td>
                        <td>32–34"</td>
                        <td>38–40"</td>
                        <td>32"</td>
                    </tr>

                    <tr>
                        <td>L</td>
                        <td>40–42"</td>
                        <td>34–36"</td>
                        <td>40–42"</td>
                        <td>32"</td>
                    </tr>

                    <tr>
                        <td>XL</td>
                        <td>42–44"</td>
                        <td>36–38"</td>
                        <td>42–44"</td>
                        <td>33"</td>
                    </tr>

                    <tr>
                        <td>XXL</td>
                        <td>44–46"</td>
                        <td>38–40"</td>
                        <td>44–46"</td>
                        <td>33"</td>
                    </tr>

                </tbody>

            </table>

        </div>


    <!-- ==========================================
         WOMEN
    ========================================== -->

    <?php elseif ($category === 'women'): ?>

        <div class="guide-heading">

            <h2>Women's Clothing</h2>

            <p>
                Find your recommended size based on your body measurements.
            </p>

        </div>

        <div class="table-wrapper">

            <table class="size-table">

                <thead>

                    <tr>
                        <th>SIZE</th>
                        <th>BUST</th>
                        <th>WAIST</th>
                        <th>HIP</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>XS</td>
                        <td>32–33"</td>
                        <td>25–26"</td>
                        <td>34–35"</td>
                    </tr>

                    <tr>
                        <td>S</td>
                        <td>34–35"</td>
                        <td>27–28"</td>
                        <td>36–37"</td>
                    </tr>

                    <tr>
                        <td>M</td>
                        <td>36–37"</td>
                        <td>29–30"</td>
                        <td>38–39"</td>
                    </tr>

                    <tr>
                        <td>L</td>
                        <td>38–40"</td>
                        <td>31–33"</td>
                        <td>41–43"</td>
                    </tr>

                    <tr>
                        <td>XL</td>
                        <td>41–43"</td>
                        <td>34–36"</td>
                        <td>44–46"</td>
                    </tr>

                </tbody>

            </table>

        </div>


    <!-- ==========================================
         BOYS
    ========================================== -->

    <?php elseif ($category === 'boys'): ?>

        <div class="guide-heading">

            <h2>Boys' Clothing</h2>

            <p>
                Recommended sizes based on age and body measurements.
            </p>

        </div>

        <div class="table-wrapper">

            <table class="size-table">

                <thead>

                    <tr>
                        <th>SIZE</th>
                        <th>AGE</th>
                        <th>CHEST</th>
                        <th>WAIST</th>
                        <th>HEIGHT</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>4</td>
                        <td>3–4 Years</td>
                        <td>22"</td>
                        <td>21"</td>
                        <td>39–41"</td>
                    </tr>

                    <tr>
                        <td>6</td>
                        <td>5–6 Years</td>
                        <td>24"</td>
                        <td>22"</td>
                        <td>43–47"</td>
                    </tr>

                    <tr>
                        <td>8</td>
                        <td>7–8 Years</td>
                        <td>26"</td>
                        <td>23"</td>
                        <td>49–53"</td>
                    </tr>

                    <tr>
                        <td>10</td>
                        <td>9–10 Years</td>
                        <td>28"</td>
                        <td>24"</td>
                        <td>54–57"</td>
                    </tr>

                    <tr>
                        <td>12</td>
                        <td>11–12 Years</td>
                        <td>30"</td>
                        <td>25"</td>
                        <td>58–61"</td>
                    </tr>

                </tbody>

            </table>

        </div>


    <!-- ==========================================
         GIRLS
    ========================================== -->

    <?php elseif ($category === 'girls'): ?>

        <div class="guide-heading">

            <h2>Girls' Clothing</h2>

            <p>
                Recommended sizes based on age and body measurements.
            </p>

        </div>

        <div class="table-wrapper">

            <table class="size-table">

                <thead>

                    <tr>
                        <th>SIZE</th>
                        <th>AGE</th>
                        <th>CHEST</th>
                        <th>WAIST</th>
                        <th>HEIGHT</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>4</td>
                        <td>3–4 Years</td>
                        <td>22"</td>
                        <td>21"</td>
                        <td>39–41"</td>
                    </tr>

                    <tr>
                        <td>6</td>
                        <td>5–6 Years</td>
                        <td>24"</td>
                        <td>22"</td>
                        <td>43–47"</td>
                    </tr>

                    <tr>
                        <td>8</td>
                        <td>7–8 Years</td>
                        <td>26"</td>
                        <td>23"</td>
                        <td>49–53"</td>
                    </tr>

                    <tr>
                        <td>10</td>
                        <td>9–10 Years</td>
                        <td>28"</td>
                        <td>24"</td>
                        <td>54–57"</td>
                    </tr>

                    <tr>
                        <td>12</td>
                        <td>11–12 Years</td>
                        <td>30"</td>
                        <td>25"</td>
                        <td>58–61"</td>
                    </tr>

                </tbody>

            </table>

        </div>


    <!-- ==========================================
         BABY & TODDLER
    ========================================== -->

    <?php elseif ($category === 'baby'): ?>

        <div class="guide-heading">

            <h2>Baby & Toddler</h2>

            <p>
                Choose the size closest to your child's age and measurements.
            </p>

        </div>

        <div class="table-wrapper">

            <table class="size-table">

                <thead>

                    <tr>
                        <th>SIZE</th>
                        <th>AGE</th>
                        <th>HEIGHT</th>
                        <th>CHEST</th>
                        <th>WEIGHT</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>0–3M</td>
                        <td>0–3 Months</td>
                        <td>20–24"</td>
                        <td>16"</td>
                        <td>Up to 14 lb</td>
                    </tr>

                    <tr>
                        <td>3–6M</td>
                        <td>3–6 Months</td>
                        <td>24–26"</td>
                        <td>17"</td>
                        <td>14–17 lb</td>
                    </tr>

                    <tr>
                        <td>6–12M</td>
                        <td>6–12 Months</td>
                        <td>26–30"</td>
                        <td>18"</td>
                        <td>17–22 lb</td>
                    </tr>

                    <tr>
                        <td>12–18M</td>
                        <td>12–18 Months</td>
                        <td>30–32"</td>
                        <td>19"</td>
                        <td>22–25 lb</td>
                    </tr>

                    <tr>
                        <td>18–24M</td>
                        <td>18–24 Months</td>
                        <td>32–34"</td>
                        <td>20"</td>
                        <td>25–28 lb</td>
                    </tr>

                </tbody>

            </table>

        </div>

    <?php endif; ?>


    <!-- ==========================================
         HOW TO MEASURE
    ========================================== -->

    <section class="measure-section">

        <div class="measure-heading">

            <h2>How to Measure</h2>

            <p>
                For the most accurate fit, measure yourself over light clothing.
            </p>

        </div>


        <div class="measure-grid">


            <div class="measure-card">

                <div class="measure-icon">
                    <i class="fa-solid fa-ruler-horizontal"></i>
                </div>

                <h3>Chest / Bust</h3>

                <p>
                    Measure around the fullest part of your chest or bust,
                    keeping the measuring tape level and comfortably loose.
                </p>

            </div>


            <div class="measure-card">

                <div class="measure-icon">
                    <i class="fa-solid fa-circle"></i>
                </div>

                <h3>Waist</h3>

                <p>
                    Measure around your natural waistline without pulling
                    the measuring tape too tightly.
                </p>

            </div>


            <div class="measure-card">

                <div class="measure-icon">
                    <i class="fa-solid fa-person"></i>
                </div>

                <h3>Height</h3>

                <p>
                    Stand straight against a wall without shoes and measure
                    from the floor to the top of your head.
                </p>

            </div>

        </div>

    </section>


    <!-- ==========================================
         FIT NOTE
    ========================================== -->

    <div class="fit-note">

        <h3>Still between two sizes?</h3>

        <p>
            If your measurements fall between two sizes, we recommend choosing
            the larger size for a more comfortable fit. For oversized or relaxed
            styles, check the product description for additional fit information.
        </p>

    </div>


</main>


<!-- ==========================================
     FOOTER
========================================== -->

<footer class="size-footer">

    © <?= date('Y'); ?> LoomWear. All Rights Reserved.

</footer>


</body>

</html>

