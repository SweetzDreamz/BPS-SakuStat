<div class="container-fluid px-4">

    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
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
                            <th>Email</th>
                            <th>Role</th>
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
                                <td><?= $dataU['email']; ?></td>
                                <td>
                                    <?php 
                                    if($dataU['role'] == 'Admin'){
                                        echo '<span class="badge bg-danger">Admin</span>';
                                    } else {
                                        echo '<span class="badge bg-secondary">User</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm text-white me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#edit-user<?= $dataU['nip']; ?>" 
                                            title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    
                                    <a href="pages/proses/del-data-user.php?id=<?= $dataU['nip']; ?>" 
                                       class="btn btn-danger btn-sm btn-hapus" 
                                       title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="edit-user<?= $dataU['nip']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Pengguna</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="pages/proses/edit-user.php" method="POST">
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
                                                    <label class="form-label fw-bold">Email</label>
                                                    <input type="email" name="email" class="form-control" value="<?= $dataU['email']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Role</label>
                                                    <select name="role" class="form-select" required>
                                                        <option value="User" <?= ($dataU['role'] == 'User') ? 'selected' : ''; ?>>User</option>
                                                        <option value="Admin" <?= ($dataU['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Password Baru <small class="text-muted fw-normal">(Kosongkan jika tidak ingin mengubah)</small></label>
                                                    <input type="password" name="password" class="form-control" placeholder="******">
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

<script>
    $(document).ready(function () {
        $('#example').DataTable();

        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pengguna ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            });
        });
    });
</script>