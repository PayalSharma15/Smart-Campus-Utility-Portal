<?php
session_start();
include("../db.php");

/* PHPMailer */
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

if(!isset($_SESSION['teacher_id'])){
    header("Location: login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];

/* FETCH TEACHER */
$teacher_query = mysqli_query($conn, "SELECT * FROM teachers WHERE id='$teacher_id'");
$teacher = mysqli_fetch_assoc($teacher_query);

$subject = $teacher['subject'];

if(empty($subject)){
    die("Subject not assigned!");
}

/* DATE */
$date = date('Y-m-d');

/* SAVE ATTENDANCE */
if(isset($_POST['save']) && isset($_POST['status'])){

    foreach($_POST['status'] as $student_id => $status){

        $student_id = (int)$student_id;
        $status = mysqli_real_escape_string($conn, $status);

        $check = mysqli_query($conn, "
            SELECT id FROM attendance 
            WHERE student_id='$student_id' 
            AND date='$date' 
            AND subject='$subject'
        ");

        if(mysqli_num_rows($check) > 0){

            mysqli_query($conn, "
                UPDATE attendance 
                SET status='$status' 
                WHERE student_id='$student_id' 
                AND date='$date' 
                AND subject='$subject'
            ");

        } else {

            mysqli_query($conn, "
                INSERT INTO attendance (student_id, date, subject, status)
                VALUES ('$student_id', '$date', '$subject', '$status')
            ");
        }

        /* 🔥 MAIL ONLY IF ABSENT */
        if(strtolower(trim($status)) == "absent"){

            $student_q = mysqli_query($conn, "
                SELECT name, parent_email FROM students WHERE id='$student_id'
            ");

            $student = mysqli_fetch_assoc($student_q);

            if(!empty($student['parent_email'])){

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'payalbhimsharma03@gmail.com';
                    $mail->Password = 'mrjhevatzulvfqxc';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('payalbhimsharma03@gmail.com', 'Smart Campus');
                    $mail->addAddress($student['parent_email']);

                    $mail->isHTML(true);
                    $mail->Subject = 'Student Absence Alert';
                    $mail->Body = "
                        Dear Parent,<br><br>
                        Your child <b>{$student['name']}</b> is marked 
                        <b style='color:red;'>ABSENT</b>.<br>
                        Subject: <b>$subject</b><br>
                        Date: <b>$date</b><br><br>
                        Regards,<br>Smart Campus
                    ";

                    $mail->send();

                } catch (Exception $e) {
                    echo "Mail Error: " . $mail->ErrorInfo;
                }
            }
        }
    }

    /* ✅ ALERT + REDIRECT (FIXED) */
    echo "<script>
        alert('Attendance Saved Successfully');
        window.location.href='teacher_student_attendance.php';
    </script>";
    exit();
}

/* FETCH STUDENTS */
$result = mysqli_query($conn, "SELECT * FROM students ORDER BY roll_no ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Attendance</title>
    <link rel="stylesheet" href="../CSS/student_attendance.css">
</head>
<body>

<div class="container">
    <div class="card">

        <a href="dashboard.php"
         class="back-btn">⬅ Back</a>

        <h2>📚 Student Attendance</h2>

        <form method="POST">
       <br></br>
        <div class="top-bar">
            <span>Subject: <b><?php echo $subject; ?></b></span>
            <input type="date"
       name="date"
       value="<?php echo date('Y-m-d'); ?>">
        </div>

        <button type="button" onclick="markAllPresent()" class="mark-btn">
            ✔ Mark All Present
        </button>

        <table>
            <tr>
                <th>Roll No</th>
                <th>Name</th>
                <th>Status</th>
            </tr>

<?php
while($row = mysqli_fetch_assoc($result)){

    $student_id = $row['id'];

    $att = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT status FROM attendance 
        WHERE student_id='$student_id' 
        AND date='$date' 
        AND subject='$subject'
    "));

    $status = $att['status'] ?? "";
?>

<tr>
    <td><?php echo $row['roll_no'] ?? "-"; ?></td>
    <td><?php echo $row['name']; ?></td>

    <td>
        <label>
            <input type="radio" name="status[<?php echo $student_id; ?>]" value="Present"
            <?php if($status=="Present") echo "checked"; ?>>
            Present
        </label>

        <label>
            <input type="radio" name="status[<?php echo $student_id; ?>]" value="Absent"
            <?php if($status=="Absent") echo "checked"; ?>>
            Absent
        </label>
    </td>
</tr>

<?php } ?>

        </table>

        <button type="submit" name="save" class="save-btn">💾 Save Attendance</button>

        </form>

    </div>
</div>

<script>
function markAllPresent(){
    let radios = document.querySelectorAll("input[value='Present']");
    radios.forEach(r => r.checked = true);
}
</script>

</body>
</html>