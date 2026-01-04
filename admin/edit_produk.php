<?php
session_start(); 
require '../function.php'; 

// Cek apakah admin sudah login
if (!is_admin_logged_in()) {
    header("Location: login_admin.php");
    exit;
}

global $koneksi; 

// Ambil ID produk 
$id = (int)$_GET['id'];

$data = query("SELECT * FROM produk WHERE id_produk=$id");

if (!$data) {
    header("Location: produk.php");
    exit;
}

// Simpan data produk ke variabel
$p = $data[0];


if (isset($_POST['update'])) {

    $nama  = escape($_POST['nama']);
    $desk  = escape($_POST['deskripsi']);
    $harga = (int) $_POST['harga'];
    $stok  = (int) $_POST['stok'];

    // Tentukan status stok otomatis
    $status = $stok > 0 ? 'tersedia' : 'habis';

    // Jika admin upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {

        $gambar = time().'_'.$_FILES['gambar']['name'];

        // Pindahkan gambar ke folder website
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../dist/assets/img/".$gambar);

        // Update gambar di database
        $koneksi->query("UPDATE produk SET gambar='$gambar' WHERE id_produk=$id");
    }

    // Update data produk
    $koneksi->query("UPDATE produk SET
        nama_produk='$nama',
        deskripsi='$desk',
        harga=$harga,
        stok=$stok,
        ketersediaan_stok='$status'
        WHERE id_produk=$id
    ");

    // Kembali ke produk
    header("Location: produk.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: #e5bea0ff;
    font-family:'Segoe UI',sans-serif;
}

.btn-simpan{
    background: #c86b36;
    color: #fff7f0;
    border-radius: 50px;
    border: none;
}
.btn-simpan:hover{
    background: #a95529;
    color: #fff7f0;
}

.card-header {
    background: #c86b36;
    color: #fff;
    padding: 14px 20px;
    border-radius: 40px;
    overflow: hidden;
}
.card-header h5{
    margin: 0;
    font-weight: 600;
    letter-spacing: .3px;
}
</style>
</head>

<body>
    
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            
      
         <div class="card shadow border-0">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Produk</h5>
            </div>
            
            <div class="card-body p-4">
                <form method="post" enctype="multipart/form-data">
                    
                <!-- Input nama -->
                 <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama" class="form-control" value="<?= $p['nama_produk']; ?>" required>
                </div>
                
                <!-- Input deskripsi -->
                 <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"><?= $p['deskripsi']; ?></textarea>
                </div>
                
                <!-- Input harga -->
                 <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" class="form-control" value="<?= $p['harga']; ?>" required>
                    </div>
                </div>
                
                <!-- Input stok -->
                 <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="<?= $p['stok']; ?>" min="0" required>
                </div>
                
                <!-- Upload gambar -->
                 <div class="mb-4">
                    <label class="form-label">Gambar Produk</label>
                    <input type="file" name="gambar" class="form-control" onchange="previewImg(this)">

<?php if(!empty($p['gambar'])): ?>
<!-- Jika sudah ada gambar -->
<img src="../dist/assets/img/<?= $p['gambar']; ?>" id="preview" class="img-fluid rounded mt-3">
<?php else: ?>
<!-- Jika belum ada gambar -->
<img id="preview" class="img-fluid rounded mt-3 d-none">
<?php endif; ?>
</div>
<div class="d-flex justify-content-between">
    <a href="produk.php" class="btn btn-secondary px-4">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <button name="update" class="btn px-4 btn-simpan">
        <i class="bi bi-save"></i> Update Produk
    </button>
</div>

</form>
</div>
</div>
</div>
</div>
</div>

<script>
function previewImg(input){
    const preview = document.getElementById('preview');
    const file = input.files[0];
    if(file){
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    }
}
</script>

</body>
</html>
