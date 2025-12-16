<?php
// index.php
include "config/koneksi.php"; // Hubungkan ke database
include "config/functions.php"; // Hubungkan fungsi

// Bagian Template Atas
include "template/header.php";
include "template/navbar.php";


// Logika Routing Sederhana
$page = isset($_GET['p']) ? $_GET['p'] : 'home'; // Default ke 'home'

if ($page == "" || $page == "home") {
    include "template/jumbotron.php";
}

// Gunakan switch case agar lebih rapi daripada if-else bertumpuk
switch ($page) {
    case 'home':
        include "pages/home.php";
        break;
    case 'kategori':
        include "pages/category.php";
        break;
    case 'baca':
        include "pages/read.php";
        break;
    default:
        echo "<div class='container'><h3>Halaman tidak ditemukan!</h3></div>";
        break;
}

// Bagian Template Bawah
include "template/footer.php";
?>