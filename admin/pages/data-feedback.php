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
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        
                                        <div class="modal-header border-bottom-0 pb-0">
                                            <h5 class="modal-title fw-bold text-primary">
                                                <i class="fa-regular fa-envelope-open me-2"></i> Detail Pesan Masukan
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body pt-3 px-4">
                                            
                                            <div class="bg-light p-4 rounded mb-4 shadow-sm border">
                                                
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-4 text-muted small text-uppercase fw-bold pt-1">
                                                        Dari
                                                    </div>
                                                    <div class="col-sm-9 col-8 text-dark border-bottom pb-1">
                                                        <?= htmlspecialchars($data['nama']); ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-4 text-muted small text-uppercase fw-bold pt-1">
                                                        Untuk Kegiatan
                                                    </div>
                                                    <div class="col-sm-9 col-8 border-bottom pb-1">
                                                        <?= $data['nama_kegiatan']; ?>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-3 col-4 text-muted small text-uppercase fw-bold pt-1">
                                                        Subjek
                                                    </div>
                                                    <div class="col-sm-9 col-8 border-bottom pb-1">
                                                        <?= htmlspecialchars($data['subjek']); ?>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="bg-light p-4 rounded mb-4 shadow-sm border">
                                                <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">
                                                    <i class="fa-solid fa-align-left me-2"></i>Feedback
                                                </h6>
                                                
                                                <div>
                                                    <p><?= htmlspecialchars($data['deskripsi_feedback']); ?></p>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
                                            
                                            <a href="pages/proses-feedback/del-data-feedback.php?id=<?= $data['id_feedback']; ?>" 
                                            class="btn btn-danger btn-hapus px-4">
                                                <i class="fa-solid fa-trash me-2"></i> Hapus Pesan
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