<?php
include("../db.php");

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $parent_mobile = $_POST['parent_mobile'];
    $parent_email = $_POST['parent_email'];

    // ✅ Check existing user
    $check = mysqli_query($conn, "SELECT * FROM students WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {
        $msg = "User already registered!";
    } else {

        // 🔢 AUTO ROLL NO (01,02,03...)
        $getLast = mysqli_query($conn, "SELECT MAX(roll_no) as last FROM students");
        $data = mysqli_fetch_assoc($getLast);

        $next = $data['last'] ? $data['last'] + 1 : 1;
        $roll_no = str_pad($next, 2, "0", STR_PAD_LEFT);

        // ✅ INSERT INTO STUDENTS
        mysqli_query($conn, "
            INSERT INTO students (name, email, password, parent_mobile, parent_email, roll_no)
            VALUES ('$name', '$email', '$password', '$parent_mobile', '$parent_email', '$roll_no')
        ");

        echo "<script>
            alert('Registered Successfully!');
            window.location.href='login.php';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../CSS/register.css">

    <style>
        body {
            background:#f4f6f9;
            font-family:Arial;
        }

        .header {
            background: #2e7d32;
            color: white;
            padding: 15px;
            text-align:center;
            font-size: 22px;
            font-weight: bold;
        }

        .container {
            width: 350px;
            margin: 50px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .input-group {
            margin: 15px 0;
        } 
        input {
            width: 100%;
            padding: 10px;
            border: none;
            border-bottom: 2px solid #ccc;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2e7d32;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #1b5e20;
        }

        .login-link {
            text-align:center;
            margin-top:10px;
        }
    </style>
</head>

<body>

<div class="header">
    Student Registration
</div>

<div class="container">

<form method="POST">

    <div class="input-group">
        <input type="text" name="name" required placeholder="Name">
    </div>

    <div class="input-group">
        <input type="email" name="email" required placeholder="Email">
    </div>

    <div class="input-group">
        <input type="password" name="password" required placeholder="Password">
    </div>

    <div class="input-group">
        <input type="text" name="parent_mobile" required placeholder="Parent Mobile">
    </div>

    <div class="input-group">
        <input type="email" name="parent_email" required placeholder="Parent Email">
    </div>

    <button type="submit">Sign Up</button>

    <?php if($msg != "") { ?>
        <p style="color:red; text-align:center;"><?php echo $msg; ?></p>
    <?php } ?>

    <p class="login-link">
        Already have an account? <a href="login.php">Login</a>
    </p>

</form>

</div>

</body>
</html>