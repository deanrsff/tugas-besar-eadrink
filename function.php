<?php
require_once 'function.php';

// Koneksikan Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "eadrink";

$koneksi = new mysqli($host, $user, $pass, $db);
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Login User 
function is_user_logged_in() {
    return isset($_SESSION['user_id']);
}

// Login Admin 
function is_admin_logged_in() {
    return isset($_SESSION['admin_id']);
}

function redirect_if_admin_logged_in() {
    if (isset($_SESSION['admin_id'])) {
        header("Location: admin/admin_dashboard.php");
        exit;
    }
}

// Query select/Ambil Data
function query($sql) {
    global $koneksi;
    $result = $koneksi->query($sql);
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

// Exucute Query/update,ubah,edit 
function execute($sql){
    global $koneksi;
    return $koneksi->query($sql);
}

/* Escape Input */
function escape($data) {
    global $koneksi;
    return htmlspecialchars($koneksi->real_escape_string($data));
}

//  Ambil Semua Pesanan Admin
function get_all_pesanan(){
    return query("SELECT 
        tanggal_pesanan AS tanggal,
        nama_pemesan AS nama,
        no_hp AS hp,
        alamat,
        metode_pembayaran AS pembayaran,
        status
    FROM pesanan ORDER BY tanggal_pesanan DESC");
}

// Ambil Semua Pesanan User
function get_user_pesanan($id_user){
    return query("SELECT 
        tanggal_pesanan AS tanggal,
        nama_pemesan AS nama,
        no_hp AS hp,
        alamat,
        metode_pembayaran AS pembayaran,
        status
    FROM pesanan WHERE id_user='$id_user' ORDER BY tanggal_pesanan DESC");
}

//Hapus Produk
function hapus_produk($id){
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = $id");
    return mysqli_affected_rows($koneksi);
}

