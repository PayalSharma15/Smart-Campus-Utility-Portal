<?php
session_start();
include("../db.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: login.php");
    exit();
}

$msg = "";

if(isset($_POST['upload'])){
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $teacher_id = $_SESSION['teacher_id'];

    $file = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];

    // Upload file
    move_uploaded_file($tmp, "../uploads/".$file);

    // Insert in DB
    mysqli_query($conn, "
        INSERT INTO notes (teacher_id, title, description, file)
        VALUES ('$teacher_id','$title','$desc','$file')
    ");

    $msg = "✅ Notes Uploaded Successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Notes</title>
    <link rel="stylesheet" href="../CSS/add_notes.css">
    
    <!-- CSS LINK -->
</head>

<body>

<div class="navbar">📚 Upload Notes</div>
<a href="dashboard.php" class="back-btn">⬅ Back</a>

<div class="container">
    <div class="card">

        <h2>Upload Notes / Question Bank</h2>

        <form method="POST" enctype="multipart/form-data">

            <input type="text" name="title" placeholder="Enter Title" required>

            <textarea name="description" placeholder="Enter Description"></textarea>

            <input type="file" name="file" required>

            <button name="upload">Upload Notes</button>

        </form>

        <div class="msg"><?php echo $msg; ?></div>

    </div>
</div>

</body>
</html>