<?php
// 1. TANGKAP ID KEGIATAN (Wajib ada)
$id_kegiatan = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';

$alert_status = "";
$alert_message = "";
$alert_error = "";

// 2. LOGIKA KIRIM PERTANYAAN
if(isset($_POST['kirim_pertanyaan'])){
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $isi     = mysqli_real_escape_string($koneksi, $_POST['isi']); 
    
    if(!empty($id_kegiatan)){
        $q_tanya = "INSERT INTO tb_pertanyaan (nama, deskripsi_pertanyaan, id_kegiatan) 
                    VALUES ('$nama', '$isi', '$id_kegiatan')"; 
        
        if(mysqli_query($koneksi, $q_tanya)){
            $alert_status = "success";
            $alert_message = "Terima kasih! Pertanyaan Anda telah terkirim.";
        } else {
            $alert_status = "error";
            $alert_message = "Gagal mengirim pertanyaan.";
            $alert_error = mysqli_error($koneksi);
        }
    } else {
        $alert_status = "error";
        $alert_message = "Gagal: ID Kegiatan tidak ditemukan.";
    }
}

// 3. QUERY UTAMA (HANYA AMBIL DETAIL KEGIATAN & PEDOMAN)
// REVISI: Saya menghapus JOIN tb_kuisioner dari sini agar tidak error logic
$query = "SELECT k.*, c.nama_kategori, p.nama_pedoman, p.link_pedoman, p.cover_pedoman 
          FROM tb_kegiatan k
          LEFT JOIN tb_kategori c ON k.id_kategori = c.id_kategori
          LEFT JOIN tb_pedoman p ON k.id_pedoman = p.id_pedoman
          WHERE k.id_kegiatan = '$id_kegiatan'";

$result = mysqli_query($koneksi, $query);
$data   = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<div class='container py-5 text-center'><h3>Data Kegiatan tidak ditemukan!</h3><a href='index.php' class='btn btn-primary'>Kembali</a></div>";
    exit;
}
?>

<div class="bg-primary text-white w-100 py-3"> 
    <div class="container-fluid px-3 px-md-5 py-2"> 
        <h2 class="fw-bold mb-0 text-uppercase display-6"><?= $data['nama_kegiatan']; ?></h2>
        <p class="mb-0 opacity-75 mt-2 fs-6"><i class="fa-solid fa-tag me-2"></i><?= $data['nama_kategori']; ?></p>
    </div>
</div>

<div class="container-fluid px-3 px-md-5 py-4 mb-5">

    <div class="row g-3">
        
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light fw-bold py-3 text-primary border-bottom">
                    <i class="fa-solid fa-list-ul me-2"></i> DETAIL KEGIATAN
                </div>
                <div class="card-body p-0">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active text-start rounded-0 py-3 ps-4 border-bottom" id="v-pills-umum-tab" data-bs-toggle="pill" data-bs-target="#v-pills-umum" type="button" role="tab">Informasi Umum</button>
                        <button class="nav-link text-start rounded-0 py-3 ps-4 border-bottom" id="v-pills-kasus-tab" data-bs-toggle="pill" data-bs-target="#v-pills-kasus" type="button" role="tab">Kasus Batas</button>
                        <button class="nav-link text-start rounded-0 py-3 ps-4 border-bottom" id="v-pills-pedoman-tab" data-bs-toggle="pill" data-bs-target="#v-pills-pedoman" type="button" role="tab">Pedoman</button>
                        <button class="nav-link text-start rounded-0 py-3 ps-4 border-bottom" id="v-pills-kuisioner-tab" data-bs-toggle="pill" data-bs-target="#v-pills-kuisioner" type="button" role="tab">Kuisioner</button>
                        <button class="nav-link text-start rounded-0 py-3 ps-4" id="v-pills-pertanyaan-tab" data-bs-toggle="pill" data-bs-target="#v-pills-pertanyaan" type="button" role="tab">Pertanyaan Kasus Batas</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">
                
                <div class="tab-pane fade show active" id="v-pills-umum" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-primary mb-4 border-bottom pb-2">Informasi Umum</h4>
                            <table class="table table-borderless">
                                <tr><th width="25%" class="text-muted">Nama Kegiatan</th><td class="fw-bold"><?= $data['nama_kegiatan']; ?></td></tr>
                                <tr><th class="text-muted">Kategori</th><td><?= $data['nama_kategori']; ?></td></tr>
                                <tr><th class="text-muted">Responden</th><td><?= $data['responden']; ?></td></tr>
                                <tr><th class="text-muted">Level Estimasi</th><td><?= $data['level_estimasi']; ?></td></tr>
                                <tr><th class="text-muted">Deskripsi</th><td style="text-align: justify; line-height: 1.6;"><?= nl2br($data['deskripsi_kegiatan']); ?></td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-kasus" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-primary mb-4 border-bottom pb-2">Daftar Kasus Batas</h4>
                            <?php
                            $q_kasus = mysqli_query($koneksi, "SELECT * FROM tb_kasusbatas WHERE id_kegiatan='$id_kegiatan' ORDER BY id_kasusbatas DESC");
                            ?>
                            <div class="table-responsive">
                                <table id="table-kasus-unik" class="table table-striped table-hover table-bordered w-100">
                                    <thead class="table-secondary text-center">
                                        <tr>
                                            <th style="width: 1%; white-space: nowrap;" class="text-center">No</th>
                                            <th class="text-center">Situasi Lapangan / Pertanyaan</th>
                                            <th class="text-center">Jawaban / Solusi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        if(mysqli_num_rows($q_kasus) > 0){
                                            while($row = mysqli_fetch_assoc($q_kasus)){ 
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= nl2br($row['situasi_lapangan']); ?></td>
                                            <td><?= nl2br($row['jawaban_kasusbatas']); ?></td>
                                        </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-pedoman" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-primary mb-4 border-bottom pb-2">Buku Pedoman</h4>
                            <?php if(!empty($data['nama_pedoman'])) { ?>
                                <div class="row align-items-start">
                                    <div class="col-md-3 text-center mb-3 mb-md-0">
                                        <?php $cover = !empty($data['cover_pedoman']) ? "assets/img/cover-pedoman/".$data['cover_pedoman'] : "assets/img/pdf-placeholder.png"; ?>
                                        <img src="<?= $cover; ?>" class="img-fluid rounded shadow" style="max-height: 200px;" alt="Cover Pedoman">
                                    </div>
                                    <div class="col-md-9">
                                        <h5 class="fw-bold"><?= $data['nama_pedoman']; ?></h5>
                                        <p class="text-muted">Dokumen resmi pedoman pencacahan untuk kegiatan ini.</p>
                                        <?php if(!empty($data['link_pedoman'])) { ?>
                                            <a href="<?= $data['link_pedoman']; ?>" target="_blank" class="btn btn-danger"><i class="fa-solid fa-file-pdf me-2"></i> Buka Pedoman</a>
                                        <?php } else { ?>
                                            <button class="btn btn-secondary" disabled>File tidak tersedia</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-secondary"><i class="fa-solid fa-book-open me-2"></i> Tidak ada pedoman yang dilampirkan.</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-kuisioner" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-primary mb-4 border-bottom pb-2">Daftar Kuisioner</h4>
                            
                            <?php 
                            // REVISI: Query khusus untuk mengambil SEMUA kuisioner berdasarkan id_kegiatan
                            $q_kuis = mysqli_query($koneksi, "SELECT * FROM tb_kuisioner WHERE id_kegiatan = '$id_kegiatan' ORDER BY id_kuisioner ASC");
                            
                            if(mysqli_num_rows($q_kuis) > 0) {
                                // Loop untuk menampilkan jika kuisioner lebih dari 1
                                while($kuis = mysqli_fetch_assoc($q_kuis)) {
                            ?>
                                <div class="card mb-3 bg-light">
                                    <div class="row g-0">
                                        <div class="col-md-2 p-2 text-center d-flex align-items-center justify-content-center bg-white">
                                            <?php 
                                            $coverK = !empty($kuis['cover_kuisioner']) ? "assets/img/cover-kuisioner/".$kuis['cover_kuisioner'] : "assets/img/pdf-placeholder.png"; 
                                            ?>
                                            <img src="<?= $coverK; ?>" class="img-fluid rounded" style="max-height: 100px; object-fit: contain;" alt="Cover">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="card-body py-2">
                                                <h5 class="card-title fw-bold text-dark"><?= $kuis['nama_kuisioner']; ?></h5>
                                                <p class="card-text text-muted small mb-2">Dokumen kuisioner pendukung kegiatan.</p>
                                                
                                                <?php if(!empty($kuis['link_kuisioner'])) { ?>
                                                    <a href="<?= $kuis['link_kuisioner']; ?>" target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="fa-solid fa-up-right-from-square me-1"></i> Buka Link / File
                                                    </a>
                                                <?php } else { ?>
                                                    <button class="btn btn-sm btn-secondary" disabled>Link Tidak Tersedia</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                                } // End While
                            } else { 
                            ?>
                                <div class="alert alert-secondary text-center py-4">
                                    <i class="fa-solid fa-folder-open fs-1 mb-2 d-block text-muted"></i>
                                    Belum ada kuisioner yang ditambahkan untuk kegiatan ini.
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-pertanyaan" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-primary mb-4 border-bottom pb-2">Kirim Pertanyaan</h4>
                            <div class="alert alert-info border-0 d-flex align-items-center mb-4">
                                <i class="fa-solid fa-circle-question fs-3 me-3"></i>
                                <div>
                                    <small>Jika Anda menemukan kasus baru yang belum ada di daftar Kasus Batas, silakan kirimkan pertanyaan Anda di sini. Pertanyaan Anda akan ditinjau oleh admin.</small>
                                </div>
                            </div>
                            
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Anda</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Tulis nama Anda" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Detail Pertanyaan</label>
                                    <textarea name="isi" class="form-control" rows="5" placeholder="Jelaskan situasi atau pertanyaan Anda secara rinci..." required></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" name="kirim_pertanyaan" class="btn btn-primary px-4">
                                        <i class="fa-solid fa-paper-plane me-2"></i> Kirim Pertanyaan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link.active, .nav-pills .show > .nav-link { background-color: #0d6efd; color: white !important; border-left: 5px solid #0a58ca; font-weight: bold; }
    .nav-pills .nav-link { color: #495057; transition: all 0.3s; }
    .nav-pills .nav-link:hover { background-color: #9fc5e8; color: #0d6efd; }
    table.dataTable tbody td { vertical-align: top; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable('#table-kasus-unik')) {
            $('#table-kasus-unik').DataTable({
                "autoWidth": false, 
                "columnDefs": [ { "width": "1%", "targets": 0 } ],
                "language": {
                    "search": "Cari:",
                    "paginate": { "first": "Awal", "last": "Akhir", "next": "Selanjutnya", "previous": "Sebelumnya" },
                    "zeroRecords": "Data tidak ditemukan"
                },
                "pageLength": 5,
                "lengthMenu": [5, 10, 25, 50]
            });
        }
    });

    // SweetAlert Logic
    <?php if ($alert_status != ""): ?>
        const status = <?= json_encode($alert_status); ?>;
        const message = <?= json_encode($alert_message); ?>;
        
        if (status === 'success') {
            Swal.fire({
                title: 'Terkirim!',
                text: message,
                icon: 'success',
                confirmButtonColor: '#0d6efd'
            }).then(() => {
                window.location.href = 'index.php?p=detail-kegiatan&id=<?= $id_kegiatan; ?>';
            });
        } else {
            Swal.fire({
                title: 'Gagal!',
                text: message,
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        }
    <?php endif; ?>
</script>