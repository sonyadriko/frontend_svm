<?php
// Data uji yang dikirimkan dari formulir
$data_uji = array(
    "X_test" => $_POST['test_data']
);

// URL Flask endpoint
$url = 'http://127.0.0.1:5000/sequential_svm/predict';

// Menginisialisasi curl
$ch = curl_init($url);

// Mengatur opsi curl
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_uji));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Melakukan eksekusi curl untuk mengirim permintaan
$response = curl_exec($ch);

// Menutup curl
curl_close($ch);

// Menampilkan respons dari Flask
echo $response;
?>