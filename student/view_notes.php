<?php
include("../db.php");

$result = mysqli_query($conn, "SELECT * FROM notes ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notes / Question Bank</title>
    <link rel="stylesheet" href="../CSS/view_notes.css">
</head>
<body>

<div class="navbar">📚 Notes / Question Bank</div>

<a href="dashboard.php" class="back-btn">⬅ Back</a>

<div class="container">
    <div class="card">

        <h2>📚 Available Notes</h2>

        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>File</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>
                    <a href="open_note.php?id=<?php echo $row['id']; ?>"target="_blank" class="view-btn">View</a>
                    <a href="../uploads/<?php echo $row['file']; ?>" download class="download-btn">Download</a>
                </td>
            </tr>
            <?php } ?>

        </table>

    </div>
</div>

</body>
</html>