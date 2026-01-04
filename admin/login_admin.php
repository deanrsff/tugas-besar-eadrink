<?php
session_start();
require '../function.php';

if (is_admin_logged_in()) {
    header("Location: admin_dashboard.php");
    exit;
}

$error = '';
$success = '';

// Proses login
if (isset($_POST['login'])) {
    $email = escape($_POST['email']);
    $pass  = $_POST['password'];

    $admin = query("SELECT * FROM admin WHERE email='$email' LIMIT 1");

    if ($admin && password_verify($pass, $admin[0]['password'])) {
        $_SESSION['admin_id']       = (int)$admin[0]['id_admin'];
        $_SESSION['admin_username'] = $admin[0]['username']; 
        $_SESSION['admin_email']    = $admin[0]['email'];

        header("Location: admin_dashboard.php");
        exit;
    }

    $error = "Email atau password salah!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Admin</title>
<link href="../style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background: #ce8847ff; }
</style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="min-width: 350px;">
        <h3 class="text-center text-orange mb-3">Login Admin</h3>
        <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan Email..." required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan Password..." required>
            </div>
            <button name="login" class="btn w-100" style="background-color: #5a4136ff; color: #fff;">Login Admin</button>
        </form>
        <p class="mt-3 text-center">Belum punya akun? <a href="register_admin.php">Register</a></p>
    </div>
</div>
</body>
</html>
