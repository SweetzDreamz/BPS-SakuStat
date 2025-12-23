<?php

// 1. LOGIKA PENGUNJUNG WEBSITE
$ip      = $_SERVER['REMOTE_ADDR'];
$tanggal = date('Y-m-d');

// Cek apakah IP ini sudah berkunjung HARI INI?
$cek_ip = mysqli_query($koneksi, "SELECT * FROM tb_pengunjung WHERE ip_address='$ip' AND tanggal='$tanggal'");

if (mysqli_num_rows($cek_ip) == 0) {
    // Jika belum ada hari ini, simpan ke database
    mysqli_query($koneksi, "INSERT INTO tb_pengunjung (ip_address, tanggal) VALUES ('$ip', '$tanggal')");
}


// 2. HITUNG TOTAL DATA UNTUK CARD
// A. Hitung Total Pengunjung (Semua waktu)
$q_pengunjung   = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_pengunjung");
$dt_pengunjung  = mysqli_fetch_assoc($q_pengunjung);
$total_pengunjung = $dt_pengunjung['total'];

// B. Hitung Total Kegiatan (Dari tb_kegiatan)
$q_kegiatan     = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_kegiatan");
$dt_kegiatan    = mysqli_fetch_assoc($q_kegiatan);
$total_kegiatan = $dt_kegiatan['total'];

// C. Hitung Total Kasus Batas (Dari tb_kasusbatas)
$q_kasus        = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_kasusbatas");
$dt_kasus       = mysqli_fetch_assoc($q_kasus);
$total_kasus    = $dt_kasus['total'];
?>

<div class="container-fluid px-5 py-4">  
    
    <div class="row g-4 mb-5"> 
        
        <div class="col-md-4 col-lg-3">
            <div class="d-flex flex-column gap-3">
                
                <div class="card border-0 shadow-sm" style="background-color: #052c65;">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-light mb-0 small text-uppercase fw-bold">Total Pengunjung</h6>
                            <h3 class="text-light fw-bold mb-0">
                                <?= number_format($total_pengunjung); ?>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm bg-primary">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-light mb-0 small text-uppercase fw-bold">Total Kegiatan</h6>
                            <h3 class="text-light fw-bold mb-0">
                                <?= number_format($total_kegiatan); ?>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="background-color: #4db8ff;">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-light mb-0 small text-uppercase fw-bold">Total Kasus Batas</h6>
                            <h3 class="text-light mb-0 fw-bold">
                                <?= number_format($total_kasus); ?>
                            </h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-8 col-lg-9">
            <div class="ps-md-4 h-100 d-flex flex-column justify-content-center"> 
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px; flex-shrink: 0;">
                        <i class="fa-solid fa-info"></i>
                    </div>
                    <h2 class="fw-bold text-primary mb-0">Apa itu SAKU STAT?</h2>
                </div>
                
                <p class="lead text-dark mb-0 fs-6" style="line-height: 1.8; text-align: justify;">
                    <strong>SakuStat</strong> adalah media referensi digital yang berisi kumpulan kasus batas yang sering ditemui oleh petugas statistik di lapangan. Aplikasi ini dibuat agar petugas dapat mengambil keputusan cepat dan tepat saat menghadapi kasus non-standar, memahami definisi operasional secara konsisten, mengurangi kesalahan pencatatan, dan meningkatkan kualitas data lapangan.
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="p-4 p-md-5 bg-white rounded shadow-sm border position-relative overflow-hidden">
                
                <i class="fa-solid fa-bullseye position-absolute text-muted opacity-25" style="font-size: 10rem; right: -20px; bottom: -20px; z-index: 0;"></i>
                
                <div class="position-relative" style="z-index: 1;">
                    <h3 class="fw-bold mb-4 border-bottom pb-3 d-inline-block text-primary">
                        <i class="fa-solid fa-bullseye me-2"></i>Tujuan Saku Stat
                    </h3>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">1</span>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Pegangan Praktis</h6>
                                    <p class="text-muted small mb-0">Menyediakan pegangan praktis bagi petugas statistik lapangan dalam menghadapi kasus batas yang sering menimbulkan keraguan.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">2</span>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Konsistensi Data</h6>
                                    <p class="text-muted small mb-0">Menyamakan pemahaman dan interpretasi petugas, sehingga hasil pencacahan lebih konsisten dan akurat.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">3</span>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Efisiensi Keputusan</h6>
                                    <p class="text-muted small mb-0">Mempercepat proses pengambilan keputusan di lapangan dengan menghadirkan referensi yang mudah diakses secara digital.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>