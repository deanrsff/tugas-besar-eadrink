<?php
session_start();
require '../function.php';

if(!isset($_SESSION['admin_id'])) header("Location: login_admin.php");

$produk   = mysqli_num_rows(mysqli_query($koneksi,"SELECT id_produk FROM produk"));
$pesanan  = mysqli_num_rows(mysqli_query($koneksi,"SELECT id FROM pesanan"));
$menunggu = mysqli_num_rows(mysqli_query($koneksi,"SELECT id FROM pesanan WHERE status='menunggu'"));
$dikirim  = mysqli_num_rows(mysqli_query($koneksi,"SELECT id FROM pesanan WHERE status='dikirim'"));
$selesai  = mysqli_num_rows(mysqli_query($koneksi,"SELECT id FROM pesanan WHERE status='selesai'"));
$dibatalkan  = mysqli_num_rows(mysqli_query($koneksi,"SELECT id FROM pesanan WHERE status='dibatalkan'"));
$produkTerbaru = mysqli_query($koneksi,"SELECT * FROM produk ORDER BY id_produk DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
body{
    background:#fff7f0;
    font-family: Segoe UI, sans-serif;
}
.sidebar{
    position: fixed;
    left: 0;
    top: 0;
    width: 230px;
    height: 100vh;
    background: #694233ff;
    color: #fff;
    padding: 20px;
}
.sidebar a{
    color:#fff;
    text-decoration:none;
    display:block;
    padding:10px;
    border-radius:8px;
    margin-bottom:6px;
}
.sidebar a:hover,.sidebar a.active{ 
    background:#c86b36
}
.sidebar h4{
    font-weight:700;
    letter-spacing:1px
}
.main{
    margin-left:250px;
    padding:30px
}
.card-stat{
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
}
.stat-icon{
    font-size:40px;
}
</style>
</head>
<body>

<!-- SIDEBAR-->
<div class="sidebar">
    <h4 class="mb-4">eadrink</h4>
    <a class="active"><i class="bi bi-grid"></i> Dashboard</a>
    <a href="produk.php"><i class="bi bi-box"></i> Produk</a>
    <a href="pesanan.php"><i class="bi bi-cart"></i> Pesanan</a>
    <a href="logout_admin.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main">

<!-- HEADER CARD -->
<div class="card mb-4 shadow-sm border-0 rounded-4">
    <div class="card-body d-flex justify-content-between align-items-center">

        <h4 class="mb-0">
            Selamat Datang, Admin <?= htmlspecialchars($_SESSION['admin_username']); ?> 👋
        </h4>

    </div>
</div>


<!-- STAT -->
<div class="row g-4 mb-4">
  <div class="col-md-3">
    <div class="card card-stat p-3 bg-white">
      <h6>Total Produk</h6>
      <h3><?= $produk ?></h3>
      <i class="bi bi-box stat-icon text-warning"></i>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-stat p-3 bg-white">
      <h6>Total Pesanan</h6>
      <h3><?= $pesanan ?></h3>
      <i class="bi bi-cart stat-icon text-secondary"></i>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-stat p-3 bg-white">
      <h6>Menunggu</h6>
      <h3><?= $menunggu ?></h3>
      <i class="bi bi-hourglass-split stat-icon text-danger"></i>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-stat p-3 bg-white">
      <h6>Dikirim</h6>
      <h3><?= $dikirim ?></h3>
      <i class="bi bi-truck stat-icon text-primary"></i>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-stat p-3 bg-white">
      <h6>Selesai</h6>
      <h3><?= $selesai ?></h3>
      <i class="bi bi-check-circle stat-icon text-success"></i>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-stat p-3 bg-white">
      <h6>Dibatalkan</h6>
      <h3><?= $dibatalkan ?></h3>
      <i class="bi bi-cart-x stat-icon text-danger"></i>
    </div>
  </div>
</div>
</body>
</html>
