<?php
session_start();
include 'includes/db.php';

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($query) > 0) {

        $user = mysqli_fetch_assoc($query);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['fullname'] = $user['fullname'];

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Invalid Username or Password!";
    }
}
?>


<!DOCTYPE html>
<html>

<head>

<title>Student Analytics System | Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

body{

height:100vh;

display:flex;

justify-content:center;

align-items:center;

background:linear-gradient(135deg,#0f172a,#1e3a8a,#06b6d4);

font-family:Arial,sans-serif;

overflow:hidden;

}

.login-card{

width:420px;

padding:40px;

border-radius:20px;

background:rgba(255,255,255,.08);

backdrop-filter:blur(18px);

box-shadow:0 0 40px rgba(0,0,0,.35);

color:#fff;

}

.logo{

font-size:70px;

text-align:center;

margin-bottom:10px;

}

h2{

text-align:center;

margin-bottom:30px;

font-weight:bold;

}

.form-control{

background:rgba(255,255,255,.12) !important;

border:none !important;

color:#fff !important;

height:50px;

box-shadow:none !important;

}

.form-control:focus{

background:rgba(255,255,255,.18) !important;

color:#fff !important;

border:none !important;

box-shadow:0 0 0 2px rgba(0,212,255,.3) !important;

}

.form-control::placeholder{

color:#ddd;

}
.form-control:-webkit-autofill,
.form-control:-webkit-autofill:hover,
.form-control:-webkit-autofill:focus{

-webkit-text-fill-color:#fff;

-webkit-box-shadow:0 0 0px 1000px rgba(255,255,255,.12) inset;

transition:background-color 9999s ease-in-out 0s;

}
.form-control::placeholder{

color:#ddd;

}

.input-group-text{

background:rgba(255,255,255,.12);

border:none;

color:#00d4ff;

}

.btn-login{

background:#00d4ff;

color:#fff;

height:50px;

font-size:18px;

font-weight:bold;

border:none;

}

.btn-login:hover{

background:#0099cc;

}

.error{

background:#dc3545;

padding:10px;

border-radius:8px;

margin-bottom:15px;

text-align:center;

}

</style>

</head>

<body>

<div class="login-card">

<div class="logo">🎓</div>

<h2>Student Analytics System</h2>

<?php
if(isset($error))
{
?>
<div class="error">
<?php echo $error; ?>
</div>
<?php
}
?>

<form method="POST">

<div class="mb-3">

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-person-fill"></i>
</span>

<input
type="text"
name="username"
class="form-control"
placeholder="Username"
required>

</div>

</div>

<div class="mb-4">

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-lock-fill"></i>
</span>

<input
type="password"
id="password"
name="password"
class="form-control"
placeholder="Password"
required>

<button
class="input-group-text"
type="button"
onclick="togglePassword()">

<i class="bi bi-eye-fill"></i>

</button>

</div>

</div>

<button
type="submit"
name="login"
class="btn btn-login w-100">

Login

</button>

</form>

</div>

<script>

function togglePassword()
{
let x=document.getElementById("password");

if(x.type==="password")
x.type="text";
else
x.type="password";
}

</script>

</body>

</html>

