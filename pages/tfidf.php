<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>TF IDF</title>
    <?php include '../includes/script.php' ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
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
                    <button id="preprocessingButton" class="btn btn-primary">Mulai Perhitungan TF IDF</button><br>
                    <!-- <div id="tfidfData"></div> -->
                    <?php
                    
                    // Nama file CSV
                    $csvFile = '../../backend/hasil_vector_matrix.csv';
                    
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
    <script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
    </script>

    <script>
    // Fungsi untuk memulai proses preprocessing saat tombol ditekan
    document.getElementById("preprocessingButton").addEventListener("click", function() {
        // Buat permintaan POST ke endpoint /preprocessing pada server Flask
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "http://127.0.0.1:5000/tf-idf-2", true);

        xhr.onload = function() {
            if (xhr.status == 200) {
                // Tampilkan pesan berhasil jika proses berhasil
                alert("Proses TF IDF berhasil!");
            } else {
                // Tampilkan pesan error jika terjadi kesalahan
                alert("Terjadi kesalahan saat melakukan tf idf: " + xhr.statusText);
            }
        };

        xhr.onerror = function() {
            // Tampilkan pesan error jika terjadi kesalahan jaringan
            alert("Terjadi kesalahan jaringan saat melakukan preprocessing.");
        };

        xhr.send();
    });
    </script>
</body>

</html>