<?php
require_once 'function.php';

$error = '';
$success = '';
if (isset($_POST['register'])) {
    $username = escape($_POST['username']);
    $email    = escape($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = query("SELECT * FROM user WHERE email='$email'");
    if ($cek) {
        $error = "Email sudah terdaftar!";
    } else {
        $koneksi->query("INSERT INTO user(username,email,password)
                         VALUES('$username','$email','$password')");
        $error = "Registrasi berhasil. <a href='login_user.php'>Login</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register User</title>
<link href="../style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        body {
            background: #ce8847ff;
        }
    </style>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width:350px;">
            <h4 class="text-center mb-3">Register User</h4>
            <?php if($error): ?>
                <div class="alert alert-info"><?= $error ?></div>
                <?php endif; ?>
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
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password...." required>
                     </div>
                     <button name="register" class="btn w-100" style="background-color: #5a4136ff; color: #fff; ">Register</button>
                    </form>
                    <p class="mt-3 text-center">Sudah punya akun? <a href="login_user.php">Login</a></p>
                </div>
            </div>
        </body>
        </html>
