<?php
session_start();
include("../db.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$msg = "";

if(isset($_POST['add'])){
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    // ✅ Check if email already exists
    $check = "SELECT * FROM students WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0){
        $msg = "⚠️ Student already exists with this email!";
    } else {

        // ✅ Insert student
        $query = "INSERT INTO students (name, email, password, parent_mobile) 
                  VALUES ('$name', '$email', '$password', '$mobile')";

        if(mysqli_query($conn, $query)){
            $msg = "✅ Student Added Successfully!";
            
            // 🔥 form reset
            $_POST = array();
        } else {
            $msg = "❌ Error: " . mysqli_error($conn);
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="../CSS/add_student.css">
</head>
<body>

<div class="container">

    <div class="card">
        <h2>➕ Add Student</h2>

        <form method="POST">

            <input type="text" name="name" placeholder="Enter Name" required>

            <input type="email" name="email" placeholder="Enter Email" required>

            <input type="text" name="mobile" placeholder="Enter Mobile" required>

            <input type="password" name="password" placeholder="Enter Password" required>

            <button name="add">Add Student</button>

            <?php if($msg != "") { ?>
                <p class="success"><?php echo $msg; ?></p>
            <?php } ?>

        </form>
        <a href="manage_students.php" class="back-btn">⬅ Back</a>
    </div>

</div>

</body>
</html>