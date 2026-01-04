<?php
session_start();
require_once 'function.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

// Menyimpan Review
if(isset($_POST['kirim_review'])){
    $id_user  = (int)$_SESSION['user_id'];
    $nama     = escape($_SESSION['nama_user']);
    $kota     = escape($_POST['kota']);
    $komentar = escape($_POST['komentar']);
    $rating   = (int)$_POST['rating'];

    execute("INSERT INTO review(id_user,nama_user,kota,komentar,rating)
             VALUES('$id_user','$nama','$kota','$komentar','$rating')");

    header("Location: beranda.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Review</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    min-height:100vh;
    background:#e5bea0ff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family: 'Segoe UI', sans-serif;
}

.review-card{
    width:100%;
    max-width:380px;
    border-radius:18px;
    
}
.header{
    background:#c86b36;     
    color:#fff7f0;
    padding:18px;
    text-align:center;
    border-radius:18px;
}
.star-rating input{
    display:none
}
.star-rating label{
    font-size:26px;
    color:#c86b36;     
    cursor:pointer;
}
.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label{
    color:#ffc107;
    
}
.btn-light{
      border-radius:12px;
}
.form-control{
    border-radius:12px;
}
.btn-coffee{
    background:#c86b36;      
    color:#fff;
    border-radius:14px;
}
.btn-coffee:hover{background:#c86b36;     
}
</style>
</head>

<body>
    <div class="card review-card shadow">
    <div class="header">
        <h6 class="mb-0 fw-semibold">Tambah Review</h6>
        <small class="opacity-75">Bagikan pengalaman kamu</small>
    </div>

    <div class="card-body p-3">
        <form method="post">

            <div class="mb-2">
                <label class="small fw-semibold">Nama</label>
                <input type="text" class="form-control form-control-sm" value="<?= $_SESSION['nama_user']; ?>" readonly>
            </div>

            <div class="mb-2">
                <label class="small fw-semibold">Kota</label>
                <input type="text" name="kota" class="form-control form-control-sm" placeholder="Asal Kota" required>
            </div>

            <div class="mb-2">
                <label class="small fw-semibold">Komentar</label>
                <textarea name="komentar" rows="2" class="form-control form-control-sm" placeholder="Tulis pengalaman kamu..." required></textarea>
            </div>

            <div class="mb-2 text-center star-rating">
                <input type="radio" name="rating" id="s5" value="5"><label for="s5">★</label>
                <input type="radio" name="rating" id="s4" value="4"><label for="s4">★</label>
                <input type="radio" name="rating" id="s3" value="3"><label for="s3">★</label>
                <input type="radio" name="rating" id="s2" value="2"><label for="s2">★</label>
                <input type="radio" name="rating" id="s1" value="1" required><label for="s1">★</label>
            </div>

            <button name="kirim_review" class="btn btn-coffee w-100 btn-sm mt-2">Kirim Review</button>
            <a href="beranda.php" class="btn btn-light w-100 btn-sm mt-2">Kembali</a>

        </form>
    </div>
</div>

</body>
</html>