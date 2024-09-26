<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Pengujian</title>
    <?php include '../includes/script.php' ?>
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
                <div>
                    <form action="svm.php" method="get" class="mt-6">
                        <label for="gamma" class="block">Gamma:</label>
                        <input type="text" id="gamma" name="gamma" required
                            class="block w-full border border-gray-300 rounded-md py-2 px-3"><br><br>

                        <label for="lambda" class="block">Lambda (C):</label>
                        <input type="text" id="lambda" name="lambda" required
                            class="block w-full border border-gray-300 rounded-md py-2 px-3"><br><br>

                        <label for="complexity" class="block">Complexity (coef0):</label>
                        <input type="text" id="complexity" name="complexity" required
                            class="block w-full border border-gray-300 rounded-md py-2 px-3"><br><br>

                        <label for="complexity" class="block">Data Testing:</label>
                        <select id="test_size" name="test_size" class="form-select mb-4">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <option value="<?php echo $i / 10; ?>">
                                <?php 
            $data_testing_percentage = ($i / 10) * 100;
            $data_training_percentage = (1 - $i / 10) * 100;
            echo "Data Testing " . $data_testing_percentage . "% - Data Training " . $data_training_percentage . "%"; 
            ?>
                            </option>
                            <?php endfor; ?>
                        </select>

                        <button type="submit" class="btn btn-primary py-2 px-4 rounded">Submit</button>
                        <br>
                    </form>
                    <?php
if (isset($_GET['gamma']) && isset($_GET['lambda']) && isset($_GET['complexity'])) {
    $gamma = htmlspecialchars($_GET['gamma']);
    $lambda = htmlspecialchars($_GET['lambda']);
    $complexity = htmlspecialchars($_GET['complexity']);
    $test_size = $_GET['test_size'];
    
    $url = "http://127.0.0.1:5000/svm?gamma=" . urlencode($gamma) . "&lambda=" . urlencode($lambda) . "&complexity=" . urlencode($complexity) . "&test_size=" . $test_size;

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);

    if ($data) {

        echo "Total data testing yang digunakan: " . $data['total_data'] . "<br>";

        echo "Accuracy: " . rtrim(rtrim(number_format($data['accuracy'] * 100, 2), '0'), '.') . "%<br>";
        echo "Confusion Matrix: <br>";
        // foreach ($data['confusion_matrix'] as $row) {
        //     echo implode(' ', $row) . "<br>";
        // }
        echo "TN: " . $data['tn'] . "<br>";
        echo "FP: " . $data['fp'] . "<br>";
        echo "FN: " . $data['fn'] . "<br>";
        echo "TP: " . $data['tp'] . "<br>";
        // echo "Classification Report: <pre>" . $data['classification_report'] . "</pre><br>";
        echo "Precision: " . rtrim(rtrim(number_format($data['precision'] * 100, 2), '0'), '.') . "%<br>";
        echo "F1 Score: " . rtrim(rtrim(number_format($data['f1_score'] * 100, 2), '0'), '.') . "%<br>";
        echo "Recall: " . rtrim(rtrim(number_format($data['recall'] * 100, 2), '0'), '.') . "%<br>";
    } else {
        echo "Error: Unable to get data from SVM endpoint.";
    }
} else {
    echo "Silakan kirimkan formulir dengan parameter yang diperlukan.";
}
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

    <script>
    // Fungsi untuk memulai proses preprocessing saat tombol ditekan
    document.getElementById("preprocessingButton").addEventListener("click", function() {
        // Buat permintaan POST ke endpoint /preprocessing pada server Flask
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "http://127.0.0.1:5000/svm", true);

        xhr.onload = function() {
            if (xhr.status == 200) {
                // Tampilkan pesan berhasil jika proses berhasil
                alert("Proses svm berhasil!");
            } else {
                // Tampilkan pesan error jika terjadi kesalahan
                alert("Terjadi kesalahan saat melakukan svm: " + xhr.statusText);
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