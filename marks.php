<?php
include 'includes/session.php';
include 'includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="main-content">

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="text-white">Marks Management</h2>

<a href="add_marks.php" class="btn btn-warning">
<i class="bi bi-plus-circle"></i>
Add Marks
</a>

</div>

<div class="card p-4">

<table class="table table-dark table-hover">

<thead>

<tr>

<th>#</th>
<th>Roll No</th>
<th>Name</th>
<th>Class</th>
<th>Total</th>
<th>Percentage</th>
<th>Grade</th>
<th>Status</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

$result=mysqli_query($conn,"
SELECT
students.*,
marks.id AS marks_id,
marks.marks,
marks.percentage,
marks.grade
FROM students
LEFT JOIN marks
ON students.id=marks.student_id
");
$sr = 1;
while($row=mysqli_fetch_assoc($result))
{

// Example values until marks are stored in the database
$total = $row['marks'] ?? 0;
$percentage = $row['percentage'] ?? 0;
$grade = $row['grade'] ?? "N/A";

?>

<tr>

<td><?php echo $sr++; ?></td>

<td><?php echo $row['roll_no']; ?></td>

<td><?php echo $row['student_name']; ?></td>

<td><?php echo $row['class']; ?></td>

<td><?php echo $total; ?></td>

<td><?php echo $percentage; ?>%</td>

<td>
<span class="badge bg-primary">
<?php echo $grade; ?>
</span>
</td>

<td>
<span class="badge bg-secondary">
Pending
</span>
</td>

<td>

<a href="edit_marks.php?id=<?php echo $row['marks_id']; ?>" class="btn btn-warning btn-sm">
<i class="bi bi-pencil-fill"></i>
</a>

<a href="delete_marks.php?id=<?php echo $row['marks_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete Marks?')">
<i class="bi bi-trash-fill"></i>
</a>

</td>

</tr>

<?php
}
?>
</tbody>

</table>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>