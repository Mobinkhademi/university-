<?php
include("includes/conn.php");
$name = $_POST["name"];
$lastname = $_POST["lastname"];
$phone = $_POST["phone"];
$username = $_POST["username"];
$password = $_POST["password"];
$num = random_int(1000,9999);
$sql = "select * from students where student_id= '$num' ";
$result = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result)>0){
    $student_id = random_int(1000,9999);
}
else{
    $student_id = $num;
}

$sqlins = "INSERT INTO `students`( `student_id`, `name`, `family`, `phone`,  `username`, `password`) VALUES ('$student_id','$name','$lastname','$phone','$username','$password')";
mysqli_query($mysqli,$sqlins);
echo mysqli_error($mysqli);
echo "sabt shod";

?>