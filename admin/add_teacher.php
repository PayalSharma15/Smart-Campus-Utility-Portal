<?php
include("../db.php");

$msg = "";

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $subject = $_POST['subject'];

    // 🔥 HASH PASSWORD (VERY IMPORTANT)
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // check duplicate email
    $check = mysqli_query($conn, "SELECT * FROM teachers WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){
        $msg = "⚠️ Teacher already exists!";
    } else {
        $query = "INSERT INTO teachers (name, email, mobile, subject, password)
                  VALUES ('$name','$email','$mobile','$subject','$password')";

        if(mysqli_query($conn, $query)){
            $msg = "✅ Teacher Added Successfully!";
        } else {
            $msg = "❌ Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Teacher</title>
    <link rel="stylesheet" href="../CSS/add_teacher.css">
</head>
<body>



<!-- ✅ Back Button -->
<a href="dashboard.php" class="back-btn">⬅ Back</a>

<div class="container">
    <div class="card">
        <h2>👨‍🏫 Add Teacher</h2>

        <form method="POST">
            <input type="text" name="name" placeholder="Enter Name" required>
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="text" name="mobile" placeholder="Enter Mobile" required>
            <input type="text" name="subject" placeholder="Enter Subject" required>

            <!-- ✅ Password Field -->
            <input type="password" name="password" placeholder="Enter Password" required>

            <button name="add">Add Teacher</button>
        </form>

        <!-- Message -->
        <div class="msg"><?php echo $msg; ?></div>
    </div>
</div>

</body>
</html>