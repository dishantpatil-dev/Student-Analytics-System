<?php
include 'includes/session.php';
include 'includes/db.php';

if(isset($_GET['id']))
{
$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM students WHERE id='$id'");

header("Location: students.php");
exit();
}
?>