<?php
session_start(); 
require '../function.php'; 

// Cek apakah admin sudah login
if (!is_admin_logged_in()) {
    header("Location: login_admin.php"); 
    exit;
}

global $koneksi; 

// Jika tombol simpan ditekan
if (isset($_POST['simpan'])) {

    $nama  = escape($_POST['nama']);        
    $desk  = escape($_POST['deskripsi']);   
    $harga = (int) $_POST['harga'];       
    $stok  = (int) $_POST['stok'];          

    // Status otomatis berdasarkan stok
    $status = $stok > 0 ? 'tersedia' : 'habis';

   
    $gambar = time().'_'.$_FILES['gambar']['name'];

    // Simpan gambar ke folder website
    move_uploaded_file($_FILES['gambar']['tmp_name'], "../dist/assets/img/".$gambar);

    // Simpan data produk ke database
    $koneksi->query("
        INSERT INTO produk (nama_produk, deskripsi, harga, stok, ketersediaan_stok, gambar)
        VALUES ('$nama', '$desk', $harga, $stok, '$status', '$gambar')
    ");

    header("Location: produk.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>

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
                
            <!-- Card Form Tambah Produk -->
             <div class="card shadow border-0">
                
             <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Tambah Produk</h5>
            </div>
            
            <div class="card-body p-4">
                
            <form method="post" enctype="multipart/form-data">
                <!-- Input nama produk -->
                 <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                
                <!-- Input deskripsi produk -->
                 <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>
                
                <!-- Input harga produk -->
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                </div>
                
                <!-- Input stok produk -->
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" min="0" required>
                </div>
                
                <!-- Input upload gambar produk -->
                <div class="mb-4">
                    <label class="form-label">Gambar Produk</label>
                    <input type="file" name="gambar" class="form-control" onchange="previewImg(this)" required>
                    <img id="preview" class="img-fluid rounded mt-3 d-none">
                </div>
                
                <!-- Tombol aksi -->
                 <div class="d-flex justify-content-between">
                    <a href="produk.php" class="btn btn-secondary px-4">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button name="simpan" class="btn px-4 btn-simpan">
                        <i class="bi bi-save"></i> Simpan Produk
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
    const preview = document.getElementById('preview'); // ambil tag <img>
    const file = input.files[0]; // ambil file gambar yang dipilih
    if(file){
        preview.src = URL.createObjectURL(file); // tampilkan gambar sementara
        preview.classList.remove('d-none'); // tampilkan <img>
    }
}
</script>

</body>
</html>
