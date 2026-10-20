<?php
session_start();
include("../db.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['teacher_id'];

// Fetch teacher data
$result = mysqli_query($conn, "SELECT * FROM teachers WHERE id='$id'") or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($result);


// ================= UPDATE PROFILE =================
if(isset($_POST['update'])){
    
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];

    $updateQuery = "UPDATE teachers 
                    SET name='$name', mobile='$mobile' 
                    WHERE id='$id'";

    if(mysqli_query($conn, $updateQuery)){
        echo "<script>alert('Profile Updated Successfully'); window.location='teacher_profile.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


// ================= CHANGE PASSWORD =================
if(isset($_POST['change_pass'])){
    
    $new_pass = $_POST['new_password'];

    if($new_pass == ""){
        echo "<script>alert('Password cannot be empty');</script>";
    } else {

        // (Simple version – no hash for now, so login works)
        $passQuery = "UPDATE teachers 
                      SET password='$new_pass' 
                      WHERE id='$id'";

        if(mysqli_query($conn, $passQuery)){
            echo "<script>alert('Password Changed Successfully'); window.location='teacher_profile.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>👤My Profile</title>
    <link rel="stylesheet" href="../CSS/teacher_profile.css">
</head>

<body>

<!-- Navbar -->
<div class="navbar">
    <h2>👤Teacher Profile</h2>
    <div class="nav-links">  </div>
</div>
<a href="dashboard.php" class = "back-btn">⬅ Back</a>    

<!-- Title -->
<h2 class="page-title">👤 My Profile</h2>

<div class="container">

    <!-- Profile Card -->
    <div class="card">
        <form method="POST">

            <label>Name</label>
            <input type="text" name="name" value="<?php echo $row['name']; ?>" required>

            <label>Email (cannot change)</label>
            <input type="email" value="<?php echo $row['email']; ?>" readonly>

            <label>Mobile Number</label>
            <input type="text" name="mobile" value="<?php echo $row['mobile']; ?>" required>

            <button type="submit" name="update" class="btn">Update Profile</button>

        </form>
    </div>

    <!-- Password Card -->
    <div class="card">
        <form method="POST">

            <label>New Password</label>
            <input type="password" name="new_password" placeholder="Enter new password" required>

            <button type="submit" name="change_pass" class="btn">Change Password</button>

        </form>
    </div>

</div>

</body>
</html>