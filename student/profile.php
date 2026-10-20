<?php
session_start();
include("../db.php");

// 🔐 Login check
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];
$msg = "";

/* =========================
   UPDATE PROFILE
========================= */
if(isset($_POST['update'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $mobile = mysqli_real_escape_string($conn, $_POST['parent_mobile']);

    mysqli_query($conn, "
        UPDATE students 
        SET name='$name', parent_mobile='$mobile' 
        WHERE email='$email'
    ");

    header("Location: profile.php?success=1");
    exit();
}

/* =========================
   CHANGE PASSWORD
========================= */
if(isset($_POST['change_password'])){

    $new_pass = $_POST['new_password'];

    if(!empty($new_pass)){

        // 🔥 HASH PASSWORD (MOST IMPORTANT)
        $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

        mysqli_query($conn, "
            UPDATE students 
            SET password='$hashed_password' 
            WHERE email='$email'
        ");

        header("Location: profile.php?pass=1");
        exit();
    }
}

/* =========================
   FETCH USER DATA
========================= */
$result = mysqli_query($conn, "SELECT * FROM students WHERE email='$email'");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="../CSS/profile.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2>👤 My Profile</h2>
</div>

<a href="dashboard.php" class="back-btn">⬅ Back</a>

<div class="container">

    <h2 class="title"></h2>

    <!-- ✅ SUCCESS MESSAGES -->
    <?php if(isset($_GET['success'])) { ?>
        <p class="success">Profile Updated Successfully!</p>
    <?php } ?>

    <?php if(isset($_GET['pass'])) { ?>
        <p class="success">Password Changed Successfully!</p>
    <?php } ?>

    <!-- 🔵 PROFILE UPDATE -->
    <form method="POST" class="profile-box">

        <label>Name</label>
        <input type="text" name="name" value="<?php echo $data['name']; ?>" required>

        <label>Email (cannot change)</label>
        <input type="email" value="<?php echo $data['email']; ?>" disabled>

        <label>Mobile Number</label>
        <input type="text" name="parent_mobile" value="<?php echo $data['parent_mobile']; ?>" required>

        <button type="submit" name="update">Update Profile</button>

    </form>

    <!-- 🔴 CHANGE PASSWORD -->
    <form method="POST" class="profile-box" style="margin-top:20px;">

        <label>New Password</label>
        <input type="password" name="new_password" required>

        <button type="submit" name="change_password">Change Password</button>

    </form>

</div>

</body>
</html>