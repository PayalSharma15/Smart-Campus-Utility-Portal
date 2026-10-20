<?php
session_start();
include("../db.php");

$msg = "";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM teachers WHERE email='$email'");

    if(mysqli_num_rows($query) > 0){

        $row = mysqli_fetch_assoc($query);

        $db_password = $row['password'];

        // ✅ Handle BOTH (old + new)
        if(password_verify($password, $db_password) || $password === $db_password){

            $_SESSION['teacher_id'] = $row['id'];

            header("Location: dashboard.php");
            exit();

        } else {
            $msg = "Invalid Password!";
        }

    } else {
        $msg = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Login</title>
    <link rel="stylesheet" href="../CSS/teacher_login.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="../index.php" class="back-btn">⬅ Back</a>
    Teacher Login
</div>

<!-- Login Card -->
<div class="container">
    <div class="card">

        <h2>👨‍🏫 Teacher Login</h2>

        <form method="POST">
            <input type="email" name="email" placeholder="Enter Email" required>

            <input type="password" name="password" placeholder="Enter Password" required>

            <button name="login">Login</button>
        </form>

        <p class="msg"><?php echo $msg; ?></p>

    </div>
</div>

</body>
</html>