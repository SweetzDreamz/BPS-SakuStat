<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit;
}

include "../template/adminHeader.php";

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

switch ($page) {
    case 'dashboard':
        include "pages/dashboard.php"; 
        break;

    case 'kegiatan':
        include "pages/data-kegiatan.php";
        break;

    case 'kategori':
        include "pages/data-kategori.php";
        break;

    case 'data-pengguna': 
        include "pages/data-pengguna.php";
        break;
    
    default:
        echo "<div class='container-fluid px-4 mt-4'><h3>Halaman tidak ditemukan!</h3></div>";
        break;
}
include "../template/adminFooter.php";
?>