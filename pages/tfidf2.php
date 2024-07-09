<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Data Input</title>
    <script>
    async function submitData() {
        const dataTesting = document.getElementById("dataTesting").value;
        const degree = document.getElementById("degree").value;
        const itermax = document.getElementById("itermax").value;
        const lr = document.getElementById("lr").value;

        const data = {
            data_testing: dataTesting.split(" "),
            d: parseFloat(degree),
            itermax: parseInt(itermax),
            lr: parseFloat(lr)
        };

        const response = await fetch('http://localhost:5000/testdatanew', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        document.getElementById("result").innerText = JSON.stringify(result, null, 2);
    }
    </script>
</head>

<body>
    <h1>Test Data Input</h1>
    <form onsubmit="event.preventDefault(); submitData();">
        <label for="dataTesting">Data Testing (separated by spaces):</label>
        <input type="text" id="dataTesting" name="dataTesting" required><br><br>
        <label for="degree">Degree (d):</label>
        <input type="number" step="0.01" id="degree" name="degree" required><br><br>
        <label for="itermax">Iterasi Maksimum (itermax):</label>
        <input type="number" id="itermax" name="itermax" required><br><br>
        <label for="lr">Learning Rate (lr):</label>
        <input type="number" step="0.01" id="lr" name="lr" required><br><br>
        <input type="submit" value="Submit">
    </form>
    <h2>Result</h2>
    <pre id="result"></pre>
</body>

</html>