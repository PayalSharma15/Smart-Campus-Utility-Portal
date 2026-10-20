
<?php
include('../db.php'); // apna DB connection path check karna

$sql = "
SELECT 
    attendance.id,
    students.name,
    attendance.subject,
    attendance.date,
    attendance.status
FROM attendance
JOIN students ON attendance.student_id = students.id
WHERE attendance.status = 'Absent'
ORDER BY attendance.date DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Absent Students Report</title>
    <link rel="stylesheet" href="../admin/view_complaint.css">
</head>
<body>

<h2 style="text-align:center;">Absent Students Report</h2>

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
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['subject'] ?></td>
        <td><?= $row['date'] ?></td>
        <td style="color:red;font-weight:bold;"><?= $row['status'] ?></td>
    </tr>
    <?php } ?>

</table>
<div style="text-align:center; margin-top:20px;">
<a href="dashboard.php" class="btn">Back to Dashboard</a>
</div>


</body>
</html>
