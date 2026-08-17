<?php
include 'includes/session.php';
include 'includes/db.php';

if(isset($_POST['save']))
{

$student_name=$_POST['student_name'];
$roll=$_POST['roll_no'];
$class=$_POST['class'];
$gender=$_POST['gender'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$address=$_POST['address'];

$photo="";

if($_FILES['photo']['name']!="")
{
$photo=time().$_FILES['photo']['name'];
move_uploaded_file($_FILES['photo']['tmp_name'],"uploads/".$photo);
}

mysqli_query($conn,"INSERT INTO students(student_name,roll_no,gender,class,division,dob,phone,email,address,photo)
VALUES('$student_name','$roll','$gender','$class','','','$phone','$email','$address','$photo')");

header("Location: students.php");
exit();

}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="main-content">

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid">

<div class="card p-4">

<h2 class="mb-4">Add Student</h2>

<form method="POST" enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-3">
<label>Name</label>
<input type="text" name="student_name" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Roll No</label>
<input type="text" name="roll_no" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Class</label>
<input type="text" name="class" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Gender</label>
<select name="gender" class="form-control">
<option>Male</option>
<option>Female</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Phone</label>
<input type="text" name="phone" class="form-control">
</div>

<div class="col-md-6 mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control">
</div>

<div class="col-12 mb-3">
<label>Address</label>
<textarea name="address" class="form-control"></textarea>
</div>

<div class="col-12 mb-3">
<label>Student Photo</label>
<input type="file" name="photo" class="form-control">
</div>

<div class="col-12">

<button class="btn btn-info" name="save">
<i class="bi bi-check-circle-fill"></i>
Save Student
</button>

<a href="students.php" class="btn btn-secondary">
Back
</a>

</div>

</div>

</form>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>