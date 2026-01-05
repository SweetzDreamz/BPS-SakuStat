<footer class="mt-auto py-3 bg-light text-center border-top">
            <div class="container-fluid">
                <small class="text-muted">
                    BPS Kota Bogor | Created by <a href="https://github.com/SweetzDreamz?tab=repositories" class="text-decoration-none fw-bold">Me</a>
                </small>
            </div>
        </footer>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {

        // Setup DataTables
        $('#example').DataTable({"bInfo" : false});

        // Sidebar Toggle
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });


        // 1. SCRIPT HAPUS (DELETE)
        $(document).on('click', '.btn-hapus', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan Pesan SUKSES sebelum redirect
                    Swal.fire({
                        title: 'Dihapus!',
                        text: 'Data sedang dihapus...',
                        icon: 'success',
                        timer: 1500, // Waktu tunggu 1.5 detik
                        showConfirmButton: false
                    }).then(() => {
                        // Redirect ke link hapus setelah timer selesai
                        document.location.href = href;
                    });
                }
            });
        });


        // 2. SCRIPT SIMPAN / EDIT (VERSI PERBAIKAN 'closest')
        $(document).on('click', '.btn-simpan', function(e) {
            e.preventDefault();
            
            var tombol = $(this);
            var form = tombol.closest('form'); // Menggunakan closest agar lebih akurat
            
            var btnName = tombol.attr('name'); 
            var btnVal  = tombol.val();

            // Cek Validasi HTML (Required fields)
            if (!form[0].checkValidity()) {
                form[0].reportValidity(); // Munculkan pesan error browser jika kosong
                return;
            }

            // Tampilkan Konfirmasi Dulu
            Swal.fire({
                title: 'Konfirmasi Simpan',
                text: "Pastikan data yang Anda input sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan Pesan SUKSES sebelum submit
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data sedang disimpan...',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Trik agar PHP tetap bisa membaca tombol submit yg ditekan
                        if(btnName) {
                            $('<input>').attr({
                                type: 'hidden',
                                name: btnName,
                                value: btnVal
                            }).appendTo(form);
                        }

                        form.submit(); // Kirim form
                    });
                }
            });
        });

        // 3. SCRIPT LOGOUT
        $('.btn-logout').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: "Sesi Anda akan diakhiri.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            });
        });

    });
</script>

</body>
</html>