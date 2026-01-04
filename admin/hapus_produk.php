<?php
session_start();
require '../function.php';

if (!is_admin_logged_in()) {
    header("Location: login_admin.php");
    exit;
}

$id = (int)$_GET['id'];

if (hapus_produk($id) > 0) {
    echo "
        <script>
            alert('Produk berhasil dihapus!');
            document.location.href = 'produk.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Produk gagal dihapus!');
            document.location.href = 'produk.php';
        </script>
    ";
}
?>
