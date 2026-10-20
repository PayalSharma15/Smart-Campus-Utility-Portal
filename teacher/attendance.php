<?php
include("../db.php");
require_once __DIR__ . "/../send_mail.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Take Attendance</title>
</head>
<body>

<h2>Take Attendance</h2>

<form method="POST">

<?php
$result = mysqli_query($conn, "SELECT * FROM students");

while($row = mysqli_fetch_assoc($result)){
?>

    <input type="hidden" name="student_id[]" value="<?php echo $row['id']; ?>">

    <p>
        <?php echo $row['name']; ?> :

        <select name="status[]">
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
        </select>
    </p>

<?php } ?>

<button type="submit" name="submit">
    Submit Attendance
</button>

</form>

<?php

if(isset($_POST['submit'])){

    $student_ids = $_POST['student_id'];
    $statuses = $_POST['status'];

    for($i = 0; $i < count($student_ids); $i++){

        $sid = $student_ids[$i];
        $status = trim($statuses[$i]);

        // ✅ SAVE ATTENDANCE
        $insert = mysqli_query($conn, "
            INSERT INTO attendance(student_id, status, date)
            VALUES('$sid', '$status', CURDATE())
        ");

        if(!$insert){
            die(mysqli_error($conn));
        }

        // ✅ IF ABSENT SEND MAIL
        if(strtolower($status) == "absent"){

            // ✅ FETCH STUDENT
            $res = mysqli_query($conn, "
                SELECT name, parent_email
                FROM students
                WHERE id='$sid'
            ");

            if(!$res){
                die(mysqli_error($conn));
            }

            $data = mysqli_fetch_assoc($res);

            // ✅ CHECK EMAIL
            if(!empty($data['parent_email'])){

                echo "Sending Mail To: ".$data['parent_email']."<br>";

                // ✅ SEND MAIL
                $mail = sendMail(
                    $data['parent_email'],
                    $data['name']
                );

                if($mail){
                    echo "MAIL SENT SUCCESSFULLY<br><br>";
                }else{
                    echo "MAIL FAILED<br><br>";
                }

            } else {

                echo "Parent email not found for ".$data['name']."<br><br>";
            }
        }
    }

    echo "<h3>Attendance Submitted Successfully</h3>";
}
?>

</body>
</html>