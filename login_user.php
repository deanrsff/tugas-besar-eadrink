<?php
require 'function.php';
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: beranda.php");
    exit;
}

$error = '';

if (isset($_POST['login'])) {

    $email = escape($_POST['email']);
    $pass  = $_POST['password'];

    $user = query("SELECT * FROM user WHERE email='$email' LIMIT 1");

    if ($user) {

        // JIKA PASSWORD DI DATABASE BELUM HASH
        if ($pass === $user[0]['password'] || password_verify($pass, $user[0]['password'])) {

            $_SESSION['user_id']   = $user[0]['id'];
            $_SESSION['nama_user'] = $user[0]['username'];   
            $_SESSION['user_email']= $user[0]['email'];

            header("Location: beranda.php");
            exit;
        }
    }

    $error = "Email atau password salah!";
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <style>
        body {
            background: #ce8847ff;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="min-width:350px">
        <h4 class="text-center mb-3">Login User</h4>
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- FORM LOGIN -->
        <form method="post">
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan Email..." required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan Password..." required>
            </div>
           <button name="login" class="btn w-100" style="background-color: #5a4136ff; color: #fff; ">Login User</button>
        </form>
        <p class="mt-3 text-center">Sudah punya akun? <a href="Register_user.php">Register_user</a></p>
    </div>
</div>
</body>
</html>