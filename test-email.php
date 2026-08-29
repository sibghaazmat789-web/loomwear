```php
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// ==========================================
// PHPMailer FILES
// ==========================================

require_once "PHPMailer/Exception.php";
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";


// ==========================================
// EMAIL CONFIG
// ==========================================

require_once "includes/email-config.php";


// ==========================================
// CREATE MAILER
// ==========================================

$mail = new PHPMailer(true);


try {

    // ==========================================
    // SMTP SETTINGS
    // ==========================================

    $mail->isSMTP();

    $mail->Host = MAIL_HOST;

    $mail->SMTPAuth = true;

    $mail->Username = MAIL_USERNAME;

    $mail->Password = MAIL_PASSWORD;

    $mail->SMTPSecure =
        PHPMailer::ENCRYPTION_SMTPS;

    $mail->Port = 465;


    // ==========================================
    // SENDER
    // ==========================================

    $mail->setFrom(
        MAIL_FROM,
        MAIL_FROM_NAME
    );


    // ==========================================
    // RECEIVER
    // ==========================================

    $mail->addAddress(
        ADMIN_EMAIL,
        ADMIN_NAME
    );


    // ==========================================
    // EMAIL CONTENT
    // ==========================================

    $mail->isHTML(true);

    $mail->Subject =
        'LoomWear Email System Test';


    $mail->Body = '

    <!DOCTYPE html>

    <html>

    <body style="
        margin:0;
        padding:30px;
        background:#f5f5f5;
        font-family:Arial,Helvetica,sans-serif;
    ">

        <div style="
            max-width:600px;
            margin:auto;
            background:#ffffff;
            padding:40px;
        ">

            <div style="
                text-align:center;
                background:#111111;
                padding:25px;
            ">

                <div style="
                    color:#ffffff;
                    font-size:30px;
                    font-weight:bold;
                ">

                    Loom<span style="
                        font-weight:normal;
                    ">Wear</span>

                </div>

            </div>


            <div style="
                text-align:center;
                padding:35px 20px;
            ">

                <div style="
                    font-size:45px;
                    margin-bottom:15px;
                ">
                    ✓
                </div>


                <h1 style="
                    font-size:24px;
                    margin-bottom:15px;
                ">

                    Email System Working!

                </h1>


                <p style="
                    color:#666666;
                    line-height:1.7;
                    font-size:14px;
                ">

                    Congratulations! Your LoomWear
                    website is successfully connected
                    to Gmail SMTP using PHPMailer.

                </p>


                <div style="
                    margin-top:30px;
                    padding:20px;
                    background:#f5f5f5;
                ">

                    <strong>
                        SMTP Connection Successful
                    </strong>

                    <p style="
                        color:#777;
                        font-size:13px;
                    ">

                        Your website can now send
                        professional emails.

                    </p>

                </div>

            </div>


            <div style="
                text-align:center;
                padding:20px;
                background:#f5f5f5;
                color:#999;
                font-size:11px;
            ">

                © 2026 LoomWear. All Rights Reserved.

            </div>

        </div>

    </body>

    </html>

    ';


    $mail->AltBody =
        'LoomWear email system is working successfully.';


    // ==========================================
    // SEND
    // ==========================================

    $mail->send();


    echo '

        <div style="
            max-width:600px;
            margin:50px auto;
            padding:30px;
            text-align:center;
            font-family:Arial;
        ">

            <h2 style="color:green;">
                ✓ Email Sent Successfully!
            </h2>

            <p>
                Check your Gmail inbox.
            </p>

        </div>

    ';


}
catch (Exception $e) {

    echo '

        <div style="
            max-width:700px;
            margin:50px auto;
            padding:30px;
            font-family:Arial;
        ">

            <h2 style="color:red;">
                ✕ Email Could Not Be Sent
            </h2>

            <p>
                <strong>Error:</strong>
            </p>

            <pre style="
                background:#f5f5f5;
                padding:20px;
                white-space:pre-wrap;
            ">'

            . htmlspecialchars(
                $mail->ErrorInfo
            )

            . '</pre>

        </div>

    ';

}

?>
```
