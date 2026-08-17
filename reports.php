<?php
include 'includes/session.php';
include 'includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="main-content">

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid">
<?php

$totalStudents = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM students
"))['total'];

$avgMarks = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT AVG(marks) avg
FROM marks
"))['avg'];

$pass = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM marks
WHERE percentage>=35
"))['total'];

$fail = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM marks
WHERE percentage<35
"))['total'];

?>

<div class="row g-4 mb-4">

<div class="col-md-3">
<div class="card p-4 text-center">
<h6>Total Students</h6>
<h2 class="text-info"><?php echo $totalStudents; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 text-center">
<h6>Average Marks</h6>
<h2 class="text-warning"><?php echo round($avgMarks,2); ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 text-center">
<h6>Passed</h6>
<h2 class="text-success"><?php echo $pass; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 text-center">
<h6>Failed</h6>
<h2 class="text-danger"><?php echo $fail; ?></h2>
</div>
</div>

</div>
<h2 class="text-white mb-4">
Reports
</h2>
<div class="row mb-3">

<div class="col-md-4">

<input
type="text"
id="searchInput"
class="form-control"
placeholder="Search Student...">

</div>

</div>
<div class="card p-4">

<div class="d-flex justify-content-between mb-4">

<button class="btn btn-success" onclick="window.print()">
<i class="bi bi-printer-fill"></i>
Print Report
</button>

<a href="export_excel.php" class="btn btn-success">
<i class="bi bi-file-earmark-excel-fill"></i>
Export CSV
</a>

</div>

<table class="table table-dark table-hover" id="reportTable">

<thead>

<tr>

<th>Roll No</th>
<th>Name</th>
<th>Class</th>
<th>Marks</th>
<th>Percentage</th>
<th>Grade</th>

</tr>

</thead>

<tbody>

<?php

$result=mysqli_query($conn,"
SELECT
students.roll_no,
students.student_name,
students.class,
marks.marks,
marks.percentage,
marks.grade
FROM students
LEFT JOIN marks
ON students.id=marks.student_id
ORDER BY students.roll_no
");

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['roll_no']; ?></td>

<td><?php echo $row['student_name']; ?></td>

<td><?php echo $row['class']; ?></td>

<td><?php echo $row['marks'] ?? 0; ?></td>

<td><?php echo $row['percentage'] ?? 0; ?>%</td>

<td><?php echo $row['grade'] ?? "N/A"; ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>
<script>

document.getElementById("searchInput").addEventListener("keyup", function(){

let filter = this.value.toUpperCase();

let table = document.getElementById("reportTable");

let tr = table.getElementsByTagName("tr");

for(let i=1;i<tr.length;i++)
{
let txt = tr[i].textContent;

if(txt.toUpperCase().indexOf(filter)>-1)
tr[i].style.display="";
else
tr[i].style.display="none";
}

});

</script>
<?php include 'includes/footer.php'; ?>