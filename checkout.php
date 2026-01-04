<?php
session_start(); 
require 'function.php';

if (!is_user_logged_in()) {
    header("Location: login_user.php");
    exit;
}

if (empty($_SESSION['cart'])) {
    header("Location: keranjang.php");
    exit;
}

if (isset($_POST['checkout'])) {

    $id_user = (int) $_SESSION['user_id'];
    $nama    = escape($_POST['nama']);
    $hp      = escape($_POST['hp']);
    $alamat  = escape($_POST['alamat']);
    $bayar   = escape($_POST['pembayaran']);

    // MENGHITUNG TOTAL
    $total = 0;
    foreach ($_SESSION['cart'] as $id_produk => $qty) {
        $id_produk = (int)$id_produk;
        $qty = (int)$qty;
        $q = $koneksi->query("SELECT harga FROM produk WHERE id_produk=$id_produk");
        $p = $q->fetch_assoc();
        if ($p) {
            $total += $p['harga'] * $qty;
        }
    }


    // MENYIMPAN PESANAN
    $stmt = $koneksi->prepare("INSERT INTO pesanan
        (id_user, nama_pemesan, no_hp, alamat, metode_pembayaran, total_harga, status)
        VALUES (?, ?, ?, ?, ?, ?, 'menunggu')");
    if(!$stmt){
        die("PREPARE ERROR: ".$koneksi->error);
    }

    $stmt->bind_param("issssi",
        $id_user,
        $nama,
        $hp,
        $alamat,
        $bayar,
        $total
    );

    $stmt->execute(); 
  
    // MENGKURANGI STOK PRODUK
    foreach ($_SESSION['cart'] as $id_produk => $qty) {
        $koneksi->query("UPDATE produk SET stok = stok - $qty WHERE id_produk=$id_produk");
    }
    unset($_SESSION['cart']);
    header("Location: selesai_pesanan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>

body{
    background:#e5bea0;
}
.card{
    border-radius:18px;
}
.btn-checkout{
    background: #c86b36;
    color: #fff7f0;
    font-family: Segoe UI, sans-serif;
    border-radius:30px;
}
</style>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 ">
                    <h4 class="text-center mb-4">Checkout</h4>
                    
    <form method="post">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="hp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>
        
        <div class="mb-4">
            <label>Pembayaran</label>
            <select name="pembayaran" required class="form-select">
                <option value="COD">COD</option>
                <option value="Transfer">Transfer</option>
            </select>
        </div>
        <button type="submit" name="checkout" class="btn btn-checkout w-100">
            Selesaikan Pesanan
        </button>
    </form>
</div>
</div>
</div>
</div>
</body>
</html>
