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
                <!-- <li class="menu nav-item">
                    <button type="button" class="nav-link group">
                        <div class="flex items-center">
                            <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.5"
                                    d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                                    fill="currentColor" />
                                <path
                                    d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z"
                                    fill="currentColor" />
                            </svg>

                            <span
                                class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Dashboard</span>
                        </div>
                    </button>

                </li>
                 -->
                <li class="menu nav-item">
                    <ul>
                        <li>
                            <a href="index.php">Dashboard</a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="datatraining.php">Data Training</a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="preprocessing.php">Preprocessing</a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="tfidf.php">TF IDF</a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="sentimenpelabelan.php">Sentimen Pelabelan</a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <!-- <a href="svm.php">SVM</a> -->
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <!-- <a href="datachart.php">Data Chart</a> -->
                        </li>
                    </ul>
                    <!-- <ul>
                        <li>
                            <a href="similarity.php">Similarity</a>
                        </li>
                    </ul> -->
                    <ul>
                        <li>
                            <!-- <a href="datatesting.php">Data Testing</a> -->
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="st.php">SVM</a>
                        </li>
                        <li>
                            <a href="svm.php">Pengujian</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>