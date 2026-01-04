<?php
session_start();
require_once 'function.php';

// ambil semua produk dari database
$all_produk = query("SELECT * FROM produk");

// ubah ke array id=>data produk
$produk = [];
foreach ($all_produk as $p) {
    $produk[$p['id_produk']] = [
        'nama' => $p['nama_produk'],
        'harga' => $p['harga'],
        'gambar' => $p['gambar'] ?? 'default.png'
    ];
}

// inisialisasi keranjang
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// TOMBOL TAMBAH 
if (isset($_GET['add'])) {
    $id = (int)$_GET['add'];
    if(isset($produk[$id])) { 
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    }
    header("Location: keranjang.php");
    exit;
}

// TOMBOL KURANG
if (isset($_GET['min'])) {
    $id = (int)$_GET['min'];
    if(isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]--;
        if($_SESSION['cart'][$id] <= 0) unset($_SESSION['cart'][$id]);
    }
    header("Location: keranjang.php");
    exit;
}

// TOMBOL HAPUS
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    if(isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: keranjang.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    font-family: Segoe UI, sans-serif;
    background: #e5bea0ff;
    padding: 30px 10px;
}

h3 {
    text-align: center;  
    font-size: 40px;        
    color:  #c86b36;         
    margin-bottom: 25px;
}

.cart-container {
    max-width: 900px;
    margin: auto;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.cart-card {
    display: flex;
    align-items: center;
    background: #fff7f0;
    border-radius: 18px;
    padding: 12px 16px;
    box-shadow: 0 5px 12px rgba(0,0,0,.08);
    gap: 12px;
}

.cart-card img{
    width: 70px;
    height: 70px;
    object-fit: contain;
}

.cart-info{
    flex: 1;
}

.cart-info h6{
    margin: 0;
    font-size: 15px;
    font-weight: 700;
}

.cart-info p{
    margin: 0;
    font-size: 13px;
}

.price-tag{
    color: #c86b36;
    font-weight: 700;
}

.cart-actions{
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-action{
    background: #c86b36;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 7px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: 900;
    text-decoration: none;
}

.btn-action:hover{
    background:#a5572d;
    color:#fff;
}

.total-wrap {
    max-width: 900px;
    margin: 20px auto 0;
    background: #fff7f0;
    padding: 15px 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(75,45,28,0.15);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.total-wrap h5 {
    margin: 0;
    font-weight: 700;
    color: #c86b36;  
    font-size: 18px;
}

.total-wrap .btn-checkout {
    background: #c86b36; 
    color: #fff;
    padding: 10px 28px;
    border-radius: 25px;
    font-weight: 500;
    text-decoration: none;
    transition: 0.3s;
}

.total-wrap .btn-checkout:hover {
    background: #b15c2f; 
    color: #fff;
}

.empty-cart {
    text-align: center;
    padding: 40px 0;
}

.empty-cart h5 {
    color: #4b2e1c;
    font-family: Segoe UI, sans-serif;
    font-weight: 700;
    font-size: 18px;
    margin-bottom: 20px;
}

.empty-cart .btn-belanja {
    background-color: #c86b36; 
    color: #fff;
    padding: 10px 25px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 700;
    transition: 0.3s;
    display: inline-block;   
}

.empty-cart .btn-belanja:hover {
    background-color: #b15c2f; 
    color: #fff;
}

.btn-back {
    background-color: #6c757d;
    color: #fff;
    padding: 10px 25px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    margin-right: 10px;
    display: inline-block;
    transition: 0.3s;
}

.btn-back:hover {
    background-color: #5a6268; 
    color: #fff;
}

</style>
</head>
<body>

<h3>𝓚𝓮𝓻𝓪𝓷𝓳𝓪𝓷𝓰 𝓫𝓮𝓵𝓪𝓷𝓳𝓪</h3>

<?php if(empty($_SESSION['cart'])): ?>
    
    <div class="empty-cart">
        <h5>Keranjang kamu masih kosong!</h5>
        <a href="beranda.php" class="btn-belanja">Belanja Sekarang</a>
    </div>
<?php else: ?>

<div class="cart-container">
<?php 
$total = 0; 
foreach($_SESSION['cart'] as $id=>$qty): 
    if(!isset($produk[$id])) continue;
    
    $nama = $produk[$id]['nama'];
    $harga = $produk[$id]['harga'];
    $gambar = $produk[$id]['gambar'];
    $subtotal = $harga * $qty;
    $total += $subtotal;
?>

<div class="cart-card">
    <img src="dist/assets/img/<?= $gambar ?>">
    
    <div class="cart-info">
        <h6><?= htmlspecialchars($nama) ?></h6>
        <p class="price-tag">Rp <?= number_format($harga,0,',','.') ?></p>
        <p>Subtotal: Rp <?= number_format($subtotal,0,',','.') ?></p>
    </div>

    <div class="cart-actions">
        <a href="?min=<?= $id ?>" class="btn-action">−</a>
        <span><?= $qty ?></span>
        <a href="?add=<?= $id ?>" class="btn-action">+</a>
        <a href="hapus_keranjang.php?id=<?= $id ?>" 
        onclick="return confirm('Hapus produk ini dari keranjang?')" 
        class="btn-action" style="background:#dc3545">✕</a>
</div>

</div>
<?php endforeach; ?>
</div>

<div class="total-wrap">
    <h5>Total: Rp <?= number_format($total,0,',','.') ?></h5>

    <div>
        <!-- Tombol kembali ke beranda -->
        <a href="beranda.php" class="btn-back">
             ← Kembali ke Beranda </a>

        <!-- Tombol Checkout -->
        <a href="checkout.php" class="btn-checkout">Checkout</a>
    </div>
</div>
<?php endif; ?>

</body>
</html>
