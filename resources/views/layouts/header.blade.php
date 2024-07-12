<!--  Header Start -->
<header class="container full-container w-full text-sm pb-5 px-5">



    <!-- ========== HEADER ========== -->

    <nav class=" w-full flex items-center justify-between bg-white rounded-b-xl p-4 shadow-sm" aria-label="Global">
        <ul class="icon-nav flex items-center gap-4">


            <li class="relative xl:hidden">
                <a class="text-xl  icon-hover cursor-pointer text-heading" id="headerCollapse"
                    data-hs-overlay="#application-sidebar-brand" aria-controls="application-sidebar-brand"
                    aria-label="Toggle navigation" href="javascript:void(0)">
                    <i class="ti ti-menu-2 relative z-1"></i>
                </a>
            </li>


            <li class="relative">

                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                            <?php echo $header ?? 'Dashboard'; ?>
                        </a>
                    </div>

            </li>
        </ul>
        <div class="flex items-center gap-4">



            <div class="hs-dropdown relative inline-flex [--placement:bottom-right] sm:[--trigger:hover]">
                <a class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full">
                    <img class="object-cover w-9 h-9 rounded-full" src="./assets/images/profile/user-1.jpg"
                        alt="" aria-hidden="true">
                </a>
                <div class="card hs-dropdown-menu transition-[opacity,margin] border border-gray-400 rounded-[7px] duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max  w-[200px] hidden z-[12]"
                    aria-labelledby="hs-dropdown-custom-icon-trigger">
                    <div class="card-body p-0 py-2">
                        <a href="javscript:void(0)" class="flex gap-2 items-center px-4 py-[6px] hover:bg-blue-500">
                            <i class="ti ti-user text-gray-500 text-xl "></i>
                            <p class="text-sm text-gray-500">My Profile</p>
                        </a>
                        <a href="javscript:void(0)" class="flex gap-2 items-center px-4 py-[6px] hover:bg-blue-500">
                            <i class="ti ti-mail text-gray-500 text-xl"></i>
                            <p class="text-sm text-gray-500">My Account</p>
                        </a>
                        <a href="javscript:void(0)" class="flex gap-2 items-center px-4 py-[6px] hover:bg-blue-500">
                            <i class="ti ti-list-check text-gray-500 text-xl "></i>
                            <p class="text-sm text-gray-500">My Task</p>
                        </a>
                        <div class="px-4 mt-[7px] grid">
                            <a href="../../pages/authentication-login.html"
                                class="btn-outline-primary w-full hover:bg-blue-600 hover:text-white">Logout</a>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </nav>
    <!-- ========== END HEADER ========== -->
</header>
<!--  Header End -->
