<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Dashboard</title>
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
                    <h6>Proyek ini bertujuan untuk menganalisis sentimen pengguna terhadap game Mobile Legends dengan
                        menggunakan algoritma Support Vector Machine (SVM). Mobile Legends adalah salah satu game mobile
                        paling populer, dan memahami sentimen pengguna dapat memberikan wawasan berharga bagi pengembang
                        game dan komunitas pemain.</h6>
                    <br>
                    <h6>Squential training merupakan salah satu algoritma yang digunakan untuk
                        melatih model SVM. Selain Sequential Training , terdapat juga algoritma lain
                        seperti Quadric Progammin dan Squential Minimal Optimization (SMO).
                        Keunggulan dari Squential Training adalah kemudahan dalam pemahanan konsep
                        dan memakan waktu yang kecil untuk pemrosesannya.</h6>
                </div>
            </div>
            <!-- end main content section -->

            <!-- start footer section -->
            <?php include '../includes/footer.php' ?>
            <!-- end footer section -->
        </div>
    </div>

    <?php include '../includes/js.php'  ?>
</body>

</html>