<?php

include "includes/header.php";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Care Guide | LoomWear</title>


    <style>

        /* =====================================================
           CARE GUIDE PAGE
        ===================================================== */

        .care-guide-page {

            max-width: 1200px;

            margin: 0 auto;

            padding: 70px 25px 90px;

        }


        /* =====================================================
           HERO
        ===================================================== */

        .care-guide-hero {

            text-align: center;

            margin-bottom: 60px;

        }

        .care-guide-hero span {

            display: block;

            font-size: 13px;

            font-weight: 600;

            letter-spacing: 2px;

            text-transform: uppercase;

            margin-bottom: 12px;

        }

        .care-guide-hero h1 {

            font-size: 42px;

            margin: 0 0 18px;

            font-weight: 600;

        }

        .care-guide-hero p {

            max-width: 700px;

            margin: 0 auto;

            font-size: 16px;

            line-height: 1.8;

            color: #666;

        }


        /* =====================================================
           INTRO
        ===================================================== */

        .care-intro {

            text-align: center;

            max-width: 850px;

            margin: 0 auto 65px;

        }

        .care-intro h2 {

            font-size: 28px;

            margin-bottom: 15px;

        }

        .care-intro p {

            color: #666;

            line-height: 1.8;

            font-size: 15px;

        }


        /* =====================================================
           CARE CARDS
        ===================================================== */

        .care-grid {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 25px;

            margin-bottom: 70px;

        }


        .care-card {

            border: 1px solid #e5e5e5;

            padding: 30px;

            background: #fff;

            transition: 0.3s ease;

        }


        .care-card:hover {

            transform: translateY(-4px);

            box-shadow:
                0 10px 30px
                rgba(0,0,0,0.08);

        }


        .care-card .care-number {

            font-size: 13px;

            font-weight: 700;

            letter-spacing: 1px;

            margin-bottom: 15px;

        }


        .care-card h3 {

            font-size: 21px;

            margin: 0 0 12px;

        }


        .care-card p {

            color: #666;

            line-height: 1.7;

            font-size: 14px;

            margin: 0;

        }


        /* =====================================================
           WASHING GUIDE
        ===================================================== */

        .washing-guide {

            margin-bottom: 70px;

        }


        .washing-guide h2 {

            text-align: center;

            font-size: 30px;

            margin-bottom: 35px;

        }


        .washing-grid {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 20px;

        }


        .washing-item {

            background: #f7f7f7;

            padding: 28px 20px;

            text-align: center;

        }


        .washing-item .icon {

            font-size: 32px;

            margin-bottom: 15px;

        }


        .washing-item h4 {

            margin: 0 0 10px;

            font-size: 17px;

        }


        .washing-item p {

            margin: 0;

            font-size: 13px;

            line-height: 1.6;

            color: #666;

        }


        /* =====================================================
           FABRIC GUIDE
        ===================================================== */

        .fabric-guide {

            margin-bottom: 70px;

        }


        .fabric-guide h2 {

            text-align: center;

            font-size: 30px;

            margin-bottom: 35px;

        }


        .fabric-table {

            width: 100%;

            border-collapse: collapse;

        }


        .fabric-table th,
        .fabric-table td {

            border: 1px solid #ddd;

            padding: 16px;

            text-align: left;

        }


        .fabric-table th {

            background: #111;

            color: #fff;

            font-weight: 600;

        }


        .fabric-table td {

            font-size: 14px;

            line-height: 1.6;

        }


        /* =====================================================
           QUICK TIPS
        ===================================================== */

        .quick-tips {

            background: #f6f6f6;

            padding: 45px;

            margin-bottom: 60px;

        }


        .quick-tips h2 {

            margin-top: 0;

            margin-bottom: 25px;

            font-size: 28px;

        }


        .quick-tips ul {

            margin: 0;

            padding-left: 20px;

        }


        .quick-tips li {

            margin-bottom: 14px;

            line-height: 1.7;

            color: #555;

        }


        /* =====================================================
           FINAL MESSAGE
        ===================================================== */

        .care-footer {

            text-align: center;

            padding-top: 20px;

        }


        .care-footer h2 {

            font-size: 28px;

            margin-bottom: 12px;

        }


        .care-footer p {

            color: #666;

            line-height: 1.7;

            max-width: 700px;

            margin: 0 auto;

        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 900px) {

            .care-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }

            .washing-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }

            .care-guide-hero h1 {

                font-size: 36px;

            }

        }


        @media (max-width: 600px) {

            .care-guide-page {

                padding:
                    45px 18px
                    60px;

            }

            .care-guide-hero {

                margin-bottom: 45px;

            }

            .care-guide-hero h1 {

                font-size: 30px;

            }

            .care-intro h2,
            .washing-guide h2,
            .fabric-guide h2,
            .quick-tips h2,
            .care-footer h2 {

                font-size: 24px;

            }

            .care-grid {

                grid-template-columns: 1fr;

            }

            .washing-grid {

                grid-template-columns: 1fr;

            }

            .quick-tips {

                padding: 28px 22px;

            }

            .fabric-table {

                display: block;

                overflow-x: auto;

                white-space: nowrap;

            }

        }

    </style>

</head>


<body>


<main class="care-guide-page">


    <!-- =====================================================
         HERO
    ===================================================== -->

    <section class="care-guide-hero">

        <span>
            LoomWear Care Guide
        </span>

        <h1>
            Love Your Clothes Longer
        </h1>

        <p>
            Proper care helps your LoomWear pieces stay
            comfortable, fresh, and looking their best.
            Follow these simple care tips to help extend
            the life of your favorite garments.
        </p>

    </section>


    <!-- =====================================================
         INTRO
    ===================================================== -->

    <section class="care-intro">

        <h2>
            Simple Care, Better Clothing
        </h2>

        <p>
            Always check the care label attached to your
            garment first. Different fabrics and finishes
            may require different care methods. When in
            doubt, choose a gentle cycle, cool water, and
            low heat.
        </p>

    </section>


    <!-- =====================================================
         CARE CARDS
    ===================================================== -->

    <section class="care-grid">


        <article class="care-card">

            <div class="care-number">
                01
            </div>

            <h3>
                Read the Label
            </h3>

            <p>
                Care labels provide product-specific
                instructions for washing, drying,
                ironing, and other treatments. Follow
                those instructions whenever possible.
            </p>

        </article>


        <article class="care-card">

            <div class="care-number">
                02
            </div>

            <h3>
                Wash With Care
            </h3>

            <p>
                Use cold or lukewarm water for most
                garments and choose a gentle washing
                cycle to help protect color, shape,
                and fabric.
            </p>

        </article>


        <article class="care-card">

            <div class="care-number">
                03
            </div>

            <h3>
                Protect Colors
            </h3>

            <p>
                Wash dark and light colors separately.
                Turn printed or graphic garments
                inside out before washing to help
                protect their appearance.
            </p>

        </article>


        <article class="care-card">

            <div class="care-number">
                04
            </div>

            <h3>
                Avoid Excess Heat
            </h3>

            <p>
                High temperatures can cause shrinking,
                fading, and fabric damage. Use low heat
                when drying and avoid unnecessary
                high-temperature ironing.
            </p>

        </article>


        <article class="care-card">

            <div class="care-number">
                05
            </div>

            <h3>
                Store Properly
            </h3>

            <p>
                Make sure garments are completely dry
                before storing. Fold knitwear and
                heavier pieces rather than hanging them
                if you want to help maintain their shape.
            </p>

        </article>


        <article class="care-card">

            <div class="care-number">
                06
            </div>

            <h3>
                Treat Stains Quickly
            </h3>

            <p>
                Gently blot stains as soon as possible.
                Avoid rubbing aggressively, and always
                test cleaning products on an inconspicuous
                area first.
            </p>

        </article>


    </section>


    <!-- =====================================================
         WASHING GUIDE
    ===================================================== -->

    <section class="washing-guide">

        <h2>
            Everyday Washing Guide
        </h2>


        <div class="washing-grid">


            <div class="washing-item">

                <div class="icon">
                    💧
                </div>

                <h4>
                    Cold Water
                </h4>

                <p>
                    Use cool water whenever possible
                    to help reduce fading and shrinkage.
                </p>

            </div>


            <div class="washing-item">

                <div class="icon">
                    🧺
                </div>

                <h4>
                    Gentle Cycle
                </h4>

                <p>
                    Choose a gentle cycle for delicate,
                    printed, and lightweight garments.
                </p>

            </div>


            <div class="washing-item">

                <div class="icon">
                    🌬️
                </div>

                <h4>
                    Air Dry
                </h4>

                <p>
                    Air drying is a gentle option that
                    helps protect fabric and shape.
                </p>

            </div>


            <div class="washing-item">

                <div class="icon">
                    ♨️
                </div>

                <h4>
                    Low Heat
                </h4>

                <p>
                    When using a dryer or iron,
                    choose the lowest suitable setting.
                </p>

            </div>


        </div>

    </section>


    <!-- =====================================================
         FABRIC GUIDE
    ===================================================== -->

    <section class="fabric-guide">

        <h2>
            Fabric Care Guide
        </h2>


        <table class="fabric-table">

            <thead>

                <tr>

                    <th>
                        Fabric
                    </th>

                    <th>
                        Washing
                    </th>

                    <th>
                        Drying
                    </th>

                    <th>
                        Ironing
                    </th>

                </tr>

            </thead>


            <tbody>

                <tr>

                    <td>
                        Cotton
                    </td>

                    <td>
                        Machine wash cold or lukewarm.
                    </td>

                    <td>
                        Air dry or tumble dry low.
                    </td>

                    <td>
                        Low to medium heat.
                    </td>

                </tr>


                <tr>

                    <td>
                        Cotton Blend
                    </td>

                    <td>
                        Use a gentle cycle with similar colors.
                    </td>

                    <td>
                        Tumble dry low or air dry.
                    </td>

                    <td>
                        Low heat.
                    </td>

                </tr>


                <tr>

                    <td>
                        Denim
                    </td>

                    <td>
                        Wash inside out with cold water.
                    </td>

                    <td>
                        Air drying is preferred.
                    </td>

                    <td>
                        Medium heat if necessary.
                    </td>

                </tr>


                <tr>

                    <td>
                        Knitwear
                    </td>

                    <td>
                        Follow the garment label and use
                        a gentle cycle where permitted.
                    </td>

                    <td>
                        Lay flat to dry when recommended.
                    </td>

                    <td>
                        Use low heat or steam carefully.
                    </td>

                </tr>


            </tbody>

        </table>

    </section>


    <!-- =====================================================
         QUICK TIPS
    ===================================================== -->

    <section class="quick-tips">

        <h2>
            Quick Care Tips
        </h2>

        <ul>

            <li>
                Turn printed, dark, and graphic garments
                inside out before washing.
            </li>

            <li>
                Close zippers and fasten buttons before
                washing to reduce snagging.
            </li>

            <li>
                Avoid using too much detergent, as residue
                can build up on fabrics.
            </li>

            <li>
                Do not leave damp clothing sitting in the
                washing machine for long periods.
            </li>

            <li>
                Store clothes in a clean, dry, well-ventilated
                space.
            </li>

        </ul>

    </section>


    <!-- =====================================================
         FOOTER MESSAGE
    ===================================================== -->

    <section class="care-footer">

        <h2>
            Made to Wear. Made to Last.
        </h2>

        <p>
            With a little extra care, your favorite
            LoomWear pieces can stay looking and feeling
            great for longer.
        </p>

    </section>


</main>


<?php

include "includes/footer.php";

?>


</body>

</html>