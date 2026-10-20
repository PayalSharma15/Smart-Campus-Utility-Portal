<?php
session_start();
include("../db.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];

// ✅ Fetch teacher name from DB
$res = mysqli_query($conn, "SELECT name FROM teachers WHERE id='$teacher_id'");
$data = mysqli_fetch_assoc($res);

$teacher_name = $data['name'] ?? "Teacher";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI';
            background: #f4f6f9;
            margin: 0;
        }

        .navbar {
            background: #2e7d32;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
        }

        .container {
            padding: 40px;
        }

        .card {
            width: 250px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background: #2e7d32;
            color: white;
            border-radius: 20px;
            text-decoration: none;
        }

        .card a:hover {
            background: #1b5e20;
        }
    </style>
    <link rel="stylesheet" href="../CSS/dashboard.css">
</head>
<body>

<div class="navbar">
    <h2>Teacher Panel</h2>
    <div>
        <a href="../logout.php" style="color:white;">Logout</a>
    </div>
</div>

<div class="container">

<h2>Welcome, <?php echo $teacher_name; ?> 👨‍🏫</h2>
<div class="cards">

    <div class="card">
        <h3>📚 Student Attendance</h3>
        <p>Mark student attendance</p>
        <a href="teacher_student_attendance.php">Take Attendance</a>
    </div>

    <div class="card">
        <h3>📚 Notes / Question Bank</h3>
        <p>Upload notes for students</p>
        <a href="add_notes.php">Upload Notes</a>
    </div>
    <div class="card">
    <h3>📊 My Attendance</h3>
    <p>Check your attendance status.</p>
    <a href="view_attendance.php">View</a>
    </div>

    <div class="card">
    <h3>👤 My Profile</h3>
    <p>View and update your profile.</p>
    <a href="teacher_profile.php" class="btn">View Profile</a>
</div>

</div>

</body>
</html>