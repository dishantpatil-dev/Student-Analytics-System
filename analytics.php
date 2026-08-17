<?php
include 'includes/session.php';
include 'includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$totalStudents = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM students
"))['total'];

$totalPresent = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM attendance
WHERE status='Present'
"))['total'];

$totalAbsent = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM attendance
WHERE status='Absent'
"))['total'];

$avgMarks = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT AVG(marks) avgmarks
FROM marks
"))['avgmarks'];
?>

<div class="main-content">

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid">

<h2 class="text-white mb-4">
Analytics Dashboard
</h2>

<div class="row g-4">

<div class="col-md-3">
<div class="card p-4 text-center">
<h5>Total Students</h5>
<h2 class="text-info">
<?php echo $totalStudents; ?>
</h2>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 text-center">
<h5>Present</h5>
<h2 class="text-success">
<?php echo $totalPresent; ?>
</h2>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 text-center">
<h5>Absent</h5>
<h2 class="text-danger">
<?php echo $totalAbsent; ?>
</h2>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 text-center">
<h5>Average Marks</h5>
<h2 class="text-warning">
<?php echo round($avgMarks,2); ?>
</h2>
</div>
</div>

</div>

<div class="row mt-4">

<div class="col-md-8">
<div class="card p-4">
<canvas id="marksChart"></canvas>
</div>
</div>

<div class="col-md-4">
<div class="card p-4">
<canvas id="gradeChart"></canvas>
</div>
</div>

</div>
<div class="row mt-4">

<div class="col-md-12">

<div class="card p-4">

<h4 class="text-warning mb-3">
🏆 Top 5 Students
</h4>

<table class="table table-dark table-hover">

<thead>

<tr>

<th>Rank</th>
<th>Name</th>
<th>Roll No</th>
<th>Marks</th>
<th>Grade</th>

</tr>

</thead>

<tbody>

<?php

$rank=1;

$top=mysqli_query($conn,"
SELECT students.student_name,
students.roll_no,
marks.marks,
marks.grade
FROM marks
JOIN students
ON marks.student_id=students.id
ORDER BY marks.marks DESC
LIMIT 5
");

while($t=mysqli_fetch_assoc($top))
{

?>

<tr>

<td>🏅 <?php echo $rank++; ?></td>

<td><?php echo $t['student_name']; ?></td>

<td><?php echo $t['roll_no']; ?></td>

<td><?php echo $t['marks']; ?></td>

<td>

<span class="badge bg-success">

<?php echo $t['grade']; ?>

</span>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<div class="row mt-4">

<div class="col-md-12">

<div class="card p-4">

<h4 class="text-info">
Attendance vs Marks
</h4>

<canvas id="comparisonChart"></canvas>

</div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const studentLabels = [];
const studentMarks = [];

const compareLabels = [];
const attendanceData = [];
const marksData = [];

<?php

$data=mysqli_query($conn,"
SELECT students.student_name,marks.marks
FROM students
JOIN marks
ON students.id=marks.student_id
");

while($r=mysqli_fetch_assoc($data))
{
echo "studentLabels.push('".$r['student_name']."');";
echo "studentMarks.push(".$r['marks'].");";
}

?>
new Chart(document.getElementById('marksChart'),{

type:'bar',

data:{

labels:studentLabels,

datasets:[{

label:'Marks',

data:studentMarks,

backgroundColor:'#00d4ff',

borderRadius:8

}]

},

options:{

responsive:true,

plugins:{
legend:{
labels:{
color:'#ffffff'
}
}
},

scales:{

y:{
beginAtZero:true,
max:100,
ticks:{
color:'#ffffff'
},
grid:{
color:'rgba(255,255,255,.08)'
}
},

x:{
ticks:{
color:'#ffffff'
},
grid:{
display:false
}
}

}

}

});


const gradeData=[

<?php
echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM marks WHERE grade='A+'"));
?>,

<?php
echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM marks WHERE grade='A'"));
?>,

<?php
echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM marks WHERE grade='B'"));
?>,

<?php
echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM marks WHERE grade='C'"));
?>,

<?php
echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM marks WHERE grade='D'"));
?>,

<?php
echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM marks WHERE grade='F'"));
?>

];

new Chart(document.getElementById('gradeChart'),{

type:'doughnut',

data:{

labels:['A+','A','B','C','D','F'],

datasets:[{

data:gradeData,

backgroundColor:[
'#22c55e',
'#3b82f6',
'#06b6d4',
'#f59e0b',
'#ef4444',
'#6b7280'
]

}]

}

});

<?php

$compare = mysqli_query($conn,"
SELECT
students.student_name,
COALESCE(AVG(CASE WHEN attendance.status='Present' THEN 100 ELSE 0 END),0) attendance_percent,
COALESCE(marks.percentage,0) marks_percent
FROM students
LEFT JOIN attendance
ON students.id=attendance.student_id
LEFT JOIN marks
ON students.id=marks.student_id
GROUP BY students.id
");

while($c=mysqli_fetch_assoc($compare))
{
    echo "compareLabels.push('".$c['student_name']."');";
    echo "attendanceData.push(".round($c['attendance_percent'],2).");";
    echo "marksData.push(".round($c['marks_percent'],2).");";
}

?>

new Chart(document.getElementById('comparisonChart'),{

type:'bar',

data:{

labels:compareLabels,

datasets:[

{
label:'Attendance %',
data:attendanceData,
backgroundColor:'#22c55e',
borderRadius:8
},

{
label:'Marks %',
data:marksData,
backgroundColor:'#00d4ff',
borderRadius:8
}

]

},

options:{

responsive:true,

plugins:{
legend:{
labels:{
color:'#ffffff'
}
}
},

scales:{

y:{
beginAtZero:true,
max:100,
ticks:{
color:'#ffffff'
},
grid:{
color:'rgba(255,255,255,.08)'
}
},

x:{
ticks:{
color:'#ffffff'
},
grid:{
display:false
}
}

}

}

});

</script>

<?php include 'includes/footer.php'; ?>