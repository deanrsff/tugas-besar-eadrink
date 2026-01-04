<?php
session_start();
require_once 'function.php';

if (!isset($_SESSION['cart'])) {
    header("Location: keranjang.php");
    exit;
}

// Hapus satu item
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

header("Location: keranjang.php");
exit;
