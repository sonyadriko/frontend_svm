<!DOCTYPE html>
<html>

<head>
    <title>API Text Preprocessing and SVM</title>
</head>

<body>
    <h1>Text Preprocessing and SVM</h1>
    <form action="process.php" method="POST">
        <label for="rawContent">Input Kalimat:</label><br>
        <textarea id="rawContent" name="rawContent" rows="4" cols="50"></textarea><br><br>
        <label for="d">Parameter d:</label>
        <input type="number" id="d" name="d" value="3"><br><br>
        <label for="itermax">Max Iterations:</label>
        <input type="number" id="itermax" name="itermax" value="1000"><br><br>
        <label for="lr">Learning Rate:</label>
        <input type="number" step="0.01" id="lr" name="lr" value="0.01"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>

</html>