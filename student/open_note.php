
<?php
include("../db.php");

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    exit("Invalid note ID.");
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare($conn, "SELECT file FROM notes WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$note = mysqli_fetch_assoc($result);

if (!$note) {
    exit("Note not found in database.");
}

$filename = basename($note['file']);
$uploadDir = realpath(__DIR__ . "/../uploads");
$path = $uploadDir ? realpath($uploadDir . DIRECTORY_SEPARATOR . $filename) : false;

if (!$path || !$uploadDir || dirname($path) !== $uploadDir ||
    !is_file($path) || !is_readable($path)) {
    http_response_code(404);
    exit("File not found in uploads folder.");
}

$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

$mimeTypes = [
    'pdf' => 'application/pdf',
    'txt' => 'text/plain',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png'
];

if (!isset($mimeTypes[$extension])) {
    exit("Preview is supported for PDF, TXT, JPG and PNG files only.");
}

header("Content-Type: " . $mimeTypes[$extension]);
header('Content-Disposition: inline; filename="' . $filename . '"');
header("X-Content-Type-Options: nosniff");

readfile($path);
exit;
?>

