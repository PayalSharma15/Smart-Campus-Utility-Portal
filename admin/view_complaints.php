<?php
session_start();
include("../db.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// ✅ FIXED QUERY
$query = "
SELECT complaints.id,
       students.name,
       complaints.title,
       complaints.description,
       complaints.status
FROM complaints
JOIN students ON complaints.student_id = students.id
ORDER BY complaints.created_at DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Complaints</title>
    <link rel="stylesheet" href="../CSS/view_complaints.css">
</head>
<body>
<div class="navbar">
    <h2>Smart Campus - Admin </h2>

    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>


<div class="container">

<h2 class="title">📋 Student Complaints</h2>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Title</th>
    <th>Description</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['description']; ?></td>

    <td class="<?php echo strtolower($row['status']); ?>">
        <?php echo $row['status']; ?>
    </td>

    <td>
        <?php if($row['status'] == 'Pending') { ?>
            <a href="update_status.php?id=<?php echo $row['id']; ?>" class="btn-resolve">
                Resolve
            </a>
        <?php } else { ?>
            <span style="color:green;">✔ Done</span>
        <?php } ?>
    </td>

</tr>
<?php } ?>

</table>

</div>

</body>
</html>