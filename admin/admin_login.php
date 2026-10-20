<?php
session_start();
include("../db.php");
$msg = "";

if(isset($_POST['login'])){

    $username = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "
        SELECT * FROM admin 
        WHERE username='$username'
    ");

    if(mysqli_num_rows($query) > 0){

        $admin = mysqli_fetch_assoc($query);

        if($password == $admin['password']){

            $_SESSION['admin'] = $admin['username'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Invalid Password";
        }

    } else {
        $error = "Invalid Admin Credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <!-- ✅ CSS LINK -->
    <link rel="stylesheet" href="../CSS/admin_login.css">
</head>
<body>

<div class="login-container">

    <div class="login-box">
        <h2>Admin Login</h2>

        <form method="POST">

            <div class="input-group">
             <input type="text" name="email" required>
             <label>Username</label>
            </div>

            <div class="input-group">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>

            <button type="submit" name="login">Login</button>

            <?php if($msg != "") { ?>
                <p class="error"><?php echo $msg; ?></p>
            <?php } ?>

        </form>
    </div>

</div>

</body>
</html>