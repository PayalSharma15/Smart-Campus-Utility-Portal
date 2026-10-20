<?php
session_start();

$msg = "";

if(isset($_POST['verify'])){
    $user_otp = $_POST['otp'];

    if($user_otp == $_SESSION['otp']){
        header("Location: reset_password.php");
        exit();
    } else {
        $msg = "Invalid OTP!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Verify OTP</title>
<link rel="stylesheet" href="../CSS/verify_otp.css">
</head>

<body>

<!-- Navbar -->
<div class="navbar">
    Smart Campus
</div>

<div class="container">
    <div class="card">

        <h2 class="title">🔐 Enter OTP</h2>

        <form method="POST">

            <div class="input-group">
                <input type="number" name="otp" placeholder="Enter OTP" required>
            </div>

            <button type="submit" name="verify" class="btn">
                Verify OTP
            </button>

        </form>

        <p class="msg"><?php echo $msg; ?></p>

    </div>
</div>

</body>
</html>