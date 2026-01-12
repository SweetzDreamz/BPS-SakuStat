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

    case 'data-kegiatan':
        include "pages/data-kegiatan.php";
        break;

    case 'data-kategori':
        include "pages/data-kategori.php";
        break;

    case 'data-pedoman':
        include "pages/data-pedoman.php";
        break;

    case 'data-kuisioner':
        include "pages/data-kuisioner.php";
        break;

    case 'data-pengguna': 
        include "pages/data-pengguna.php";
        break;

    case 'feedback':
        include "pages/data-feedback.php";
        break;

    case 'data-pertanyaan':
        include "pages/data-pertanyaan.php";
        break;

    case 'data-kasusbatas':
        include "pages/data-kasusbatas.php";
        break;

    default:
        echo "<div class='container-fluid px-4 mt-4'><h3>Halaman tidak ditemukan!</h3></div>";
        break;
}
include "../template/adminFooter.php";
?>