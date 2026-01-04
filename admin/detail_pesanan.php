<?php
session_start(); 
require_once __DIR__.'/../function.php';
if (!is_admin_logged_in()) header("Location: login_admin.php");

$id = (int)$_GET['id'];
$pesanan = query("SELECT * FROM pesanan WHERE id=$id LIMIT 1");
if(!$pesanan) die("Pesanan tidak ditemukan");
$p = $pesanan[0];

if(isset($_POST['update_status'])){
    $status = escape($_POST['status']);
    mysqli_query($koneksi,"UPDATE pesanan SET status='$status' WHERE id=$id");
    header("Location: pesanan.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#e5bea0ff;
    font-family: Segoe UI, sans-serif;
}
.wrapper{
    max-width:720px;
    margin:auto;
}
.card-custom{
    background:#fff7f0;
    border-radius:22px;
}
.title{
    color:#c86b36;
    text-align:center;
    letter-spacing:2px;
    font-size:32px;  
}
.form-control,.form-select{
    border-radius:16px;
}
.btn-main{
    background:#c86b36;
    color:#fff;
    border-radius:16px;
    font-weight:600;
}
</style>
</head>
<body>

<div class="container mt-5 wrapper">
    <h4 class="fw-bold mb-4 title">𝓭𝓮𝓽𝓪𝓲𝓵 𝓹𝓮𝓼𝓪𝓷𝓪𝓷</h4>
    
    <div class="card shadow p-4 card-custom">
        <form method="post">
            
        <div class="row g-3">
            <div class="col-md-6">
                <label class="fw-semibold">Nama Pemesan</label>
                <input type="text" class="form-control" value="<?= $p['nama_pemesan'] ?>" disabled>
            </div>
            
            <div class="col-md-6">
                <label class="fw-semibold">No HP</label>
                <input type="text" class="form-control" value="<?= $p['no_hp'] ?>" disabled>
            </div>
            
            <div class="col-md-12"><label class="fw-semibold">Alamat</label>
            <textarea class="form-control" rows="2" disabled><?= $p['alamat'] ?></textarea>
        </div>

        <div class="col-md-6">
            <label class="fw-semibold">Metode Pembayaran</label>
            <input type="text" class="form-control" value="<?= $p['metode_pembayaran'] ?>" disabled>
        </div>

        <div class="col-md-6">
            <label class="fw-semibold">Total Pembayaran</label>
            <input type="text" class="form-control" value="Rp <?= number_format($p['total_harga']) ?>" disabled>
        </div>

        <div class="col-md-12">
            <label class="fw-semibold">Status Pesanan</label>
            <select name="status" class="form-select">
                <option value="menunggu" <?= $p['status']=='menunggu'?'selected':'' ?>>Menunggu</option>
                <option value="dikirim" <?= $p['status']=='dikirim'?'selected':'' ?>>Dikirim</option>
                <option value="selesai" <?= $p['status']=='selesai'?'selected':'' ?>>Selesai</option>
                <option value="dibatalkan" <?= $p['status']=='dibatalkan'?'selected':'' ?>>Dibatalkan</option>
            </select>
        </div>

        <div class="col-12 d-grid gap-3 mt-4">
            <button name="update_status" class="btn btn-main">Update status</button>
            <a href="pesanan.php" class="btn btn-outline-secondary">Kembali</a>
</div>

</div>
</form>
</div>
</div>

</body>
</html>