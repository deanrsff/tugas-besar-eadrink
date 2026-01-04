<?php
require 'function.php';

// Kalau sudah login sebagai USER
if (is_user_logged_in()) {
    header("Location: beranda.php");
    exit;
}

// Kalau sudah login sebagai ADMIN
if (is_admin_logged_in()) {
    header("Location: admin/admin_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Role Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #ce8847ff;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4 text-center" style="min-width:350px">
        <h4 class="mb-4">Pilih Role Login</h4>

        <!-- LOGIN ADMIN -->
        <a href="admin/login_admin.php" class="btn w-100 mb-3"
           style="background-color: #5a4136ff; color: #fff;">
            Login sebagai Admin
        </a>

        <!-- LOGIN USER -->
        <a href="login_user.php" class="btn w-100"
           style="background-color: #7a5a4cff; color: #fff;">
            Login sebagai User
        </a>
    </div>
</div>

</body>
</html>