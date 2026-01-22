<div class="container-fluid px-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-list-check me-1"></i>
                <b>Data Kegiatan Statistik</b>
            </div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKegiatan">
                <i class="fa-solid fa-plus me-1"></i> Tambah Kegiatan
            </button>
        </div>  
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                    <thead class="table-secondary">
                        <tr>
                            <th width="5%">No</th>
                            <th>ID</th>
                            <th>Nama Kegiatan</th>
                            <th>Deskripsi</th>
                            <th>Responden</th>
                            <th>Level Estimasi</th>
                            <th>Kategori</th>
                            <th>Pedoman</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = "SELECT k.*, cat.nama_kategori, p.nama_pedoman 
                                  FROM tb_kegiatan k 
                                  LEFT JOIN tb_kategori cat ON k.id_kategori = cat.id_kategori 
                                  LEFT JOIN tb_pedoman p ON k.id_pedoman = p.id_pedoman 
                                  ORDER BY k.id_kegiatan DESC";
                        
                        $sql = mysqli_query($koneksi, $query);

                        while ($data = mysqli_fetch_assoc($sql)) { 
                        ?>
                            <tr>
                                <td><span class="small"><?= $no++; ?></span></td>
                                <td><span class="small"><?= $data['id_kegiatan']; ?></span></td>
                                <td><span class="small"><?= $data['nama_kegiatan']; ?></span></td>
                                <td>
                                    <span class="small">
                                        <?= substr($data['deskripsi_kegiatan'], 0, 50); ?>...
                                    </span>
                                </td>
                                <td><span class="small"><?= $data['responden']; ?></span></td>
                                <td><span class="small"><?= $data['level_estimasi']; ?></span></td>
                                <td><span class="small"><?= $data['nama_kategori']; ?></span></td>
                                <td>
                                    <span class="small">
                                        <?php if($data['nama_pedoman']) { ?>
                                            <?= $data['nama_pedoman']; ?>
                                        <?php } else { echo "-"; } ?>
                                    </span>
                                </td>
                                
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm text-white me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#edit-kegiatan<?= $data['id_kegiatan']; ?>" 
                                            title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    
                                    <a href="pages/proses-kegiatan/del-data-kegiatan.php?id=<?= $data['id_kegiatan']; ?>" 
                                       class="btn btn-danger btn-sm btn-hapus" 
                                       title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>

                                    <div class="modal fade text-start" id="edit-kegiatan<?= $data['id_kegiatan']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg"> 
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Kegiatan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="pages/proses-kegiatan/edit-data-kegiatan.php" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_kegiatan" value="<?= $data['id_kegiatan']; ?>">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Nama Kegiatan</label>
                                                            <input type="text" name="nama_kegiatan" class="form-control" value="<?= $data['nama_kegiatan']; ?>" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Deskripsi</label>
                                                            <textarea name="deskripsi" class="form-control" rows="3" required><?= $data['deskripsi_kegiatan']; ?></textarea>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Kategori</label>
                                                                <select name="id_kategori" class="form-select" required>
                                                                    <option value="">-- Pilih Kategori --</option>
                                                                    <?php                                                                 
                                                                    
                                                                    $sqlK_edit = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY nama_kategori ASC");
                                                                    while($kat_edit = mysqli_fetch_assoc($sqlK_edit)){
                                                                        $selected = ($kat_edit['id_kategori'] == $data['id_kategori']) ? "selected" : "";
                                                                        echo "<option value='".$kat_edit['id_kategori']."' $selected>".$kat_edit['nama_kategori']."</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Pedoman Referensi</label>
                                                                <select name="id_pedoman" class="form-select">
                                                                    <option value="">-- Pilih Pedoman --</option>
                                                                    <?php
                                                                    $sqlP_edit = mysqli_query($koneksi, "SELECT * FROM tb_pedoman ORDER BY nama_pedoman ASC");
                                                                    while($ped_edit = mysqli_fetch_assoc($sqlP_edit)){
                                                                        $selected = ($ped_edit['id_pedoman'] == $data['id_pedoman']) ? "selected" : "";
                                                                        echo "<option value='".$ped_edit['id_pedoman']."' $selected>".$ped_edit['nama_pedoman']."</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>  
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Responden</label>
                                                                <select name="responden" class="form-select" required>
                                                                    <option value="" selected disabled>-- Pilih Responden --</option>
                                                                    <option value="Rumah Tangga">Rumah tangga</option>
                                                                    <option value="Usaha">Usaha</option>
                                                                    <option value="Instansi/OPD">Instansi/OPD</option>
                                                                    <option value="Non Usaha & Non Rumah Tangga">Non Usaha & Non Rumah Tangga</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Level Estimasi</label>
                                                                <select name="level_estimasi" class="form-select" required>
                                                                    <option value="" selected disabled>-- Pilih Level Estimasi --</option>
                                                                    <option value="Kabupaten/Kota">Kabupaten/Kota</option>
                                                                    <option value="Provinsi">Provinsi</option>
                                                                    <option value="Nasional">Nasional</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" name="edit_kegiatan" class="btn btn-primary btn-simpan">Simpan Data</button>
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

<div class="modal fade" id="tambahKegiatan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa-solid fa-folder-plus me-2"></i>Tambah Kegiatan Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="pages/proses-kegiatan/add-data-kegiatan.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" placeholder="Contoh: Survei Angkatan Kerja Nasional" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan secara singkat..." required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="id_kategori" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                <?php
                                $sqlK_add = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY nama_kategori ASC");
                                while($kat_add = mysqli_fetch_assoc($sqlK_add)){
                                    echo "<option value='".$kat_add['id_kategori']."'>".$kat_add['nama_kategori']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pedoman Referensi</label>
                            <select name="id_pedoman" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Pedoman --</option>
                                <?php
                                $sqlP_add = mysqli_query($koneksi, "SELECT * FROM tb_pedoman ORDER BY nama_pedoman ASC");
                                while($ped_add = mysqli_fetch_assoc($sqlP_add)){
                                    echo "<option value='".$ped_add['id_pedoman']."'>".$ped_add['nama_pedoman']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Responden</label>
                            <select name="responden" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Responden --</option>
                                <option value="Rumah Tangga">Rumah tangga</option>
                                <option value="Usaha">Usaha</option>
                                <option value="Instansi/OPD">Instansi/OPD</option>
                                <option value="Non Usaha & Non Rumah Tangga">Non Usaha & Non Rumah Tangga</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Level Estimasi</label>
                            <select name="level_estimasi" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Level Estimasi --</option>
                                <option value="Kabupaten/Kota">Kabupaten/Kota</option>
                                <option value="Provinsi">Provinsi</option>
                                <option value="Nasional">Nasional</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="add_kegiatan" class="btn btn-primary btn-simpan">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>