<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Preprocessing</title>
    <?php include '../includes/script.php' ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body x-data="main" class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased" :class="[$store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ? 'dark' : '',
        $store.app.menu, $store.app.layout, $store.app.rtlClass
    ]">
    <!-- sidebar menu overlay -->
    <div x-cloak class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{ 'hidden': !$store.app.sidebar }"
        @click="$store.app.toggleSidebar()"></div>

    <!-- screen loader -->
    <?php include '../includes/screen_loader.php' ?>

    <!-- scroll to top button -->
    <?php include '../includes/button_top.php' ?>

    <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
        <!-- start sidebar section -->
        <?php include '../includes/sidebar.php'; ?>

        <!-- end sidebar section -->

        <div class="main-content flex min-h-screen flex-col">
            <!-- start header section -->
            <?php include '../includes/header.php'; ?>
            <!-- end header section -->

            <!-- start main content section -->
            <div class="animate__animated p-6 ltr:ml-6 rtl:mr-6" :class="[$store.app.animation]">
                <div style="overflow-x:auto;">
                    <button id="preprocessingButton" class="btn btn-primary">Klik untuk Memulai Proses
                        Preprocessing</button>
                    <br>
                    <div class="table-responsive">
                        <table id="dataTable" class="table" border="1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Case Folding</th>
                                    <th>Cleaning</th>
                                    <th>Tokenizing</th>
                                    <th>Stopword</th>
                                    <th>Normalisasi</th>
                                    <th>Stemming</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$file_path = '../../backend/Text_Preprocessing.csv';

// Cek apakah file CSV ada
if (!file_exists($file_path)) {
    echo 'File CSV tidak ditemukan.';
} else {
    // Mengambil data hasil preprocessing dari file CSV
    $preprocessing_data = array_map('str_getcsv', file($file_path));

    // Jika file kosong atau gagal dibaca
    if ($preprocessing_data === FALSE || count($preprocessing_data) === 0) {
        echo 'Data tidak ditemukan atau file CSV kosong.';
    } else {
        // Mengabaikan baris header
        array_shift($preprocessing_data);

        // Menampilkan data dalam tabel
        foreach ($preprocessing_data as $row) {
            echo '<tr>';
            echo '<td>' . (isset($row[0]) ? $row[0] : '') . '</td>';
            echo '<td>' . (isset($row[2]) ? $row[2] : '') . '</td>';
            echo '<td>' . (isset($row[3]) ? $row[3] : '') . '</td>';
            echo '<td>' . (isset($row[4]) ? $row[4] : '') . '</td>';
            echo '<td>' . (isset($row[6]) ? $row[6] : '') . '</td>';
            echo '<td>' . (isset($row[7]) ? $row[7] : '') . '</td>';
            echo '<td>' . (isset($row[8]) ? $row[8] : '') . '</td>';
            echo '</tr>';
        }
    }
}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end main content section -->

            <!-- start footer section -->
            <?php include '../includes/footer.php'; ?>
            <!-- end footer section -->
        </div>
    </div>

    <?php include '../includes/js.php'  ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

    // Fungsi untuk memulai proses preprocessing saat tombol ditekan
    document.getElementById("preprocessingButton").addEventListener("click", function() {
        // Tampilkan loading
        Swal.fire({
            title: 'Processing',
            text: 'Please wait...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Buat permintaan POST ke endpoint /preprocessing pada server Flask
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "http://127.0.0.1:5000/preprocessing", true);

        xhr.onload = function() {
            Swal.close(); // Tutup loading
            if (xhr.status == 200) {
                // Tampilkan pesan berhasil jika proses berhasil
                Swal.fire({
                    title: 'Success',
                    text: 'Proses preprocessing berhasil!',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // Reload halaman saat tombol OK ditekan
                    }
                });
            } else {
                // Tampilkan pesan error jika terjadi kesalahan
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan saat melakukan preprocessing: ' + xhr.statusText,
                    icon: 'error'
                });
            }
        };

        xhr.onerror = function() {
            Swal.close(); // Tutup loading
            // Tampilkan pesan error jika terjadi kesalahan jaringan
            Swal.fire({
                title: 'Network Error',
                text: 'Terjadi kesalahan jaringan saat melakukan preprocessing.',
                icon: 'error'
            });
        };

        xhr.send();
    });
    </script>

</body>

</html>