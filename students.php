<?php
include 'includes/session.php';
include 'includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';
$limit=10;$page=isset($_GET['page'])?max(1,(int)$_GET['page']):1;$offset=($page-1)*$limit;
$search=trim($_GET['search']??'');$where='';
if($search!=''){ $s=mysqli_real_escape_string($conn,$search); $where=" WHERE student_name LIKE '%$s%' OR roll_no LIKE '%$s%'"; }
$c=mysqli_query($conn,"SELECT COUNT(*) total FROM students".$where);$totalStudents=mysqli_fetch_assoc($c)['total'];$totalPages=max(1,ceil($totalStudents/$limit));
$result=mysqli_query($conn,"SELECT * FROM students".$where." ORDER BY id DESC LIMIT $offset,$limit");
?>
<div class="main-content"><?php include 'includes/navbar.php';?><div class="container-fluid">
<div class="d-flex justify-content-between align-items-center mb-3"><div><h2>Students Management</h2><p>Total Students: <strong><?php echo $totalStudents;?></strong></p></div><a href="add_student.php" class="btn btn-info">Add Student</a></div>
<div class="card p-3 mb-3"><form method="GET"><div class="row"><div class="col-md-10"><input class="form-control" name="search" value="<?php echo htmlspecialchars($search);?>" placeholder="Search"></div><div class="col-md-2 d-grid"><button class="btn btn-info">Search</button></div></div></form></div>
<div class="card p-3"><div class="table-responsive"><table class="table table-dark table-hover"><thead><tr><th>#</th><th>Photo</th><th>Name</th><th>Roll</th><th>Class</th><th>Gender</th><th>Phone</th><th>Email</th><th>Actions</th></tr></thead><tbody>
<?php if(mysqli_num_rows($result)>0){$sr=$offset+1;while($row=mysqli_fetch_assoc($result)){ ?>
<tr><td><?php echo $sr++;?></td><td><?php if(!empty($row['photo'])){?><img src="uploads/<?php echo htmlspecialchars($row['photo']);?>" style="width:55px;height:55px;border-radius:50%;object-fit:cover;border:2px solid #00d4ff;"><?php }else{echo 'No Photo';}?></td><td><?php echo htmlspecialchars($row['student_name']);?></td><td><?php echo htmlspecialchars($row['roll_no']);?></td><td><span class="badge bg-info"><?php echo htmlspecialchars($row['class']);?></span></td><td><span class="badge <?php echo ($row['gender']=='Male')?'bg-primary':'bg-danger';?>"><?php echo htmlspecialchars($row['gender']);?></span></td><td><?php echo htmlspecialchars($row['phone']);?></td><td><?php echo htmlspecialchars($row['email']);?></td><td><a href="edit_student.php?id=<?php echo $row['id'];?>" class="btn btn-warning btn-sm">Edit</a> <a href="delete_student.php?id=<?php echo $row['id'];?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</a></td></tr>
<?php }}else{?><tr><td colspan="9" class="text-center">No students found.</td></tr><?php }?>
</tbody></table></div>
<ul class="pagination justify-content-center"><?php for($i=1;$i<=$totalPages;$i++){?><li class="page-item <?php echo $i==$page?'active':'';?>"><a class="page-link" href="?page=<?php echo $i;?><?php echo $search!=''?'&search='.urlencode($search):'';?>"><?php echo $i;?></a></li><?php }?></ul>
</div></div></div>
<?php include 'includes/footer.php';?>