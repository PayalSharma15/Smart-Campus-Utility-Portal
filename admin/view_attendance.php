<?php
session_start();
include("../db.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// ✅ JOIN query (IMPORTANT FIX)
$result = mysqli_query($conn, "
    SELECT attendance.*, students.name AS student_name
    FROM attendance
    JOIN students ON attendance.student_id = students.id
    ORDER BY attendance.date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Attendance</title>
   <link rel="stylesheet" href="../CSS/view_attendance.css">
</head>

<body>
<div class="navbar">
    <h2> Smart Campus - Admin</h2>
    <div class="nav-links">
        <a href="dashboard.php"> Dashboard</a>
        <a href="../logout.php"> Logout</a>
    </div>
</div>
<div class="title">📊 Student Attendance Report</div>

<div class="card">

<table>
    <tr>
        <th>ID</th>
        <th>Student Name</th>
        <th>Subject</th>
        <th>Date</th>
        <th>Status</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>

        <!-- ✅ FIXED -->
        <td><?php echo $row['student_name']; ?></td>

        <td><?php echo $row['subject']; ?></td>
        <td><?php echo $row['date']; ?></td>

        <td>
            <?php if(strtolower($row['status']) == 'present') { ?>
                <span class="present">✔ Present</span>
            <?php } else { ?>
                <span class="absent">✖ Absent</span>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>

</table>

</div>

</body>
</html>              