<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input data
    $rawContent = $_POST['rawContent'];
    $d = intval($_POST['d']);
    $itermax = intval($_POST['itermax']);
    $lr = floatval($_POST['lr']);

    // Prepare the data for the API
    $data = [
        'rawContent' => $rawContent,
        'd' => $d,
        'itermax' => $itermax,
        'lr' => $lr
    ];

    // Send the data to the Flask API
    $url = 'http://localhost:5000/combined';
    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        die('Error occurred');
    }

    // Decode the response
    $responseData = json_decode($response, true);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>API Response</title>
</head>

<body>
    <h1>API Response</h1>
    <?php if (isset($responseData)): ?>
    <h2>Hasil Tes:</h2>
    <pre><?php echo json_encode($responseData['hasiltes'], JSON_PRETTY_PRINT); ?></pre>
    <h2>Hasil Kelas:</h2>
    <pre><?php echo json_encode($responseData['hasilkelas'], JSON_PRETTY_PRINT); ?></pre>
    <?php else: ?>
    <p>No data received.</p>
    <?php endif; ?>
    <a href="index.php">Back</a>
</body>

</html>