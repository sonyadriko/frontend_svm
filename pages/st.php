<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>SVM Testing</title>
    <?php include '../includes/script.php'; ?>
</head>

<body x-data="main" class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased"
    :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ?  'dark' : '', $store.app.menu, $store.app.layout,$store.app.rtlClass]">
    <!-- sidebar menu overlay -->
    <div x-cloak class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{'hidden' : !$store.app.sidebar}"
        @click="$store.app.toggleSidebar()"></div>

    <!-- scroll to top button -->
    <?php include '../includes/button_top.php'; ?>

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
                <div>
                    <h1>Sequential SVM Evaluation</h1>
                    <form id="evaluationForm">
                        <label for="test_data">Test Data:</label><br>
                        <textarea id="test_data" name="text" rows="4" cols="50"></textarea><br>
                        <button type="button" onclick="submitData()">Evaluate Model</button>
                    </form>
                    <!-- Tempat untuk menampilkan hasil prediksi -->
                    <div id="predictionResult"></div>
                </div>
            </div>
            <!-- end main content section -->

            <script>
            function submitData() {
                const testData = document.getElementById('test_data').value.trim();

                if (testData === "") {
                    document.getElementById('predictionResult').innerHTML = "Error: Test data is empty.";
                    return;
                }

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'st.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById('predictionResult').innerHTML = xhr.responseText;
                    } else if (xhr.readyState == 4) {
                        document.getElementById('predictionResult').innerHTML = 'Error: ' + xhr.status;
                    }
                };

                const data = JSON.stringify({
                    "text": testData
                });
                xhr.send(data);
            }
            </script>

            <?php
            // URL dari API yang ingin dikonsumsi
            $url = 'http://127.0.0.1:5000/sequential_svm/train';

            // Membuat cURL session
            $ch = curl_init($url);

            // Mengatur opsi untuk POST request
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ''); // Tidak perlu mengirim data karena data diambil dari file CSV di server

            // Eksekusi cURL session
            $response = curl_exec($ch);

            // Cek jika terjadi error
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            } else {
                // Tampilkan respons dari server
                echo $response;
            }

            // Tutup cURL session
            curl_close($ch);
            ?>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $inputData = file_get_contents('php://input');
                $data = json_decode($inputData, true);

                if (isset($data['text']) && !empty($data['text'])) {
                    $url = 'http://127.0.0.1:5000/predict';
                    $data_json = json_encode(['text' => $data['text']]);

                    $ch = curl_init($url);

                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data_json))
                    );

                    $result = curl_exec($ch);

                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                        exit;
                    }

                    curl_close($ch);

                    $response = json_decode($result, true);

                    if ($response && isset($response['sentimen']) && isset($response['kernel_matrix'])) {
                        echo "Prediksi Sentimen: " . htmlspecialchars($response['sentimen']) . "<br>";
                        echo "Matriks Kernel: " . $response['kernel_matrix'] . "<br>";
                        // print_r($response['kernel_matrix'], true);

                        $alpha_values = isset($response['alpha_values']) ? $response['alpha_values'] : null;
                        $support_vectors = isset($response['support_vectors']) ? $response['support_vectors'] : null;

                        // echo "Nilai Alpha (ai): " . htmlspecialchars(json_encode($alpha_values)) . "<br>";
                        // echo "Support Vectors (yi): " . htmlspecialchars(json_encode($support_vectors));
                    } else {
                        echo "Invalid response from the prediction API.";
                    }
                } else {
                    echo "Error: Test data is empty.";
                }
            } else {
                echo "Error: Invalid request method.";
            }
            ?>

            <!-- start footer section -->
            <?php include '../includes/footer.php'; ?>
            <!-- end footer section -->
        </div>
    </div>

    <?php include '../includes/js.php'; ?>
</body>

</html>