<?php
include 'includes/session.php';
include 'includes/db.php';

$totalStudents=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM students"))['total'];
$totalTeachers=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM teachers"))['total'];
$totalSubjects=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM subjects"))['total'];
$totalAttendance=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) total FROM attendance"))['total'];

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="main-content">

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid">

<div class="row g-4">

<div class="col-md-3">
<div class="card stat-card total-card">
<div class="d-flex justify-content-between">
<div>
<h6>Total Students</h6>
<h2><?php echo $totalStudents;?></h2>
</div>
<i class="bi bi-people-fill card-icon text-info"></i>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card stat-card attendance-card">
<div class="d-flex justify-content-between">
<div>
<h6>Attendance Records</h6>
<h2><?php echo $totalAttendance;?></h2>
</div>
<i class="bi bi-calendar-check-fill card-icon text-success"></i>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card stat-card marks-card">
<div class="d-flex justify-content-between">
<div>
<h6>Subjects</h6>
<h2><?php echo $totalSubjects;?></h2>
</div>
<i class="bi bi-book-fill card-icon text-warning"></i>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card stat-card teacher-card">
<div class="d-flex justify-content-between">
<div>
<h6>Teachers</h6>
<h2><?php echo $totalTeachers;?></h2>
</div>
<i class="bi bi-person-workspace card-icon text-primary"></i>
</div>
</div>
</div>

</div>

<div class="row mt-4">

<div class="col-lg-6">

<div class="card p-4">

<h5 class="mb-3">Student Distribution</h5>

<canvas id="pieChart"></canvas>

</div>

</div>

<div class="col-lg-6">

<div class="card p-4">

<h5 class="mb-3">System Overview</h5>

<canvas id="barChart"></canvas>

</div>

</div>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>

<script>

new Chart(document.getElementById("pieChart"),{

type:"doughnut",

data:{

labels:["Students","Teachers","Subjects"],

datasets:[{

data:[<?php echo $totalStudents;?>,<?php echo $totalTeachers;?>,<?php echo $totalSubjects;?>],

backgroundColor:["#00d4ff","#22c55e","#f59e0b"]

}]

}

});

new Chart(document.getElementById("barChart"),{

type:"bar",

data:{

labels:["Students","Teachers","Subjects","Attendance"],

datasets:[{

data:[<?php echo $totalStudents;?>,<?php echo $totalTeachers;?>,<?php echo $totalSubjects;?>,<?php echo $totalAttendance;?>]

}]

}

});

</script>