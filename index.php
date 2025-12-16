<?php
include "config/koneksi.php";

include "template/header.php";
include "template/navbar.php";

$page = isset($_GET['p']) ? $_GET['p'] : 'home'; 

if ($page == "" || $page == "home") {
    include "template/jumbotron.php";
}

switch ($page) {
    case 'home':
        include "pages/home.php";
        break;
    case 'kategori':
        include "pages/kategori.php";
        break;
    case 'baca':
        include "pages/read.php";
        break;
    default:
        echo "<div class='container'><h3>Halaman tidak ditemukan!</h3></div>";
        break;
}

include "template/footer.php";
?>