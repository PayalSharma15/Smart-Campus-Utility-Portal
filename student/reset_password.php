<?php
session_start();
include("../db.php");

$msg = "";

if(isset($_POST['update'])){

    $new_pass = $_POST['password'];
    $email = $_SESSION['email'];

    // 🔒 HASH PASSWORD (IMPORTANT)
    $hashed = password_hash($new_pass, PASSWORD_DEFAULT);

    mysqli_query($conn, "
        UPDATE students 
        SET password='$hashed' 
        WHERE email='$email'
    ");

    $msg = "✅ Password updated successfully";

    header("refresh:2;url=login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<link rel="stylesheet" href="../CSS/verify_otp.css"> <!-- same css -->
</head>

<body>

<!-- Navbar -->
<div class="navbar">
    Smart Campus
</div>

<div class="container">
    <div class="card">

        <h2 class="title">🔑 Set New Password</h2>

        <form method="POST">

            <div class="input-group">
                <input type="password" name="password" placeholder="Enter new password" required>
            </div>

            <button type="submit" name="update" class="btn">
                Update Password
            </button>

        </form>

        <p class="msg"><?php echo $msg; ?></p>

    </div>
</div>

</body>
</html>