<!--  Header Start -->
<header class="container full-container w-full text-sm py-5 px-5">
    <!-- ========== HEADER ========== -->
    <nav class=" w-full flex items-center justify-between bg-white rounded-xl p-4 shadow-sm" aria-label="Global">
        <ul class="icon-nav flex items-center gap-4">
            <li class="relative xl:hidden">
                <a class="text-xl  icon-hover cursor-pointer text-heading" id="headerCollapse"
                    data-hs-overlay="#application-sidebar-brand" aria-controls="application-sidebar-brand"
                    aria-label="Toggle navigation" href="javascript:void(0)">
                    <i class="ti ti-menu-2 relative z-1"></i>
                </a>
            </li>

            <li class="relative">

                <div class="hs-dropdown relative inline-flex [--placement:bottom-left] sm:[--trigger:hover]">
                    <a class="relative hs-dropdown-toggle inline-flex  icon-hover text-gray-600" href="#">
                        <i class="ti ti-bell-ringing text-xl relative z-[1]"></i>
                        <div
                            class="absolute inline-flex items-center justify-center  text-white text-[11px] font-medium  bg-blue-600 w-2 h-2 rounded-full -top-[1px] -right-[6px]">
                        </div>
                    </a>
                    <div class="card hs-dropdown-menu transition-[opacity,margin] border border-gray-400 rounded-md duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max  w-[300px] hidden z-[12]"
                        aria-labelledby="hs-dropdown-custom-icon-trigger">
                        <div>
                            <h3 class="text-gray-600 font-semibold text-base px-6 py-3">Notification
                            </h3>
                            <ul class="list-none  flex flex-col">
                                <li>
                                    <a href="#" class="py-3 px-6 block hover:bg-blue-500">
                                        <p class="text-sm text-gray-600 font-semibold">Roman Joined the
                                            Team!</p>
                                        <p class="text-xs text-gray-500 font-medium">Congratulate him
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-3 px-6 block hover:bg-blue-500">
                                        <p class="text-sm text-gray-600 font-semibold">New message
                                            received</p>
                                        <p class="text-xs text-gray-500 font-medium">Salma sent you new
                                            message</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-3 px-6 block hover:bg-blue-500">
                                        <p class="text-sm text-gray-600 font-semibold">New Payment
                                            received</p>
                                        <p class="text-xs text-gray-500 font-medium">Check your earnings
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-3 px-6 block hover:bg-blue-500">
                                        <p class="text-sm text-gray-600 font-semibold">Jolly completed
                                            tasks</p>
                                        <p class="text-xs text-gray-500 font-medium">Assign her new
                                            tasks</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="py-3 px-6 block hover:bg-blue-500">
                                        <p class="text-sm text-gray-600 font-semibold">Roman Joined the
                                            Team!</p>
                                        <p class="text-xs text-gray-500 font-medium">Congratulate him
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </li>


        </ul>
        <div class="flex items-center gap-4">

            <div class="flex w-[200px] flex-col rounded-[20px]">
                <div class="flex flex-col">
                    <div class="flex justify-between">
                        <p class="text-sm font-medium text-gray-600">
                            <i class="ti ti-folder"></i>
                            Storage
                        </p>
                        <p class="text-sm font-medium text-gray-600">50 GB / 25.6 GB</p>
                    </div>
                    <div class="bg-gray-200 mt-2 flex h-1 w-full items-center rounded">
                        <span class="bg-blue-600 h-full w-1/2 rounded"></span>
                    </div>
                </div>
            </div>

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
