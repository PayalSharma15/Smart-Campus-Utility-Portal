<?php
include("../db.php");

$result = mysqli_query($conn, "SELECT * FROM notifications ORDER BY date DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Parent Notifications</title>
<style>
table{
    width:90%;
    margin:auto;
    border-collapse:collapse;
}
th,td{
    border:1px solid #000;
    padding:10px;
    text-align:center;
}
th{
    background:#333;
    color:white;
}
</style>
</head>
<body>

<h2 style="text-align:center;">Parent Notification Report</h2>
<link rel="stylesheet" href="../admin/view_complaint.css">
<table>
<tr>
    <th>ID</th>
    <th>Student ID</th>
    <th>Parent Contact</th>
    <th>Message</th>
    <th>Date</th>
    <th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['student_id'] ?></td>
<td><?= $row['parent_contact'] ?></td>
<td><?= $row['message'] ?></td>
<td><?= $row['date'] ?></td>
<td><?= $row['status'] ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>
