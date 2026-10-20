<?php
session_start();

// Student logout
if(isset($_SESSION['user'])){
    session_unset();
    session_destroy();

    // ✅ correct path
    header("Location: login.php");
    exit();
}

// Admin logout
elseif(isset($_SESSION['admin'])){
    session_unset();
    session_destroy();

    header("Location: ../admin/admin_login.php");
    exit();
}

// No session
else{
    header("Location: login.php");
    exit();
}
?>