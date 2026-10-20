<?php
session_start();
include("../db.php");

// 🔐 Login check
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];

// 🔍 Get student ID
$res = mysqli_query($conn, "SELECT id FROM students WHERE email='$email'");
$user = mysqli_fetch_assoc($res);
$student_id = $user['id'];

// 📊 Fetch only this student's attendance
$query = "
SELECT subject, date, status
FROM attendance
WHERE student_id = '$student_id'
ORDER BY date DESC
";

$result = mysqli_query($conn, $query);

if(!$result){
    die(mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Attendance</title>
    <link rel="stylesheet" href="../CSS/student_attendance.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2>📊 My Attendance</h2>
</div>
<a href="dashboard.php" class="back-btn">⬅ Back</a>

<div class="container">

    <h2 class="title">Attendance List</h2>

    <table class="attendance-table">
        <tr>
            <th>Subject</th>
            <th>Date</th>
            <th>Status</th>
        </tr>

        <?php 
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td class="<?php echo strtolower($row['status']); ?>">
                        <?php echo $row['status']; ?>
                    </td>
                </tr>
        <?php } 
        } else { ?>
            <tr>
                <td colspan="3">No attendance found</td>
            </tr>
        <?php } ?>
    </table>

</div>

</body>
</html>