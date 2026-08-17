<?php
include 'includes/session.php';
include 'includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';

if(isset($_POST['save'])){
    $date=$_POST['attendance_date'];
    foreach($_POST['status'] as $student_id=>$status){
        $student_id=(int)$student_id;
        $status=mysqli_real_escape_string($conn,$status);

        $check=mysqli_query($conn,"SELECT id FROM attendance WHERE student_id=$student_id AND attendance_date='$date'");
        if(mysqli_num_rows($check)>0){
            mysqli_query($conn,"UPDATE attendance SET status='$status' WHERE student_id=$student_id AND attendance_date='$date'");
        }else{
            mysqli_query($conn,"INSERT INTO attendance(student_id,attendance_date,status) VALUES($student_id,'$date','$status')");
        }
    }
    echo "<script>alert('Attendance Saved');window.location='attendance.php';</script>";
}

$result=mysqli_query($conn,"SELECT * FROM students ORDER BY student_name");
?>
<div class="main-content">
<?php include 'includes/navbar.php';?>
<div class="container-fluid">
<div class="card p-4">
<h2 class="mb-4">Attendance Management</h2>

<form method="POST">

<div class="mb-4">
<label>Date</label>
<input type="date" name="attendance_date" class="form-control" value="<?php echo date('Y-m-d');?>" required>
</div>

<div class="table-responsive">
<table class="table table-dark table-hover align-middle">
<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Roll No</th>
<th>Present</th>
<th>Absent</th>
</tr>
</thead>
<tbody>

<?php
$sr=1;
while($row=mysqli_fetch_assoc($result)){
?>
<tr>
<td><?php echo $sr++;?></td>
<td>
<a href="attendance_report.php?id=<?php echo $row['id']; ?>" class="text-info text-decoration-none fw-bold">
    <?php echo htmlspecialchars($row['student_name']); ?>
</a>
</td>
<td><?php echo htmlspecialchars($row['roll_no']);?></td>
<td><input type="radio" name="status[<?php echo $row['id'];?>]" value="Present" checked></td>
<td><input type="radio" name="status[<?php echo $row['id'];?>]" value="Absent"></td>
</tr>
<?php } ?>

</tbody>
</table>
</div>

<button class="btn btn-success" name="save">Save Attendance</button>

</form>

</div>
</div>
</div>
<?php include 'includes/footer.php';?>