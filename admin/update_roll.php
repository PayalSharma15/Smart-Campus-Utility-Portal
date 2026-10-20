<?php
include("../db.php");

$result = mysqli_query($conn, "
    SELECT * FROM students
    ORDER BY 
        SUBSTRING_INDEX(name, ' ', 1),
        SUBSTRING_INDEX(name, ' ', -1)
");

$roll = 1;

while($row = mysqli_fetch_assoc($result)){
    mysqli_query($conn, "
        UPDATE students 
        SET roll_no='$roll' 
        WHERE id='".$row['id']."'
    ");
    $roll++;
}

echo "Roll Numbers Updated!";
?>