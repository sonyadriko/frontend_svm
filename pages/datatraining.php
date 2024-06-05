<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Data Training</title>
    <?php include '../includes/script.php'; ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
</head>

<body x-data="main" class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased" :class="[$store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ? 'dark' : '',
        $store.app.menu, $store.app.layout, $store.app.rtlClass
    ]">
    <!-- sidebar menu overlay -->
    <div x-cloak class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{ 'hidden': !$store.app.sidebar }"
        @click="$store.app.toggleSidebar()"></div>

    <?php include '../includes/screen_loader.php'; ?>
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
                    <!-- <h1>Data Training</h1> -->

                    <div class="flex mt-6">
                        <form action="datatraining.php" method="post" enctype="multipart/form-data"
                            class="shadow-md rounded px-8 pt-6 pb-8 mb-4">
                            <label for="excelFile" class="text-gray-700 text-sm font-bold mb-2">Unggah File
                                Excel:</label>
                            <input type="file" name="excelFile" id="excelFile" accept=".csv"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-4">
                            <button type="submit" class="btn btn-primary mt-6">Unggah</button>
                        </form>
                    </div>
                    <?php
                    if (isset($_FILES['excelFile'])) {
                        $errors = [];
                        $file_name = 'data_tweet.csv';
                        $file_tmp = $_FILES['excelFile']['tmp_name'];
                        $upload_path = '../../backend/' . $file_name;
                        $file_extension = pathinfo($_FILES['excelFile']['name'], PATHINFO_EXTENSION);
                    
                        if ($_FILES['excelFile']['error'] !== UPLOAD_ERR_OK) {
                            $errors[] = 'An error occurred during file upload.';
                        } elseif ($file_extension != 'csv') {
                            $errors[] = 'Only CSV files are allowed.';
                            error_log('Invalid file format. Only CSV files are allowed.');
                        } else {
                            if (move_uploaded_file($file_tmp, $upload_path)) {
                                echo "<div class='alert alert-success'>File uploaded successfully.</div>";
                                error_log('File uploaded: ' . $file_name);
                            } else {
                                $errors[] = 'Failed to upload file.';
                                error_log('Failed to upload file: ' . $file_name);
                            }
                        }
                    
                        if (!empty($errors)) {
                            foreach ($errors as $error) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        }
                    }
                    ?>
                    <div id="data-container" class="table-responsive"></div>

                    <button onclick="deleteExcelFile()" class="btn btn-secondary">Delete Excel File</button>
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
        // Function to delete Excel file
        function deleteExcelFile() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_excel.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            xhr.onload = function() {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("Excel file deleted successfully.");
                    } else {
                        alert("Failed to delete Excel file.");
                    }
                } else {
                    console.error("Error deleting Excel file: " + xhr.statusText);
                }
            };

            xhr.onerror = function() {
                console.error("Network error occurred");
                alert("Failed to delete Excel file. Please check your internet connection.");
            };

            xhr.send(JSON.stringify({
                fileName: "data_tweet.csv"
            }));
        }
        // Function to make HTTP request
        function fetchData() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "http://127.0.0.1:5000/data-training", true);

            xhr.onload = function() {
                if (xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    displayData(data);
                } else {
                    console.error("Error fetching data: " + xhr.statusText);
                }
            };

            xhr.onerror = function() {
                console.error("Network error occurred");
                alert("Jika API mati atau file tidak ada, silakan cek koneksi internet Anda.");
            };

            xhr.send();
        }

        // Function to display fetched data as a table
        function displayData(data) {
            var container = document.getElementById("data-container");
            var html =
                "<h1>Data Training</h1><table id='dataTable' class='table table-bordered'><thead><tr><th>No.</th><th>Data</th></tr></thead><tbody>";

            data.forEach(function(item, index) {
                html += "<tr><td>" + (index + 1) + "</td><td>" + item + "</td></tr>";
            });

            html += "</tbody></table>";
            container.innerHTML = html;

            // Initialize DataTable
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
        }

        // Call fetchData function when page loads
        window.onload = function() {
            fetchData();
        };
        </script>
</body>

</html>

</html>