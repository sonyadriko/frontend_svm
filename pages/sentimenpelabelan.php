<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Sentimen Pelabelan</title>
    <?php include '../includes/script.php' ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
</head>

<body x-data="main" class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased"
    :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ?  'dark' : '', $store.app.menu, $store.app.layout,$store.app.rtlClass]">
    <!-- sidebar menu overlay -->
    <div x-cloak class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{'hidden' : !$store.app.sidebar}"
        @click="$store.app.toggleSidebar()"></div>

    <!-- screen loader -->
    <?php include '../includes/screen_loader.php' ?>

    <!-- scroll to top button -->
    <?php include '../includes/button_top.php' ?>

    <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
        <!-- start sidebar section -->
        <?php include '../includes/sidebar.php' ?>

        <!-- end sidebar section -->

        <div class="main-content flex min-h-screen flex-col">
            <!-- start header section -->
            <?php include '../includes/header.php' ?>
            <!-- end header section -->

            <!-- start main content section -->
            <div class="animate__animated p-6" :class="[$store.app.animation]">
                <div style="overflow-x:auto;">
                    <button id="preprocessingButton" class="btn btn-primary">Mulai Pelabelan</button><br>
                    <?php
                    
                    // Nama file CSV
                    $csvFile = '../../backend/pelabelan.csv';
                    
                    // Periksa apakah file CSV ada
                    if (file_exists($csvFile)) {
                        // Buka file CSV
                        $file = fopen($csvFile, 'r');
                    
                        // Mulai tabel HTML
                        echo '<div class="table-responsive">';
                        echo '<table id="dataTable" class="table table-bordered">';
                    
                        if(($header = fgetcsv($file)) !== false){
                            echo '<thead><tr>';
                            foreach ($header as $cell){
                                echo '<th>' . htmlspecialchars($cell) . '</th>';
                            }
                            echo '</tr></thead>';
                        }

                        echo '<tbody>';
                        // Baca baris demi baris
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
                    <?php
// Mengambil respons JSON dari Flask menggunakan file_get_contents
// $url = "http://localhost:5000/sentimen-pelabelan"; // Sesuaikan URL dengan alamat Flask Anda
// $data_json = file_get_contents($url);

// // Mengubah JSON menjadi array asosiatif PHP
// $data_array = json_decode($data_json, true);

// Menampilkan data
// echo "<pre>";
// print_r($data_array);
// echo "</pre>";

// Jika Anda ingin mengakses data spesifik
// Misalnya, untuk mengakses kolom 'sentimen' dari setiap baris data
// foreach ($data_array as $row) {
//     echo "Sentimen: " . $row['sentimen'] . "<br>";
// }
?>

                </div>
            </div>
            <!-- end main content section -->

            <!-- start footer section -->
            <?php include '../includes/footer.php' ?>
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
        xhr.open("GET", "http://127.0.0.1:5000/sentimen-pelabelan", true);

        xhr.onload = function() {
            if (xhr.status == 200) {
                // Tampilkan pesan berhasil jika proses berhasil
                alert("Proses pelabelan berhasil!");
            } else {
                // Tampilkan pesan error jika terjadi kesalahan
                alert("Terjadi kesalahan saat melakukan pelabelan: " + xhr.statusText);
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
