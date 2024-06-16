<style>
.menu .nav-item.active .nav-link {
    background-color: #f0f0f0;
    /* Ganti dengan warna latar belakang yang sesuai */
}
</style>
<div :class="{'dark text-white-dark' : $store.app.semidark}">
    <nav x-data="sidebar"
        class="sidebar fixed bottom-0 top-0 z-50 h-full min-h-screen w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-all duration-300">
        <div class="h-full bg-white dark:bg-[#0e1726]">
            <div class="flex items-center justify-between px-4 py-3">
                <a href="index.php" class="main-logo flex shrink-0 items-center">
                    <img class="ml-[5px] w-8 flex-none" src="../assets/images/logo.svg" alt="image" />
                    <span
                        class="align-middle text-2xl font-semibold ltr:ml-1.5 rtl:mr-1.5 dark:text-white-light lg:inline">SVM</span>
                </a>
                <a href="javascript:;"
                    class="collapse-icon flex h-8 w-8 items-center rounded-full transition duration-300 hover:bg-gray-500/10 rtl:rotate-180 dark:text-white-light dark:hover:bg-dark-light/10"
                    @click="$store.app.toggleSidebar()">
                    <svg class="m-auto h-5 w-5" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
            <ul
                class="perfect-scrollbar relative h-[calc(100vh-80px)] space-y-0.5 overflow-y-auto overflow-x-hidden p-4 py-0 font-semibold">
                <li class="menu nav-item">
                    <a href="index.php" class="nav-link group">
                        <div class="flex items-center">
                            <span
                                class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Dashboard</span>
                        </div>
                    </a>

                </li>
                <li class="menu nav-item">
                    <a href="datatraining.php" class="nav-link group">
                        <div class="flex items-center">
                            <span
                                class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Data
                                Training</span>
                        </div>
                    </a>

                </li>
                <li class="menu nav-item">
                    <a href="preprocessing.php" class="nav-link group">
                        <div class="flex items-center">
                            <span
                                class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Preprocessing</span>
                        </div>
                    </a>
                </li>
                <li class="menu nav-item">
                    <a href="tfidf.php" class="nav-link group">
                        <div class="flex items-center">
                            <span
                                class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">TF
                                IDF</span>
                        </div>
                    </a>
                </li>
                <li class="menu nav-item">
                    <a href="st.php" class="nav-link group">
                        <div class="flex items-center">
                            <span
                                class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">SVM</span>
                        </div>
                    </a>
                </li>
                <li class="menu nav-item">
                    <a href="svm.php" class="nav-link group">
                        <div class="flex items-center">
                            <span
                                class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Pengujian</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var currentPath = window.location.pathname;
    var currentPage = currentPath.split('/').pop();

    var sidebarItems = document.querySelectorAll('.menu .nav-item');

    sidebarItems.forEach(function(item) {
        var link = item.querySelector('.nav-link');
        var href = link.getAttribute('href');

        // Memeriksa apakah href di sidebar cocok dengan halaman yang sedang dibuka
        if (currentPage === href) {
            item.classList.add('active');
        }
    });
});
</script>