<?php
session_start();
require_once 'function.php';

// CHECK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

// SEARCH KEYWORD 
$keyword = isset($_GET['q']) ? $_GET['q'] : '';
$is_search = !empty($keyword); // true jika sedang search

if($keyword){
    $keyword = escape($keyword);
    $produk  = query("SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%' ORDER BY id_produk DESC");
}else{
    $produk  = query("SELECT * FROM produk ORDER BY id_produk DESC");
}

// REVIEW
$review = query("SELECT * FROM review ORDER BY id_review DESC LIMIT 6");

// PROFIL USER

$id_user = $_SESSION['user_id'];
$data_user = query("SELECT * FROM user WHERE id='$id_user'")[0];

if(isset($_POST['update_profil'])){
    $username = escape($_POST['username']);
    $email    = escape($_POST['email']);
    $pass     = $_POST['password'];

    if($pass!=''){
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        execute("UPDATE user SET username='$username', email='$email', password='$pass' WHERE id='$id_user'");
    }else{
        execute("UPDATE user SET username='$username', email='$email' WHERE id='$id_user'");
    }

    $_SESSION['nama_user']   = $username;
    $_SESSION['user_email'] = $email;

    header("Location: beranda.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body { 
            background-color: #ffffffff; 
            color: #2c1810;
         }
        .navbar { 
            background-color: #694233ff;
         }
        .navbar-brand { color: #f3d1a2 !important; 
            font-weight: 700; 
            font-size: 26px;
         }
        .nav-link { 
            color: white !important;
             margin-left: 15px; 
            }
        .nav-link:hover { 
            color: #f3d1a2 !important; 
        }

        /* HERO */
        .hero { 
            min-height: 90vh; 
            display: flex; 
            align-items: center; 
            background: #e5bea0ff;
         }
        .hero h1 {
            font-size: 52px; 
            font-weight: 700; 
        }
        .hero h1 span { 
            color: #c86b36; 
        }
        .hero p { 
            margin: 20px 0; 
            color: #5a4636;
         }
        .btn-order { 
            background: #c86b36; 
            color: white; 
            border-radius: 30px; 
            padding: 10px 28px; 
            font-weight: 600; 
        }
        .btn-order:hover { 
            background: #a85528;
         }

        /* PRODUCTS */
        .products { 
            background: #fff7f0;
            padding: 80px 0; 
        }
        .products h2 { 
            text-align: center; 
            font-weight: 700; 
            margin-bottom: 50px;
         }
        .product-card {
            background: #e5bea0ff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            position: relative;
            transition: .3s;
        }
        .product-card:hover { 
            transform: translateY(-8px);
         }
        .discount { 
            position: absolute;
            top: 10px;
            left: 10px; 
            background: #c86b36; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 14px; 
        }
        .discount.bg-danger { 
            background:#dc3545;
        }
        .product-card img { 
            width: 100%; 
            height: 220px; 
            object-fit: contain; 
            margin-bottom: 15px; 
        }
        .product-card h5 { 
            font-weight: 600; 
            margin-bottom: 10px; 
        }
        .product-card p.price { 
            font-weight: 600; 
            color: #c86b36; 
            font-size: 18px; 
            margin-bottom: 15px;
         }
        .product-action { 
            display: flex; 
            justify-content: center; 
            gap: 10px; }
        .btn-price { 
            background: #c86b36; 
            color: white; 
            border-radius: 30px; 
            padding: 8px 20px; 
            font-weight: 600; 
            border: none; }
        .btn-price:hover { 
            background: #a85528;
         }

        /* REVIEW */
        .review-section { 
            background:#e5bea0ff; 
            padding:100px 0; }
        .review-card { 
            background:#fff7f0;
            border-radius:25px; 
            padding:30px; 
            box-shadow:0 12px 30px rgba(0,0,0,.15); 
            position:relative; 
            height:100%; 
            transition:.3s; 
        }
        .review-card:hover {
            transform:translateY(-10px);
        }
        .review-stars { 
            color:#f39c12; 
            font-size:20px;
            margin-bottom:10px; 
        }
        .review-quote { 
            position:absolute; 
            right:15px;
            bottom:-10px; 
            font-size:70px; 
            color:#f3d1a2; 
        }
        .review-name { 
            font-weight:700; 
            color:#c86b36; 
        }
        .review-btn { 
            background:#c86b36; 
            color:white; 
            border-radius:30px; 
            padding:12px 35px; 
            text-decoration:none; 
            font-weight:600; 
        }
        .review-btn:hover { 
            background:#a85528;
            color:white; 
        }

        /* FOOTER */
        footer { 
            background:#694233ff; 
            color:white;
            padding:40px 0; 
        }
        footer .social-icon { 
            font-size:18px; 
            margin:0 8px; 
            color:white; 
            transition:.3s; 
        }
        footer .social-icon:hover { 
            color:#f3d1a2; 
        }
        footer a.text-decoration-none:hover { 
            color:#f3d1a2; 
            text-decoration:none; 
        }

         /* SEARCH */
        .input-group input{ 
            border:none; 
            padding:10px 18px; 
        }
        .input-group input:focus{ 
            box-shadow:none; 
        }
        .input-group button{ 
            border:none; 
        }

        /* PROFIL MODAL */
        .profil-modal{
            border-radius:30px;
            overflow:hidden;
            border:none;
            box-shadow:0 15px 40px rgba(0,0,0,.2);
        }
        
        /* HEADER */
        .profil-header{
            background:#c86b36;
            color:white;
            text-align:center;
            padding:30px 20px;
        }
        .profil-header h5{
            margin:10px 0 0;
            font-weight:700;
        }
        .profil-header small{            
            opacity:.75;
        }
        .profil-icon{
            font-size:50px;
        }
        
        /* BODY */
        .profil-body{
            padding:30px;
        }
        .profil-body label{
            font-weight:600;
            color:#7a5a44;
            font-size:14px;
        }
        .profil-input{
            border-radius:50px;
            padding:10px 18px;
        }
        
        /* BUTTON */
        .profil-btn-save{
            width:100%;
            background:#c86b36;
            color:white;
            border-radius:50px;
            padding:12px;
            border:none;
        }
        .profil-btn-save:hover{
            background:#a85528;
        }
        .profil-footer{
            text-align:center;
            padding-bottom:15px;
        }
        .profil-btn-cancel{            
            width:30%;
            background:#c86b36;
            color:white;
            border-radius:50px;
            padding:12px;
            border:none;
        }
        .profil-btn-cancel:hover{
            color:#694233ff;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 text-dark" href="#">
            <img src="dist/assets/img/logo_drink.png" height="50">
            <span class="fw-bold">eadrink</span>
        </a>
        <button class="navbar-toggler bg-light" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="nav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#products">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="#review">Review</a></li>
            </ul>
            <!-- SEARCH-->
            <form method="GET" class="d-flex me-3">
                <div class="input-group">
                    <input type="text" name="q" class="form-control rounded-start-pill" placeholder="Search product..." value="<?= htmlspecialchars($keyword); ?>">
                    <button class="btn rounded-end-pill" style="background:#f3d1a2;">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- ICON PROFIL -->
             <div class="dropdown ms-2">
                <a href="#" class="btn rounded-circle" data-bs-toggle="dropdown" style="background:#f3d1a2;">
                    <i class="bi bi-person-fill"></i>
                 </a>
                 
                 <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalProfil">
                            <i class="bi bi-pencil-square me-2"></i> Edit Profil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a href="logout_user.php" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>


 <!-- HERO SECTION-->
<?php if(!$is_search): ?>
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 style="font-size:85px;"><span>𝓮𝓪𝓭𝓻𝓲𝓷𝓴</span> 𝓬𝓪𝓯𝓮</h1>
                <p>Enjoy a variety of the best drinks made from selected ingredients with distinctive flavors and tempting aromas!</p>
            </div>
            <div class="col-md-6 text-center">
                <img src="dist/assets/img/benner.png" class="img-fluid">
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- PRODUCTS SECTION -->
<section id="products" class="products">
    <div class="container">
        <?php
        if ($is_search) {
            $section_title = ""; // Kosongkan jika tidak mau menampilkan "Hasil Pencarian"
        } else {
            $section_title = "𝓸𝓾𝓻 𝓶𝓮𝓷𝓾";
        }
        ?>
        <h2 style="font-size:50px;"><?= $section_title ?></h2>

        <div class="row g-4">
            <?php if ($produk): ?>
                <?php foreach ($produk as $p): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card text-center">
                            <?php if ($p['stok'] > 0): ?>
                                <span class="discount">Ready</span>
                            <?php else: ?>
                                <span class="discount bg-danger">Sold</span>
                            <?php endif; ?>

                            <img src="dist/assets/img/<?= $p['gambar']; ?>" alt="<?= htmlspecialchars($p['nama_produk']); ?>">

                            <h5><?= htmlspecialchars($p['nama_produk']); ?></h5>
                            <p class="price">Rp <?= number_format($p['harga'], 0, ',', '.'); ?></p>

                            <div class="product-action">
                                <a href="detail_produk.php?id=<?= $p['id_produk']; ?>" 
                                   class="btn-price text-decoration-none">
                                    Detail Produk
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Produk tidak ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>
</section>



     <!-- REVIEW SECTION  -->
<?php if(!$is_search): ?>
<section id="review" class="review-section">
    <div class="container">
        <h2 class="text-center fw-bold mb-5" style="font-size:48px;">𝓒𝓾𝓼𝓽𝓸𝓶𝓮𝓻 𝓡𝓮𝓿𝓲𝓮𝔀</h2>
        <div class="row g-4 mb-5">
            <?php foreach($review as $r): ?>
                <div class="col-md-4">
                    <div class="review-card">
                        <div class="review-stars"><?= str_repeat("⭐",$r['rating']); ?></div>
                        <p><?= $r['komentar']; ?></p>
                        <div class="review-name fw-bold"><?= $r['nama_user']; ?></div>
                        <small class="text-muted">Happy Customer</small>
                        <span class="review-quote">❝</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center">
            <a href="review_user.php" class="review-btn">Spill Review Kamu 👀</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FOOTER -->
<footer>
    <div class="container text-center">
        <div class="mb-3">
            <img src="dist/assets/img/logo_drink.png" alt="logo" style="height:50px;">
        </div>
        <div class="mb-3">
            <a href="https://www.instagram.com/deanrs__?igsh=cGswdGEybmZwYTh3&utm_source=qr" class="social-icon"><i class="bi bi-instagram"></i></a>
            <a href="https://www.youtube.com/channel/UCGrasGCrL8MwJy1t24x1ogA" class="social-icon"><i class="bi bi-youtube"></i></a>
        </div>
        <div style="font-size:14px;">
            Designed by <a href="#" class="text-white text-decoration-none fw-bold">Dea<br>
            &copy; <?= date('Y'); ?> eadirnk cafe.
        </div>
    </div>
</footer>

<!-- EDIT PROFIL -->
<div class="modal fade" id="modalProfil">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content profil-modal">

      <!-- HEADER -->
      <div class="profil-header">
        <i class="bi bi-person-circle profil-icon"></i>
        <h5>Edit Profil</h5>
        <small>Perbarui biodata akun kamu</small>
      </div>

      <form method="POST">
        <div class="modal-body profil-body">

          <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" value="<?= $data_user['username']; ?>" class="form-control profil-input" required>
          </div>

          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="<?= $data_user['email']; ?>" class="form-control profil-input" required>
          </div>

          <div class="mb-4">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control profil-input" placeholder="Kosongkan jika tidak diubah">
          </div>

          <button type="submit" name="update_profil" class="btn profil-btn-save">
            Simpan Perubahan
          </button>
        </div>
      </form>

      <div class="profil-footer">
        <button type="button" class="btn btn-sm profil-btn-cancel" data-bs-dismiss="modal">Batal</button>
      </div>

    </div>
  </div>
</div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
