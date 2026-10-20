<?php
include("../db.php");

$students = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="../css/attendance.css">
</head>
<body>

<div class="container">
    <h2>Mark Attendance</h2>

    <form method="post">
        <label>Subject:</label>
        <input type="text" name="subject" required>

        <label>Date:</label>
        <input type="date" name="date" required>

        <table>
            <tr>
                <th>Student Name</th>
                <th>Present</th>
                <th>Absent</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($students)) { ?>
            <tr>
                <td><?= $row['name']; ?></td>
                <td>
                    <input type="radio" name="status[<?= $row['id']; ?>]" value="Present" required>
                </td>
                <td>
                    <input type="radio" name="status[<?= $row['id']; ?>]" value="Absent">
                </td>
            </tr>
            <?php } ?>
        </table>

        <button type="submit" name="submit">Save Attendance</button>
    </form>
</div>

</body>
</html>

<?php
if(isset($_POST['submit'])){

    $subject = $_POST['subject'];
    $date    = $_POST['date'];

    foreach($_POST['status'] as $student_id => $status){

        // 1️⃣ Attendance insert
        mysqli_query($conn,
            "INSERT INTO attendance (student_id, subject, date, status)
             VALUES ('$student_id','$subject','$date','$status')"
        );

        // 2️⃣ Parent notification ONLY if Absent
        if($status == 'Absent'){

            $q = "SELECT name, parent_mobile FROM students WHERE id='$student_id'";
            $res = mysqli_query($conn, $q);
            $row = mysqli_fetch_assoc($res);

            $student_name  = $row['name'];
            $parent_mobile = $row['parent_mobile'];
            $message = "Your child $student_name is absent today.";

            mysqli_query($conn,
    "INSERT INTO notifications (student_id, parent_mobile, message, date, status)
     VALUES ('$student_id','$parent_mobile','$message', NOW(), 'Sent')"
);
        }
    }

    echo "<p class='success'>Attendance Saved & Parents Notified</p>";
}
?>
