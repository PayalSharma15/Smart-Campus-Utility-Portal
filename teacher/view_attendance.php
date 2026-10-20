<?php
session_start();
include("../db.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];

$result = mysqli_query($conn, "
    SELECT * FROM teacher_attendance 
    WHERE teacher_id='$teacher_id'
    ORDER BY date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Attendance</title>
    <link rel="stylesheet" href="../CSS/view_attendanceStyle.css">
</head>

<body>

<!-- Navbar -->
<div class="navbar">
    <span class="nav-title">📊 My Attendance</span>
</div>
<a href="dashboard.php" class = "back-btn">⬅ Back</a>


<!-- Container -->
 <br></br>
<div class="container">
    <div class="card">

        <h2 class="title">📊 My Attendance</h2>

        <table class="attendance-table">
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>

            <?php if(mysqli_num_rows($result) > 0) { ?>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td>📅 <?php echo $row['date']; ?></td>
                    <td>
                        <?php if($row['status'] == 'Present') { ?>
                            <span class="present">✔ Present</span>
                        <?php } else { ?>
                            <span class="absent">✖ Absent</span>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="2">No attendance found</td>
                </tr>
            <?php } ?>
        </table>

    </div>
</div>

</body>
</html>