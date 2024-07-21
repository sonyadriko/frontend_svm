<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $testData = trim($_POST['test_data']);
    $inputText = htmlspecialchars($testData);

    if (!empty($testData)) {
        $url = 'http://127.0.0.1:5000/predict';
        $data = json_encode(['text' => $testData]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($data)]);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            exit();
        }

        curl_close($ch);

        $response = json_decode($result, true);

        if ($response && isset($response['sentimen']) && isset($response['kernel_matrix'])) {
            $sentiment = is_array($response['sentimen']) ? implode(', ', $response['sentimen']) : $response['sentimen'];
            $kernel_matrix = htmlspecialchars(json_encode($response['kernel_matrix'], JSON_PRETTY_PRINT));

            $predictionResult = 'Prediksi Sentimen: ' . '<strong>' . $sentiment . '</strong>' . '<br>';
            $predictionResult .= 'Matriks Kernel: ' . $kernel_matrix . '<br>';
        } else {
            $predictionResult = 'Invalid response from the prediction API.';
        }
    } else {
        $predictionResult = 'Error: Test data is empty.';
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>SVM Testing</title>
    <style>
    .responsive-text {
        width: 100%;
        max-width: 100%;
        white-space: pre-wrap;
        word-wrap: break-word;
        box-sizing: border-box;
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
    }
    </style>
    <?php include '../includes/script.php'; ?>
</head>

<body x-data="main" class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased" :class="[$store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ? 'dark' : '',
        $store.app.menu, $store.app.layout, $store.app.rtlClass
    ]">
    <!-- sidebar menu overlay -->
    <div x-cloak class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{ 'hidden': !$store.app.sidebar }"
        @click="$store.app.toggleSidebar()"></div>
    <?php include '../includes/button_top.php'; ?>
    <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
        <?php include '../includes/sidebar.php'; ?>
        <div class="main-content flex min-h-screen flex-col">
            <?php include '../includes/header.php'; ?>
            <div class="animate__animated p-6" :class="[$store.app.animation]">
                <div>
                    <h1>Evaluasi Sequential SVM</h1>
                    <form id="evaluationForm" method="POST" action="">
                        <label for="test_data">Input Data:</label><br>
                        <textarea id="test_data" name="test_data" rows="4" cols="50"></textarea><br>
                        <button type="submit" class="btn btn-primary mt-2 mb-4">Prediksi Data</button>
                    </form>
                    <div id="predictionResult">
                        <?php
                        if (isset($inputText)) {
                            echo "<div class='responsive-text'>Input Text:<br>" . nl2br($inputText) . "</div>";
                        }
                        if (isset($predictionResult)) {
                            echo $predictionResult;
                        }
                        ?>
                    </div>
                </div>
            </div>

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
                // echo $response;
            }
            
            // Tutup cURL session
            curl_close($ch);
            ?>

            <!-- start footer section -->
            <?php include '../includes/footer.php'; ?>
            <!-- end footer section -->
        </div>
    </div>

    <?php include '../includes/js.php'; ?>
</body>

</html>