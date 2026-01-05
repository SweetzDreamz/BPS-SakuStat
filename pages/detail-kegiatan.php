<?php
// 1. TANGKAP ID KEGIATAN
$id_kegiatan = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';

// 2. LOGIKA KIRIM FEEDBACK
if(isset($_POST['kirim_feedback'])){
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $subjek  = mysqli_real_escape_string($koneksi, $_POST['subjek']);
    $isi     = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $id_keg  = $_POST['id_kegiatan_form'];

    $q_feed = "INSERT INTO tb_feedback (nama, subjek, deskripsi_feedback, id_kegiatan) 
               VALUES ('$nama', '$subjek', '$isi', '$id_keg')";
    
    if(mysqli_query($koneksi, $q_feed)){
        echo "<script>alert('Terima kasih! Masukan Anda telah terkirim.'); window.location.href='index.php?p=detail-kegiatan&id=$id_keg';</script>";
    } else {
        echo "<script>alert('Gagal mengirim feedback.');</script>";
    }
}

// 3. QUERY UTAMA
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
    <div class="container-fluid px-5 py-2"> 
        <h2 class="fw-bold mb-0 text-uppercase display-6"><?= $data['nama_kegiatan']; ?></h2>
        <p class="mb-0 opacity-75 mt-2 fs-6"><i class="fa-solid fa-tag me-2"></i><?= $data['nama_kategori']; ?></p>
    </div>
</div>

<div class="container-fluid px-5 py-4 mb-5">

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
                        <button class="nav-link text-start rounded-0 py-3 ps-4" id="v-pills-feedback-tab" data-bs-toggle="pill" data-bs-target="#v-pills-feedback" type="button" role="tab">Feedback / Masukan</button>
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
                                        <td class="text-center" style="white-space: nowrap;"><?= $no++; ?></td>
                                        
                                        <td><?= nl2br($row['situasi_lapangan']); ?></td>
                                        <td><?= nl2br($row['jawaban_kasusbatas']); ?></td>
                                    </tr>
                                    <?php 
                                        } 
                                    } 
                                    ?>
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

                <div class="tab-pane fade" id="v-pills-feedback" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-primary mb-4 border-bottom pb-2">Kirim Masukan</h4>
                            <p class="text-muted mb-4">Silakan kirimkan masukan Anda terkait kegiatan ini.</p>
                            <form action="" method="POST">
                                <input type="hidden" name="id_kegiatan_form" value="<?= $id_kegiatan; ?>">
                                <div class="mb-3"><label class="form-label fw-bold">Nama Anda</label><input type="text" name="nama" class="form-control" required></div>
                                <div class="mb-3"><label class="form-label fw-bold">Subjek Masukan</label><input type="text" name="subjek" class="form-control" required></div>
                                <div class="mb-3"><label class="form-label fw-bold">Deskripsi</label><textarea name="isi" class="form-control" rows="5" required></textarea></div>
                                <button type="submit" name="kirim_feedback" class="btn btn-primary px-4"><i class="fa-solid fa-paper-plane me-2"></i> Kirim</button>
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

<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable('#table-kasus-unik')) {
            $('#table-kasus-unik').DataTable({
                "autoWidth": false, 
                "columnDefs": [
                    { "width": "1%", "targets": 0 } 
                ],
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "infoFiltered": "(disaring dari _MAX_ total entri)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Awal",
                        "last": "Akhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 5,
                "lengthMenu": [5, 10, 25, 50]
            });
        }
    });
</script>

