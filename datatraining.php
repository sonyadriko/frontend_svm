<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/perfect-scrollbar.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/style.css" />
    <link defer rel="stylesheet" type="text/css" media="screen" href="assets/css/animate.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="assets/js/perfect-scrollbar.min.js"></script>
    <script defer src="assets/js/popper.min.js"></script>
</head>

<body x-data="main" class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased"
    :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ?  'dark' : '', $store.app.menu, $store.app.layout,$store.app.rtlClass]">
    <!-- sidebar menu overlay -->
    <div x-cloak class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{'hidden' : !$store.app.sidebar}"
        @click="$store.app.toggleSidebar()"></div>

    <!-- scroll to top button -->
    <div class="fixed bottom-6 z-50 ltr:right-6 rtl:left-6" x-data="scrollToTop">
        <template x-if="showTopButton">
            <button type="button"
                class="btn btn-outline-primary animate-pulse rounded-full bg-[#fafafa] p-2 dark:bg-[#060818] dark:hover:bg-primary"
                @click="goToTop">
                <svg width="24" height="24" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 20.75C12.4142 20.75 12.75 20.4142 12.75 20L12.75 10.75L11.25 10.75L11.25 20C11.25 20.4142 11.5858 20.75 12 20.75Z"
                        fill="currentColor" />
                    <path
                        d="M6.00002 10.75C5.69667 10.75 5.4232 10.5673 5.30711 10.287C5.19103 10.0068 5.25519 9.68417 5.46969 9.46967L11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5304 3.46967L18.5304 9.46967C18.7449 9.68417 18.809 10.0068 18.6929 10.287C18.5768 10.5673 18.3034 10.75 18 10.75L6.00002 10.75Z"
                        fill="currentColor" />
                </svg>
            </button>
        </template>
    </div>

    <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
        <!-- start sidebar section -->
        <?php include 'sidebar.php' ?>

        <!-- end sidebar section -->

        <div class="main-content flex min-h-screen flex-col">
            <!-- start header section -->
            <?php include 'header.php' ?>
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
if(isset($_FILES['excelFile'])) {
    $errors = [];
    $file_name = "data_tweet.csv";
    $file_tmp = $_FILES['excelFile']['tmp_name'];
    $upload_path = '../backend/' . $file_name;
    $file_extension = pathinfo($_FILES['excelFile']['name'], PATHINFO_EXTENSION);

    if ($_FILES['excelFile']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "An error occurred during file upload.";
    } elseif($file_extension != 'csv') {
        $errors[] = "Only CSV files are allowed.";
        error_log("Invalid file format. Only CSV files are allowed.");
    } else {
        if(move_uploaded_file($file_tmp, $upload_path)) {
            echo "<div class='alert alert-success'>File uploaded successfully.</div>";
            error_log("File uploaded: " . $file_name);
        } else {
            $errors[] = "Failed to upload file.";
            error_log("Failed to upload file: " . $file_name);
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
                <?php include 'footer.php' ?>
                <!-- end footer section -->
            </div>
        </div>




        <script src="assets/js/alpine-collaspe.min.js"></script>
        <script src="assets/js/alpine-persist.min.js"></script>
        <script defer src="assets/js/alpine-ui.min.js"></script>
        <script defer src="assets/js/alpine-focus.min.js"></script>
        <script defer src="assets/js/alpine.min.js"></script>
        <script src="assets/js/custom.js"></script>

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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

        <script>
        document.addEventListener('alpine:init', () => {
            // main section
            Alpine.data('scrollToTop', () => ({
                showTopButton: false,
                init() {
                    window.onscroll = () => {
                        this.scrollFunction();
                    };
                },

                scrollFunction() {
                    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                        this.showTopButton = true;
                    } else {
                        this.showTopButton = false;
                    }
                },

                goToTop() {
                    document.body.scrollTop = 0;
                    document.documentElement.scrollTop = 0;
                },
            }));

            // theme customization
            Alpine.data('customizer', () => ({
                showCustomizer: false,
            }));

            // sidebar section
            Alpine.data('sidebar', () => ({
                init() {
                    const selector = document.querySelector('.sidebar ul a[href="' + window.location
                        .pathname + '"]');
                    if (selector) {
                        selector.classList.add('active');
                        const ul = selector.closest('ul.sub-menu');
                        if (ul) {
                            let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                            if (ele) {
                                ele = ele[0];
                                setTimeout(() => {
                                    ele.click();
                                });
                            }
                        }
                    }
                },
            }));

            // header section
            Alpine.data('header', () => ({
                init() {
                    const selector = document.querySelector('ul.horizontal-menu a[href="' + window
                        .location.pathname + '"]');
                    if (selector) {
                        selector.classList.add('active');
                        const ul = selector.closest('ul.sub-menu');
                        if (ul) {
                            let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                            if (ele) {
                                ele = ele[0];
                                setTimeout(() => {
                                    ele.classList.add('active');
                                });
                            }
                        }
                    }
                },

                removeNotification(value) {
                    this.notifications = this.notifications.filter((d) => d.id !== value);
                },

                removeMessage(value) {
                    this.messages = this.messages.filter((d) => d.id !== value);
                },
            }));
        });
        </script>
</body>

</html>