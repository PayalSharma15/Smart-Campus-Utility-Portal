<?php
include("../db.php");

/* ✅ SAVE ATTENDANCE */
if(isset($_POST['save'])){
    $date = $_POST['date'];

    foreach($_POST['status'] as $teacher_id => $status){

        $check = mysqli_query($conn, "
            SELECT * FROM teacher_attendance 
            WHERE teacher_id='$teacher_id' AND date='$date'
        ");

        if(mysqli_num_rows($check) > 0){
            mysqli_query($conn, "
                UPDATE teacher_attendance 
                SET status='$status' 
                WHERE teacher_id='$teacher_id' AND date='$date'
            ");
        } else {
            mysqli_query($conn, "
                INSERT INTO teacher_attendance (teacher_id, date, status)
                VALUES ('$teacher_id', '$date', '$status')
            ");
        }
    }

    echo "<script>alert('Attendance Saved Successfully!')</script>";
}

/* ✅ ONLY TEACHERS FETCH */
$result = mysqli_query($conn, "SELECT * FROM teachers");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Attendance</title>
    <link rel="stylesheet" href="../CSS/teacher_attendance.css">
</head>
<body>

<div class="navbar">
    <h2>Smart Campus - Admin</h2>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">

<div class="card">
    <h2 >📅 Teacher Attendance</h2>

    <form method="POST">

        <!-- Date -->
        <div class="top-bar">
            <input type="date" name="date" required>
        </div>

        <!-- Table -->
        <table>
            <tr>
                <th>Teacher Name</th>
                <th>Status</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td>
                    <label>
                        <input type="radio" name="status[<?php echo $row['id']; ?>]" value="Present" required>
                        Present
                    </label>

                    <label>
                        <input type="radio" name="status[<?php echo $row['id']; ?>]" value="Absent">
                        Absent
                    </label>
                </td>
            </tr>
            <?php } ?>

        </table>

        <!-- Button -->
        <button name="save" class="save-btn">💾 Save Attendance</button>

    </form>
</div>

</div>

</body>
</html>