<?php
session_start();
include("../db.php");

/* PHPMailer */
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg = "";

if(isset($_POST['send_otp'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // check email exist
    $check = mysqli_query($conn, "SELECT * FROM students WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){

        // 🔢 Generate OTP
        $otp = rand(1000,9999);

        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // 🔥 SEND EMAIL
        $mail = new PHPMailer(true);

        try {
            // ❌ DEBUG hata diya
            // $mail->SMTPDebug = 2;

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;

            $mail->Username   = 'payalbhimsharma03@gmail.com';
            $mail->Password   = 'oofgvycizxewynuj';

            // ✅ FIX
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('payalbhimsharma03@gmail.com', 'Smart Campus');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'OTP for Password Reset';
            $mail->Body    = "Your OTP is: <b>$otp</b>";

            $mail->send();

            $msg = "✅ OTP sent to your email";

            header("refresh:2;url=verify_otp.php");

        } catch (Exception $e) {
            $msg = "❌ Email failed: " . $mail->ErrorInfo;
        }

    } else {
        $msg = "❌ Email not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../CSS/forgot.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2>Smart Campus</h2>
</div>

<div class="container">

    <div class="card">

        <h2 class="title">🔐 Forgot Password</h2>

        <form method="POST">

            <div class="input-group">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>

            <button type="submit" name="send_otp" class="btn">
                Send OTP
            </button>

        </form>

        <p class="msg"><?php echo $msg; ?></p>

    </div>

</div>

</body>
</html>