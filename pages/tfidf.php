<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>TF IDF</title>
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
            <div class="animate__animated p-6" :class="[$store.app.animation]">
                <div style="overflow-x: auto;">
                    <button id="tfidfButton" class="btn btn-primary">Mulai Perhitungan TF IDF</button><br>
                    <!-- <div id="tfidfData"></div> -->
                    <?php
                    
                    // Nama file CSV
                    // $csvFile = '../../backend/tfidf_vectors.csv';
                    $csvFile = '../../backend/pelabelan.csv';
                    
                    // Periksa apakah file CSV ada
                    if (file_exists($csvFile)) {
                        // Buka file CSV
                        $file = fopen($csvFile, 'r');
                    
                        // Mulai tabel HTML
                        echo '<div class="table-responsive">';
                        echo '<table id="dataTable" class="table table-bordered">'; // Added id="dataTable"

                        // Handle the header row
                        if (($header = fgetcsv($file)) !== false) {
                            echo '<thead><tr>';
                            foreach ($header as $cell) {
                                echo '<th>' . htmlspecialchars($cell) . '</th>';
                            }
                            echo '</tr></thead>';
                        }
                    
                        // Handle the data rows
                        echo '<tbody>';
                        while (($data = fgetcsv($file)) !== false) {
                            echo '<tr>';
                            foreach ($data as $cell) {
                                echo '<td>' . htmlspecialchars($cell) . '</td>';
                            }
                            echo '</tr>';
                        }
                        echo '</tbody>';
                    
                        // Tutup file CSV
                        fclose($file);
                    
                        // Selesai dengan tabel HTML
                        echo '</table>';
                        echo '</div>';
                    } else {
                        // Tampilkan pesan jika file tidak ada
                        echo 'Data tidak ditemukan.';
                    }
                    ?>
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

    // Fungsi untuk memulai proses TF IDF saat tombol ditekan
    document.getElementById("tfidfButton").addEventListener("click", function() {
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

        // Buat permintaan GET ke endpoint /tf-idf-3 pada server Flask
        var xhr = new XMLHttpRequest();
        // xhr.open("GET", "http://127.0.0.1:5000/tf-idf-2", true);
        xhr.open("GET", "http://127.0.0.1:5000/tfidf-and-sentiment-labeling", true);

        xhr.onload = function() {
            Swal.close(); // Tutup loading
            if (xhr.status == 200) {
                // Tampilkan pesan berhasil jika proses berhasil
                Swal.fire({
                    title: 'Success',
                    text: 'Proses TF IDF berhasil!',
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
                    text: 'Terjadi kesalahan saat melakukan TF IDF: ' + xhr.statusText,
                    icon: 'error'
                });
            }
        };

        xhr.onerror = function() {
            Swal.close(); // Tutup loading
            // Tampilkan pesan error jika terjadi kesalahan jaringan
            Swal.fire({
                title: 'Network Error',
                text: 'Terjadi kesalahan jaringan saat melakukan TF IDF.',
                icon: 'error'
            });
        };

        xhr.send();
    });
    </script>
</body>

</html>
