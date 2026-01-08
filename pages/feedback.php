<?php
$alert_status = ""; 
$alert_message = "";
$alert_error_detail = "";

// LOGIKA KIRIM FEEDBACK
if(isset($_POST['kirim_feedback'])){

    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $subjek  = mysqli_real_escape_string($koneksi, $_POST['subjek']);
    $isi     = mysqli_real_escape_string($koneksi, $_POST['isi']);


    $query = "INSERT INTO tb_feedback (nama, subjek, deskripsi_feedback)
              VALUES ('$nama', '$subjek', '$isi')";
    

    if(mysqli_query($koneksi, $query)){
        $alert_status = "success";
        $alert_message = "Terima kasih, masukan Anda sangat berarti bagi kami.";
    } else {
        $alert_status = "error";
        $alert_message = "Maaf, masukan gagal terkirim.";
        $alert_error_detail = mysqli_error($koneksi);
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid px-3 px-md-5 py-4 mb-4">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            
            <h4 class="fw-bold text-primary mb-4 border-bottom pb-2">Kirim Masukan</h4>
            
            <div class="alert alert-light border border-secondary border-opacity-25 py-3 mb-4">
                <div class="d-flex">
                    <div class="fs-4 text-primary me-3">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Suara Anda Sangat Berarti</h6>
                        <p class="mb-0 small text-muted">
                            Silakan kirimkan kritik, saran, atau laporan kendala terkait penggunaan aplikasi SakuStat ini.
                        </p>
                    </div>
                </div>
            </div>

            <form action="" method="POST">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Anda</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Subjek Masukan</label>
                    <input type="text" name="subjek" class="form-control" placeholder="Contoh: Saran Penambahan Fitur Search" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="isi" class="form-control" rows="5" placeholder="Tuliskan detail masukan Anda di sini..." required></textarea>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" name="kirim_feedback" class="btn btn-primary px-4">
                        <i class="fa-solid fa-paper-plane me-2"></i> Kirim Masukan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php if ($alert_status != ""): ?>
<script>
    const status = <?= json_encode($alert_status); ?>;
    const message = <?= json_encode($alert_message); ?>;
    const errorDetail = <?= json_encode($alert_error_detail); ?>;

    if (status === 'success') {
        Swal.fire({
            title: 'Terkirim!',
            text: message,
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#0d6efd'
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                window.location.href = 'index.php?p=feedback';
            }
        });
    } else {
        Swal.fire({
            title: 'Gagal!',
            text: message + ' Error: ' + errorDetail,
            icon: 'error',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#dc3545'
        });
    }
</script>
<?php endif; ?>