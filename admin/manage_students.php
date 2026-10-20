<?php
session_start();
include("../db.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>
    <link rel="stylesheet" href="../CSS/manage_students.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2> Smart Campus - Admin</h2>
    <div class="nav-links">
        <a href="dashboard.php"> Dashboard</a>
        <a href="../logout.php"> Logout</a>
    </div>
</div>

<!-- Page Title + Button -->
<div class="top-bar">
    <h1>👨‍🎓 Manage Students</h1>
    <a href="add_student.php" class="add-btn">+ Add Student</a>
</div>

<!-- Table Card -->
<div class="card">

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Mobile</th>
    <th>Parent Email</th> <!-- ⭐ NEW -->
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['parent_mobile']; ?></td>
    <td><?php echo $row['parent_email']; ?></td> <!-- ⭐ NEW -->

    <td>
        <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
        <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="delete-btn">Delete</a>
    </td>
</tr>
<?php } ?>

</table>

</div>

</body> 
</html>