<?php
include "config/koneksi.php";

include "template/header.php";
include "template/navbar.php";

$page = isset($_GET['p']) ? $_GET['p'] : 'home'; 

include "template/breadcrumb.php"; 

if ($page == "" || $page == "home") {
    include "template/jumbotron.php";
}

switch ($page) {
    case 'home':
        include "pages/home.php";
        break;
    case 'hasil-pencarian':
        include "pages/hasil-pencarian.php";
        break;
    case 'detail-kegiatan':
        include "pages/detail-kegiatan.php";
        break;
    case 'pedoman': 
        include "pages/pedoman.php";
        break;
    case 'feedback':
        include "pages/feedback.php";
        break;
    default:
        echo "<div class='container py-5 text-center'>
                <h3>Halaman tidak ditemukan!</h3>
              </div>";
        break;
}

include "template/footer.php";
?>