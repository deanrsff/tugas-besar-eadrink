<?php
session_start();
require_once 'function.php';


//  MEMASTIKAN LOGIN USER
if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}
//  MEMASTIKAN ID PRODUK
if (!isset($_GET['id'])) {
    header("Location: beranda.php");
    exit;
}

$id = (int)$_GET['id'];

//   AMBIL DATA PRODUK
$produk = query("SELECT * FROM produk WHERE id_produk = $id LIMIT 1");

if (!$produk) {
    echo "<script>
            alert('Produk tidak ditemukan');
            window.location='beranda.php';
          </script>";
    exit;
}
$p = $produk[0];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
</head>
<body>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
    body{
    background:#e5bea0ff;
    font-family: Segoe UI, sans-serif;
}

.detail-wrapper{
    max-width:900px;
    margin:auto;
}
.detail-card{
    border-radius:22px;
    background:#fff7f0;
}
.product-img{
    max-height:300px;
    object-fit:contain;
    padding:15px;
}
h2.title{
    color:#c86b36;
    font-size: 50px;
    text-align:center;
    letter-spacing:2px;
}
.btn-main{
    background:#c86b36;
    color:#fff;
    border-radius:30px;
    padding:10px 26px;
    font-weight:600;
    text-decoration:none;
    transition:.3s;
}
.btn-main:hover{
    background:#a3532a;
    color:#fff;
}
.btn-outline{
    border:1px solid #c86b36;
    color:#c86b36;
    border-radius:30px;
    padding:10px 26px;
    font-weight:600;
    text-decoration:none;
}
.btn-outline:hover{
    background:#c86b36;
    color:#fff;
}
</style>
</head>
<body>

<div class="container mt-5 detail-wrapper">
    <h2 class="fw-bold mb-4 title">𝓭𝓮𝓽𝓪𝓲𝓵 𝓹𝓻𝓸𝓭𝓾𝓴</h2>

    <div class="card shadow-lg p-4 detail-card">
        <div class="row align-items-center">

            <div class="col-md-5 text-center">
                <img src="dist/assets/img/<?= $p['gambar']; ?>" class="img-fluid product-img">
            </div>
            
            <div class="col-md-7">
                <h3 class="fw-bold"><?= $p['nama_produk']; ?></h3>
                <p class="mb-2">
                    <strong>Harga:</strong> Rp <?= number_format($p['harga']); ?>
                </p>
                
                <p class="mb-2">
                    <strong>Deskripsi:</strong> <?= $p['deskripsi']; ?>
                </p>

                <p class="mb-3">
                    <strong>Stok:</strong> <?= $p['stok'] > 0 ? $p['stok'] : 'Habis'; ?>
                </p>

                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <?php if ($p['stok'] > 0): ?>
                        <a href="keranjang.php?add=<?= $p['id_produk']; ?>" class="btn-main">
                            <i class="bi bi-cart"></i> Tambah Keranjang
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary rounded-pill px-4" disabled>Stok Habis</button>
                    <?php endif; ?>
                    <a href="beranda.php" class="btn-outline">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
