<?php
session_start();
require_once __DIR__.'/../function.php';
if (!is_admin_logged_in()) header("Location: login_admin.php");

$pesanan = query("SELECT * FROM pesanan ORDER BY tanggal_pesanan DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pesanan</title>

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
    color:white;
}
.table td{
    border-color:#ead8c3;
}
.table tbody tr:hover{
    background:#fff7f0;
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
.btn-dark{
    background:#5a4136ff;
    border:none;
}

</style>
</head>

<body>

<div class="sidebar">
   <h4 class="mb-4">eadrink</h4>
   <a href="admin_dashboard.php"><i class="bi bi-grid"></i> Dashboard</a>
   <a href="produk.php"><i class="bi bi-box"></i> Produk</a>
   <a class="active"><i class="bi bi-cart"></i> Pesanan</a>
   <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main">
   <h4 class="mb-3">Data Pesanan</h4>

<div class="card">
   <div class="table-responsive">
      <table class="table align-middle mb-0">
         <thead>
            <tr>
               <th>Tanggal</th>
               <th>Nama</th>
               <th>HP</th>
               <th>Alamat</th>
               <th>Pembayaran</th>
               <th>Total</th>
               <th>Status</th>
               <th>Aksi</th>
            </tr>
         </thead>
         <tbody>

<?php foreach($pesanan as $p): ?>
   <tr>
      <td><?= date('d/m/Y H:i', strtotime($p['tanggal_pesanan'])) ?></td> 
      <td><?= $p['nama_pemesan'] ?></td> 
      <td><?= $p['no_hp'] ?></td> 
      <td><?= $p['alamat'] ?></td> 
      <td><span class="badge bg-secondary"><?= $p['metode_pembayaran'] ?></span></td> 
      <td>Rp <?= number_format($p['total_harga']) ?></td>
      <td>
         <!-- Badge status sesuai kondisi -->
         <span class="badge 
         <?= $p['status']=='menunggu' ? 'bg-warning' :
            ($p['status']=='dikirim' ? 'bg-primary' :
            ($p['status']=='selesai' ? 'bg-success' :
            ($p['status']=='dibatalkan' ? 'bg-danger' : 'bg-secondary'))) ?>">
         <?= strtoupper($p['status']) ?>
         </span>
      </td>
      <td class="text-center">
         <!-- Tombol detail -->
         <a href="detail_pesanan.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-dark">
            Detail
         </a>
      </td>
   </tr>
<?php endforeach ?>

</tbody>
</table>
</div>
</div>
</div>
</body>
</html>
