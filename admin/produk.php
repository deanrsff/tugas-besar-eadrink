<?php
session_start();
require_once __DIR__ . '/../function.php';
if (!is_admin_logged_in()) header("Location: login_admin.php");

$produk = query("SELECT * FROM produk ORDER BY id_produk DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background:#fff7f0;
    font-family:Segoe UI, sans-serif;
    color:#3f2d20;
}

/* SIDEBAR */
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

/* CARD */
.card{
    border:none;
    border-radius:22px;
    box-shadow:0 12px 25px rgba(0,0,0,.08);
    overflow:hidden;
}

/* HEADER */
h4{
    font-weight:700
}

/* TABLE */
.table thead th{
    background:#c86b36; 
    border:none;
    color: white;
}
.table td{
    border-color:#ead8c3;
}
.table tbody tr:hover{
    background:#fff7f0;
}

/* IMAGE */
.table img{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:14px;
}

/* BADGE */
.badge{
    border-radius:20px;
    padding:6px 14px;
    font-weight:600;
}

/* BUTTON */
.btn{
    border-radius:12px;
    font-weight:600;
}
.btn-success{
    background:#2f9e65;
    border:none;
}
.btn-warning{
    background:#f6b23a;
    border:none;
    color:#fff;
}
.btn-danger{
    background:#e54848;
    border:none;
}
</style>

</head>
<body>
    
<div class="sidebar">
    <h4 class="mb-4">eadrink</h4>
    <a href="admin_dashboard.php"><i class="bi bi-grid"></i> Dashboard</a>
    <a class="active"><i class="bi bi-box"></i> Produk</a>
    <a href="pesanan.php"><i class="bi bi-cart"></i> Pesanan</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main">
    <h4 class="mb-3">Data Produk</h4>
    <div class="d-flex justify-content-between mb-3">
        <a href="tambah_produk.php" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
    </div>
    
    <div class="card shadow-sm bg-white">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Gambar</th>
                        <th>Deskripsi</th>
                        <th>Harga</th
                        ><th>Stok</th>
                        <th>Aksi</th>
                    </tr>
</thead>
<tbody>
    
<?php foreach ($produk as $p): ?>
    <tr>
        <td><?= $p['nama_produk'] ?></td>
        <td><img src="../dist/assets/img/<?= $p['gambar'] ?>"></td>
        <td><?= strlen($p['deskripsi'])>50 ? substr($p['deskripsi'],0,50).'...' : $p['deskripsi'] ?></td><td>Rp <?= number_format($p['harga']) ?></td>
        <td><span class="badge <?= $p['stok']>0?'bg-secondary':'bg-danger' ?>"><?= $p['stok'] ?></span></td>
<td>
<a href="edit_produk.php?id=<?= $p['id_produk'] ?>" class="btn btn-sm btn-warning">Edit</a>
<a href="hapus_produk.php?id=<?= $p['id_produk'] ?>" onclick="return confirm('Hapus produk ini?')" class="btn btn-sm btn-danger">Hapus</a>
</td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>
</div>

</div>
</body>
</html>
