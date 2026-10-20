<?php
include("../db.php");

// ✅ ID check
if(!isset($_GET['id'])){
    header("Location: manage_students.php");
    exit();
}

$id = $_GET['id'];

// ✅ UPDATE
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $parent_email = $_POST['parent_email'];   // ⭐ NEW

    $query = "UPDATE students 
              SET name='$name', 
                  email='$email', 
                  parent_mobile='$mobile',
                  parent_email='$parent_email'
              WHERE id=$id";

    mysqli_query($conn, $query) or die(mysqli_error($conn));

    // 🔥 redirect
    header("Location: manage_students.php");
    exit();
}

// ✅ FETCH DATA
$result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if(!$row){
    echo "Student not found!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="../CSS/edit_student.css">
</head>
<body>

<div class="navbar">
    <h2>Smart Campus - Admin</h2>
    <div>
        <a href="manage_students.php">Back</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <div class="card">
        <h2>✏️ Edit Student</h2>

        <form method="POST">

            <!-- Name -->
            <input type="text" name="name" 
            value="<?php echo $row['name']; ?>" required>

            <!-- Student Email -->
            <input type="email" name="email" 
            value="<?php echo $row['email']; ?>" required>

            <!-- Parent Mobile -->
            <input type="text" name="mobile" 
            value="<?php echo $row['parent_mobile']; ?>" required>

            <!-- ⭐ Parent Email -->
            <input type="email" name="parent_email" 
            value="<?php echo $row['parent_email']; ?>" 
            placeholder="Parent Email" required>

            <button type="submit" name="update">Update</button>

        </form>
    </div>

</div>

</body>
</html>