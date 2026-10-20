<?php
session_start();
include("../db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $email = $_SESSION['user'];

    // 🔍 get user id from students table
    $email = $_SESSION['user'];

$res = mysqli_query($conn, "SELECT id FROM students WHERE email='$email'");
$row = mysqli_fetch_assoc($res);
$student_id = $row['id'];

$query = "
INSERT INTO complaints (student_id, title, description)
VALUES ('$student_id', '$title', '$description')
";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Complaint Submitted Successfully');</script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Complaint</title>
    <link rel="stylesheet" href="../CSS/student_complaint.css">
</head>

<body>

<!-- Navbar -->
<div class="navbar">
    <h2>Smart Campus</h2>

    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>
<!-- Page Title -->
<h2 class="page-title">📝 Submit Your Complaint</h2>

<!-- Form Card -->
<div class="container">
    <div class="card">

        <form method="POST">

            <label>Complaint Title</label>
            <input type="text" name="title" required>

            <label>Description</label>
            <textarea name="description" rows="5" required></textarea>

            <button type="submit" name="submit">Submit Complaint</button>

        </form>

    </div>
</div>

</body>
</html>