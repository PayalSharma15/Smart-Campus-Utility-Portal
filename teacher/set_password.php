<?php
session_start();
include("../db.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['teacher_id'];

if(isset($_POST['save'])){

    // ✅ HASH PASSWORD
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $update = mysqli_query($conn, "
        UPDATE teachers 
        SET password='$password', is_password_set=1 
        WHERE id='$id'
    ");

    if($update){
        echo "Password Updated Successfully!";
    } else {
        echo mysqli_error($conn);
    }

    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set Password</title>
</head>
<body>

<h2>Set Your Password</h2>

<form method="POST">
    <input type="password" name="password" placeholder="Enter New Password" required>
    <button type="submit" name="save">Save Password</button>
</form>

</body>
</html>