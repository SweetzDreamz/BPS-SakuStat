<footer>
    <div class="copyright">
        <p>copyright &copy; Created by <a href="https://github.com/SweetzDreamz?tab=repositories">me</a></p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTables pada tabel dengan id="example"
        $('#example').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json' // Opsional: Mengubah bahasa ke Indonesia
            }
        });

        // Toggle Sidebar (Logic agar tombol garis tiga berfungsi)
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });
</script>

</body>
</html>