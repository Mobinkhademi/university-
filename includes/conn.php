<?php
//$mysqli = mysqli_connect("localhost", "root", "", "university");
$mysqli = new mysqli("localhost", "root", "", "university");
if ($mysqli->connect_error) {
    echo mysqli_connect_error();
}

?>
