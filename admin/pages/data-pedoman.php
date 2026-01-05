<div class="container-fluid px-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-book me-1"></i>
                <b>Data Pedoman</b>
            </div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPedoman">
                <i class="fa-solid fa-plus me-1"></i> Tambah Pedoman
            </button>
        </div>  
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                    <thead class="table-secondary">
                        <tr>
                            <th width="5%">No</th>
                            <th>ID Pedoman</th>
                            <th width="10%">Cover</th>
                            <th>Judul Pedoman</th>
                            <th>Kategori</th>
                            <th>Link Drive</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = "SELECT p.*, k.nama_kategori 
                                  FROM tb_pedoman p 
                                  LEFT JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
                                  ORDER BY p.id_pedoman DESC";
                        
                        $sql = mysqli_query($koneksi, $query);

                        while ($data = mysqli_fetch_assoc($sql)) { 
                            $gambar = $data['cover_pedoman'];
                            if ($gambar == null || $gambar == "") {
                                $imgSrc = "../assets/img/cover-pedoman/default.png"; 
                            } else {
                                $imgSrc = "../assets/img/cover-pedoman/" . $gambar;
                            }
                        ?>
                            <tr>
                                <td class="small"><?= $no++; ?></td>
                                <td class="small"><?= $data['id_pedoman']; ?></td>
                                <td class="text-center">
                                    <img src="<?= $imgSrc; ?>" alt="Cover" style="width: 50px; height: 70px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                                </td>
                                <td class="small"><?= $data['nama_pedoman']; ?></td>
                                <td class="small"><?= $data['nama_kategori']; ?></td>
                                <td>
                                    <a href="<?= $data['link_pedoman']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-brands fa-google-drive"></i> Buka
                                    </a>
                                </td>
                                
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm text-white me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#edit-pedoman<?= $data['id_pedoman']; ?>" 
                                            title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    
                                    <a href="pages/proses-pedoman/del-data-pedoman.php?id=<?= $data['id_pedoman']; ?>&img=<?= $data['cover_pedoman']; ?>" 
                                       class="btn btn-danger btn-sm btn-hapus" 
                                       title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>

                                    <div class="modal fade text-start" id="edit-pedoman<?= $data['id_pedoman']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Pedoman</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="pages/proses-pedoman/edit-data-pedoman.php" method="POST" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_pedoman" value="<?= $data['id_pedoman']; ?>">
                                                        <input type="hidden" name="cover_lama" value="<?= $data['cover_pedoman']; ?>">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Judul Pedoman</label>
                                                            <input type="text" name="judul" class="form-control" value="<?= $data['nama_pedoman']; ?>" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Kategori</label>
                                                            <select name="id_kategori" class="form-select" required>
                                                                <option value="">-- Pilih Kategori --</option>
                                                                <?php
                                                                // Reset Query Kategori untuk setiap modal edit
                                                                $sqlK_edit = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY nama_kategori ASC");
                                                                while($kat_edit = mysqli_fetch_assoc($sqlK_edit)){
                                                                    $selected = ($kat_edit['id_kategori'] == $data['id_kategori']) ? "selected" : "";
                                                                    echo "<option value='".$kat_edit['id_kategori']."' $selected>".$kat_edit['id_kategori']." - ".$kat_edit['nama_kategori']."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Link Google Drive</label>
                                                            <input type="text" name="link_drive" class="form-control" value="<?= $data['link_pedoman']; ?>" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Ganti Cover <small class="text-muted fw-normal">(Biarkan kosong jika tidak diganti)</small></label>
                                                            <br>
                                                            <img src="<?= $imgSrc; ?>" width="80" class="mb-2 border rounded">
                                                            <input type="file" name="cover" class="form-control" accept=".jpg, .jpeg, .png">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" name="edit_pedoman" class="btn btn-primary btn-simpan">Simpan Perubahan</button>
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

<div class="modal fade" id="tambahPedoman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa-solid fa-book me-2"></i>Tambah Pedoman Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="pages/proses-pedoman/add-data-pedoman.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Pedoman</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Pedoman Sakernas 2025" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Kategori --</option>
                            <?php
                            $sqlK_add = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY nama_kategori ASC");
                            while($kat_add = mysqli_fetch_assoc($sqlK_add)){
                                echo "<option value='".$kat_add['id_kategori']."'>".$kat_add['id_kategori']." - ".$kat_add['nama_kategori']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Link Google Drive</label>
                        <input type="text" name="link_drive" class="form-control" placeholder="https://drive.google.com/..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Cover <small class="text-muted">(Format: JPG, PNG)</small></label>
                        <input type="file" name="cover" class="form-control" accept=".jpg, .jpeg, .png">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="add_pedoman" class="btn btn-primary btn-simpan">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>