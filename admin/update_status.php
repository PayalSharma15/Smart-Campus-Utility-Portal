<?php
include("../db.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    mysqli_query($conn, "UPDATE complaints SET status='Resolved' WHERE id='$id'");

    header("Location: view_complaints.php"); // 👈 same folder
    exit();
}
?>