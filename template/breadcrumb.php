<?php
// Inisialisasi variabel
$current_page_label = "";
$parent_page_label  = ""; // Variabel baru untuk breadcrumb tengah
$parent_page_link   = ""; // Variabel baru untuk link breadcrumb tengah

if($page == 'hasil-pencarian'){
    
    // Logika Label untuk Halaman Pencarian (Level 2)
    if(isset($_GET['keyword'])){
        $current_page_label = "Pencarian: " . htmlspecialchars($_GET['keyword']);
    } elseif(isset($_GET['kategori'])){
        $id_kat_bc = mysqli_real_escape_string($koneksi, $_GET['kategori']);
        $q_kat_bc  = mysqli_query($koneksi, "SELECT nama_kategori FROM tb_kategori WHERE id_kategori='$id_kat_bc'");
        $d_kat_bc  = mysqli_fetch_assoc($q_kat_bc);
        $current_page_label = "Kategori: " . ($d_kat_bc['nama_kategori'] ?? 'Tidak Diketahui');
    } else {
        $current_page_label = "Semua Kegiatan";
    }

} elseif ($page == 'detail-kegiatan') {
    
    // 1. SET MIDDLE CRUMB (PARENT)
    // Kita set agar kembali ke halaman "Hasil Pencarian"
    $parent_page_label = "Hasil Pencarian";
    $parent_page_link  = "index.php?p=hasil-pencarian"; 
    
    // 2. SET CURRENT CRUMB (ACTIVE)
    // Ambil nama kegiatan agar breadcrumb lebih informatif
    if(isset($_GET['id'])){
        $id_keg_bc = mysqli_real_escape_string($koneksi, $_GET['id']);
        $q_keg_bc  = mysqli_query($koneksi, "SELECT nama_kegiatan FROM tb_kegiatan WHERE id_kegiatan='$id_keg_bc'");
        $d_keg_bc  = mysqli_fetch_assoc($q_keg_bc);
        
        $judul_pendek = isset($d_keg_bc['nama_kegiatan']) ? $d_keg_bc['nama_kegiatan'] : "Detail Kegiatan";
        $current_page_label = $judul_pendek;
    } else {
        $current_page_label = "Detail Kegiatan";
    }

} elseif ($page == 'pedoman') {
    $current_page_label = "Buku Pedoman";
}
?>

<?php if($page != 'home' && $page != ''){ ?>

<div class="bg-info bg-opacity-10 border-bottom border-primary py-1">
    <div class="container-fluid px-3 px-md-5 breadcrumb-container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 flex-nowrap align-items-center">
                
                <li class="breadcrumb-item">
                    <span class="small">
                        <a href="index.php" class="text-decoration-none text-primary">
                            <i class="fa-solid fa-house d-md-none"></i> <span class="d-none d-md-inline">Beranda</span> </a>
                    </span>
                </li>

                <?php if(!empty($parent_page_label)) { ?>
                <li class="breadcrumb-item">
                    <span class="small">
                        <a href="<?= $parent_page_link; ?>" class="text-decoration-none text-primary">
                            <span class="d-md-none">Cari</span> 
                            <span class="d-none d-md-inline"><?= $parent_page_label; ?></span>
                        </a>
                    </span>
                </li>
                <?php } ?>
                
                <li class="breadcrumb-item active text-muted" aria-current="page">
                    <span class="small" title="<?= $current_page_label; ?>"> <?= $current_page_label; ?>
                    </span>
                </li>

            </ol>
        </nav>
    </div>
</div>
<?php } ?>