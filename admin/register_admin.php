<?php
session_start();
require '../function.php';

// Redirect jika sudah login
redirect_if_admin_logged_in();

$error = '';
$success = '';

// Proses register
if(isset($_POST['register'])) {
    $username = escape($_POST['username']);
    $email    = escape($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = query("SELECT * FROM admin WHERE email='$email'");
    if(count($check) > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        $koneksi->query("INSERT INTO admin(username,email,password) VALUES('$username','$email','$password')");
        $success = "Registrasi admin berhasil. Silakan <a href='login_admin.php'>login</a>.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
<link href="../style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background: #ce8847ff; }
</style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="min-width: 350px;">
        <h3 class="text-center mb-3">Register Admin</h3>
        <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label fw-bold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan Username..." required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan Email..." required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan Password..." required>
            </div>
            <button name="register" class="btn w-100" style="background-color: #5a4136ff; color: #fff;">Register</button>
        </form>
        <p class="mt-3 text-center">Sudah punya akun? <a href="login_admin.php">Login</a></p>
    </div>
</div>
</body>
</html>
