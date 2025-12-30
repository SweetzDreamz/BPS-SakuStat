<div class="container-fluid px-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-comments me-1"></i>
                <b>Feedback / Masukan</b>
            </div>
            </div>  
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                    <thead class="table-secondary">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Kegiatan</th>
                            <th width="10%">Nama Pengirim</th>
                            <th width="20%">Subjek</th>
                            <th width="35%">Deskripsi</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = "SELECT f.*, k.nama_kegiatan 
                                  FROM tb_feedback f 
                                  LEFT JOIN tb_kegiatan k ON f.id_kegiatan = k.id_kegiatan 
                                  ORDER BY f.id_feedback DESC";
                        
                        $sql = mysqli_query($koneksi, $query);

                        while ($data = mysqli_fetch_assoc($sql)) { 
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><span class="small"><?= $data['nama_kegiatan']; ?></span></td>
                                <td><span class="small"><?= htmlspecialchars($data['nama']); ?></span></td>
                                <td><span class="small"><?= substr(htmlspecialchars($data['subjek']), 0, 50); ?></span></td>
                                <td><span class="small"><?= substr(htmlspecialchars($data['deskripsi_feedback']), 0, 100); ?></span></td>
                                
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm text-white me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detail-feedback<?= $data['id_feedback']; ?>" 
                                            title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    
                                    <a href="pages/proses-feedback/del-data-feedback.php?id=<?= $data['id_feedback']; ?>" 
                                       class="btn btn-danger btn-sm btn-hapus" 
                                       title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="detail-feedback<?= $data['id_feedback']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title"><i class="fa-solid fa-circle-info me-2"></i>Detail Masukan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kegiatan Terkait</label>
                                                <input type="text" class="form-control" value="<?= $data['nama_kegiatan']; ?>" readonly>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Nama Pengirim</label>
                                                    <input type="text" class="form-control" value="<?= $data['nama']; ?>" readonly>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Subjek</label>
                                                    <input type="text" class="form-control" value="<?= $data['subjek']; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Isi Deskripsi / Masukan Lengkap</label>
                                                <textarea class="form-control" rows="6" readonly><?= $data['deskripsi_feedback']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            
                                            <a href="pages/proses-feedback/del-data-feedback.php?id=<?= $data['id_feedback']; ?>" 
                                               class="btn btn-danger btn-hapus">
                                                <i class="fa-solid fa-trash me-1"></i> Hapus Data
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>