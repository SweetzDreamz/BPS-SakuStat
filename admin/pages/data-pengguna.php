<div class="container-fluid px-4">

    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-users me-1"></i>
                <b>Data Pengguna</b>
            </div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahUser">
                <i class="fa-solid fa-plus me-1"></i> Tambah User
            </button>
        </div>  
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                    <thead class="table-secondary">
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sqlU = mysqli_query($koneksi, "SELECT * FROM tb_user ORDER BY nama ASC");
                        
                        while ($dataU = mysqli_fetch_assoc($sqlU)) { 
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $dataU['nip']; ?></td>
                                <td class="text-capitalize"><?= $dataU['nama']; ?></td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm text-white me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#edit-user<?= $dataU['nip']; ?>" 
                                            title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    
                                        <a href="pages/proses-pengguna/del-data-pengguna.php?id=<?= $dataU['nip']; ?>" 
                                        class="btn btn-danger btn-sm btn-hapus" 
                                        title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="edit-user<?= $dataU['nip']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Pengguna</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="pages/proses-pengguna/edit-data-pengguna.php" method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="nip_lama" value="<?= $dataU['nip']; ?>">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">NIP</label>
                                                    <input type="text" name="nip" class="form-control" value="<?= $dataU['nip']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                                    <input type="text" name="nama" class="form-control" value="<?= $dataU['nama']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Password Baru <small class="text-muted fw-normal">(Biarkan jika tidak ingin mengubah)</small></label>
                                                    <input type="password" name="password" class="form-control" value="<?= $dataU['password']; ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" name="edit_user" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
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

<div class="modal fade" id="tambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa-solid fa-user-plus me-2"></i>Tambah Pengguna Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="pages/proses-pengguna/add-data-pengguna.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">NIP</label>
                        <input type="number" name="nip" class="form-control" placeholder="Masukkan NIP" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="********" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="add_user" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
