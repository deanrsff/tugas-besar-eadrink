<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Selesai</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background: #e5bea0ff;
    font-family: Segoe UI, sans-serif;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}
.card-finish{
    background:#fff7f0;
    border-radius:25px;
    padding:45px 40px;
    text-align:center;
    box-shadow:0 15px 40px rgba(0,0,0,.15);
    animation:fadeIn .6s ease;
    max-width:420px;
    width:100%;
}
.check-icon{
    font-size:70px;
    color:#c86b36;
}
.btn-home{
    background:#c86b36;
    border:none;
    color:#fff;
    padding:12px 35px;
    border-radius:50px;
    font-weight:600;
    transition:.3s;
}
.btn-home:hover{
    background:#b25728;
    transform:translateY(-2px);
}
@keyframes fadeIn{
    from{opacity:0; transform:scale(.9);}
    to{opacity:1; transform:scale(1);}
}
</style>
</head>
<body>

<div class="card-finish">
    <i class="bi bi-check-circle-fill check-icon mb-3"></i>
    <h3 class="fw-bold mb-2">Pesanan Berhasil!</h3>
    <p class="text-muted mb-4">
        Terima kasih 🙏  
        Pesanan kamu sedang diproses dan akan segera kami siapkan.
    </p>
    <a href="beranda.php" class="btn btn-home">
        Kembali ke Beranda
    </a>
</div>
</body>
</html>
