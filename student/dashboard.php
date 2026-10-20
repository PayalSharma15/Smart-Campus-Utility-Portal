<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link rel="stylesheet" href="../CSS/dashboard.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2>Smart Campus</h2>
    <div class="nav-links">
    <a href="logout.php">Logout</a>
</div>
</div>

<!-- Main Content -->
<div class="container">

    <div class="welcome-card">
        <h1>Welcome 👋</h1>
        <p><?php echo $user; ?></p>
    </div>

    <div class="cards">

        <div class="card">
            <h3>Submit Complaint</h3>
            <p>Report campus issues easily.</p>
            <a href="../student/complaint.php">Go</a>
        </div>

        <div class="card">
            <h3>View Attendance</h3>
            <p>Check your attendance records.</p>
           <a href="../student/Attendance.php">Go</a>
        </div>

        <div class="card">
            <h3>Profile</h3>
            <p>Manage your account details.</p>
            <a href="../student/profile.php">Go</a>
        </div>
        <div class="card">
    <h3>📚 Notes / Question Bank</h3>
    <p>View notes uploaded by teachers.</p>
    <a href="view_notes.php">Go</a>
</div>

    </div>

</div>

</body>
</html>