<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../CSS/admin_dashboard.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2>Smart Campus - Admin</h2>
    <div>
        <a href="view_complaints.php">Complaints</a>
        <a href="view_attendance.php">Attendance</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<!-- Welcome Card -->
<div class="welcome">
    <h1>Welcome Admin 👨‍💼</h1>
    <p>Manage complaints, attendance and students easily.</p>
</div>

<!-- Cards Section -->
<div class="cards">

    <div class="card">
        <h3>📋 View Complaints</h3>
        <p>Check and update student complaints.</p>
        <a href="view_complaints.php">Go</a>
    </div>

    <div class="card">
        <h3>📊 View Attendance</h3>
        <p>Monitor student attendance records.</p>
        <a href="view_attendance.php">Go</a>
    </div>

    <div class="card">
        <h3>🎓 Manage Students</h3>
        <p>Add or manage student data.</p>
        <a href="manage_students.php">Go</a>
    </div>

    <!-- ✅ SAME CONTAINER -->
    <div class="card teacher">
        <h3>👨‍🏫 Teacher Attendance</h3>
        <p>Mark daily attendance</p>
        <a href="teacher_attendance.php">Go</a>
    </div>
    <div class="card">
    <h3>👨‍🏫 Add Teacher</h3>
    <p>Register new teacher</p>
    <a href="add_teacher.php">Go</a>
</div>

</div>
</body>
</html>