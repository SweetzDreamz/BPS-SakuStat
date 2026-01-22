<div class="container-fluid px-4">

    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-scale-balanced me-1"></i>
                <b>Data Kasus Batas</b>
            </div>
            <div>
                <button class="btn btn-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#importKasus">
                    <i class="fa-solid fa-file-excel me-1"></i> Import Excel
                </button>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKasus">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Kasus
                </button>
            </div>
        </div>  
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                    <thead class="table-secondary">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Kegiatan</th>
                            <th width="30%">Situasi Lapangan</th>
                            <th width="30%">Jawaban Kasus batas</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = "SELECT kb.*, k.nama_kegiatan 
                                  FROM tb_kasusbatas kb 
                                  LEFT JOIN tb_kegiatan k ON kb.id_kegiatan = k.id_kegiatan 
                                  ORDER BY kb.id_kasusbatas DESC";
                        
                        $sql = mysqli_query($koneksi, $query);

                        while ($data = mysqli_fetch_assoc($sql)) { 
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <span class="small"><?= $data['nama_kegiatan']; ?></span>
                                </td>
                                <td>
                                    <span class="small"><?= substr($data['situasi_lapangan'], 0, 100); ?>...</span>
                                </td>
                                <td>
                                    <span class="small"><?= substr($data['jawaban_kasusbatas'], 0, 100); ?>...</span>
                                </td>
                                
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm text-white me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#edit-kasus<?= $data['id_kasusbatas']; ?>" 
                                            title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    
                                    <a href="pages/proses-kasusbatas/del-data-kasusbatas.php?id=<?= $data['id_kasusbatas']; ?>" 
                                       class="btn btn-danger btn-sm btn-hapus" 
                                       title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>

                                    <div class="modal fade text-start" id="edit-kasus<?= $data['id_kasusbatas']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Kasus Batas</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="pages/proses-kasusbatas/edit-data-kasusbatas.php" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_kasusbatas" value="<?= $data['id_kasusbatas']; ?>">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Kegiatan Terkait</label>
                                                            <select name="id_kegiatan" class="form-select" required>
                                                                <option value="">-- Pilih Kegiatan --</option>
                                                                <?php
                                                                // Reset pointer query agar dropdown selalu terisi di setiap modal (looping)
                                                                $sqlK_edit = mysqli_query($koneksi, "SELECT * FROM tb_kegiatan ORDER BY nama_kegiatan ASC");
                                                                while($keg_edit = mysqli_fetch_assoc($sqlK_edit)){
                                                                    $selected = ($keg_edit['id_kegiatan'] == $data['id_kegiatan']) ? "selected" : "";
                                                                    echo "<option value='".$keg_edit['id_kegiatan']."' $selected>".$keg_edit['nama_kegiatan']."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Situasi Lapangan</label>
                                                            <textarea name="situasi" class="form-control" rows="4" required><?= $data['situasi_lapangan']; ?></textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Jawaban Kasus Batas</label>
                                                            <textarea name="jawaban" class="form-control" rows="4" required><?= $data['jawaban_kasusbatas']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" name="edit_kasusbatas" class="btn btn-primary btn-simpan">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahKasus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa-solid fa-circle-question me-2"></i>Tambah Kasus Batas Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="pages/proses-kasusbatas/add-data-kasusbatas.php" method="POST">
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Kegiatan</label>
                        <select name="id_kegiatan" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Kegiatan --</option>
                            <?php
                            $sqlK_add = mysqli_query($koneksi, "SELECT * FROM tb_kegiatan ORDER BY nama_kegiatan ASC");
                            while($keg_add = mysqli_fetch_assoc($sqlK_add)){
                                echo "<option value='".$keg_add['id_kegiatan']."'>".$keg_add['nama_kegiatan']."</option>";
                            }
                            ?>
                        </select>
                        <div class="form-text">Kasus batas ini akan muncul pada menu kegiatan yang dipilih.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Situasi Lapangan</label>
                        <textarea name="situasi" class="form-control" rows="4" placeholder="Contoh: Bagaimana jika responden menolak diwawancarai?" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jawaban Kasus Batas</label>
                        <textarea name="jawaban" class="form-control" rows="4" placeholder="Tuliskan solusi atau pedoman penanganannya..." required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="add_kasusbatas" class="btn btn-primary btn-simpan">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="importKasus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fa-solid fa-file-import me-2"></i>Import Data Excel
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="pages/proses-kasusbatas/import-data-kasusbatas.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="alert alert-info small">
                        <strong>Aturan File Excel:</strong><br>
                        1. Format file harus <b>.xlsx</b> atau <b>.xls</b><br>
                        2. Baris pertama adalah JUDUL KOLOM (tidak akan diimport).<br>
                        3. Urutan Kolom: <b>situasi_lapangan | jawaban_kasusbatas | id_kegiatan</b>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih File Excel</label>
                        <input type="file" name="file_excel" class="form-control" accept=".xlsx, .xls" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="import_data" class="btn btn-success btn-simpan">Import Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>