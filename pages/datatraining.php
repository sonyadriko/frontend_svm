<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Data Training</title>
    <?php include '../includes/script.php'; ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <style>
    .btn-danger {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        color: #fff;
        background-color: #c82333;
        border-color: #bd2130;
    }
    </style>
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
                                echo "<script>Swal.fire({
                                        icon: 'success',
                                        title: 'File uploaded successfully!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })</script>";
                                error_log('File uploaded: ' . $file_name);
                            } else {
                                $errors[] = 'Failed to upload file.';
                                error_log('Failed to upload file: ' . $file_name);
                            }
                        }

                        if (!empty($errors)) {
                            foreach ($errors as $error) {
                                echo "<script>Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: '$error',
                                    })</script>";
                            }
                        }
                    }
                    ?>
                    <div id="summary" class="mt-4 mb-4"></div>

                    <div id="data-container" class="table-responsive"></div>

                    <button onclick="deleteExcelFile()" class="btn btn-danger mt-4">Delete Excel File</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    // Function to delete Excel file
    function deleteExcelFile() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this file!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_excel.php", true);
                xhr.setRequestHeader("Content-Type", "application/json");

                xhr.onload = function() {
                    if (xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Excel file has been deleted.',
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Failed!',
                                text: 'Failed to delete Excel file.',
                                icon: 'error'
                            });
                        }
                    } else {
                        console.error("Error deleting Excel file: " + xhr.statusText);
                    }
                };

                xhr.onerror = function() {
                    console.error("Network error occurred");
                    Swal.fire({
                        title: 'Failed!',
                        text: 'Failed to delete Excel file. Please check your internet connection.',
                        icon: 'error'
                    });
                };


                xhr.send(JSON.stringify({
                    fileName: "data_tweet.csv"
                }));
            }
        });
    }

    // Function to make HTTP request
    function fetchData() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "http://127.0.0.1:5000/data-training", true);

        xhr.onload = function() {
            if (xhr.status == 200) {
                var result = JSON.parse(xhr.responseText);
                displayData(result.data);
                displaySummary(result.positif_count, result.negatif_count);
            } else {
                console.error("Error fetching data: " + xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error("Network error occurred");
            Swal.fire({
                title: 'Failed!',
                text: 'Failed to fetch data. Please check your internet connection.',
                icon: 'error'
            });
        };

        xhr.send();
    }

    // Function to display fetched data as a table
    function displayData(data) {
        var container = document.getElementById("data-container");
        var html =
            "<h1>Data Training</h1><table id='dataTable' class='table table-bordered'><thead><tr><th>No.</th><th>Data</th><th>Status</th></tr></thead><tbody>";

        data.forEach(function(item, index) {
            html += "<tr><td>" + (index + 1) + "</td><td>" + item.rawContent + "</td><td>" + item.status +
                "</td></tr>";
        });

        html += "</tbody></table>";
        container.innerHTML = html;

        // Initialize DataTable
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    }

    // Function to display summary
    function displaySummary(positifCount, negatifCount) {
        var summaryContainer = document.getElementById("summary");
        var html = "<p>Positif: " + positifCount + " data</p><p>Negatif: " + negatifCount + " data</p>";
        summaryContainer.innerHTML = html;
    }

    // Call fetchData function when page loads
    window.onload = function() {
        fetchData();
    };
    </script>
</body>

</html>