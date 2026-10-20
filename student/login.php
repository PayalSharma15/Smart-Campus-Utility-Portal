<?php
session_start();
include("../db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM students WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        // ✅ BOTH SUPPORT
        if (
            password_verify($password, $user['password']) 
            || $password === $user['password']
        ){

            $_SESSION['user'] = $user['email'];
            $_SESSION['student_name'] = $user['name'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Invalid Password";
        }

    } else {
        $error = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" href="../CSS/login.css">

    <style>
        /* 🔥 Navbar fix */
        .header {
            background: #2e7d32;
            color: white;
            padding: 15px 30px;
            font-size: 22px;
            font-weight: bold;
            padding-left: 32em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .title {
            font-size: 22px;
        }

        /* 🔥 Logout button style */
        .logout-btn {
            text-decoration: none;
            color: white;
            font-size: 15px;
            background: rgba(255,255,255,0.2);
            padding: 6px 15px;
            border-radius: 20px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: white;
            color: #2e7d32;
        }
    </style>
</head>

<body>

<!-- 🔥 Navbar -->
<div class="header">
    <span class="title">User Login</span>
    <a href="../logout.php" class="logout-btn">Logout</a>
</div>

<div class="container">

    <form method="POST">

        <div class="input-group">
            <input type="email" name="email" required>
            <label>Email</label>
        </div>

        <div class="input-group">
            <input type="password" name="password" required>
            <label>Password</label>
        </div>

        <button type="submit" class="login-btn">Login</button>

        <?php if($error != "") { ?>
            <p style="color:red; text-align:center;"><?php echo $error; ?></p>
        <?php } ?>

        <p class="signup-text">
            Don’t have an account?
            <a href="register.php">Sign Up</a>
        </p>
        <p style="text-align:center;">
    <a href="forgot_password.php">Forgot Password?</a>
</p>

    </form>

</div>

</body>
</html>