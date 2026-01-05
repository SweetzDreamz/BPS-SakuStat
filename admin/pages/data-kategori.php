<div class="container-fluid px-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-tags me-1"></i>
                <b>Data Kategori</b>
            </div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKategori">
                <i class="fa-solid fa-plus me-1"></i> Tambah Kategori
            </button>
        </div>  
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                    <thead class="table-secondary">
                        <tr>
                            <th>No</th>
                            <th>ID Kategori</th>
                            <th>Nama Kategori</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sqlK = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY id_kategori ASC");
                        
                        while ($dataK = mysqli_fetch_assoc($sqlK)) { 
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $dataK['id_kategori']; ?></td>
                                <td><?= $dataK['nama_kategori']; ?></td>
                                
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm text-white me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#edit-kategori<?= $dataK['id_kategori']; ?>" 
                                            title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    
                                    <a href="pages/proses-kategori/del-data-kategori.php?id=<?= $dataK['id_kategori']; ?>" 
                                       class="btn btn-danger btn-sm btn-hapus" 
                                       title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>

                                    <div class="modal fade text-start" id="edit-kategori<?= $dataK['id_kategori']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Kategori</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="pages/proses-kategori/edit-data-kategori.php" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_lama" value="<?= $dataK['id_kategori']; ?>">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">ID Kategori</label>
                                                            <input type="text" name="id_kategori" class="form-control" value="<?= $dataK['id_kategori']; ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Nama Kategori</label>
                                                            <input type="text" name="nama_kategori" class="form-control" value="<?= $dataK['nama_kategori']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" name="edit_kategori" class="btn btn-primary btn-simpan">Simpan Perubahan</button>
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

<div class="modal fade" id="tambahKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa-solid fa-plus me-2"></i>Tambah Kategori Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="pages/proses-kategori/add-data-kategori.php" method="POST">
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Masukkan Nama Kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="add_kategori" class="btn btn-primary btn-simpan">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>