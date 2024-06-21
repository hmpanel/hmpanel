<aside id="application-sidebar-brand"
    class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full  transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed top-0 with-vertical h-screen z-[999] flex-shrink-0 border-r-[1px] w-[270px] border-gray-200  bg-white left-sidebar   transition-all duration-300">

    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="p-5">
        <a href="/" class="text-nowrap text-2xl italic text-blue-600 font-bold">
            hmPanel
        </a>
    </div>

    <div class="scroll-sidebar" data-simplebar="">
        <div class="px-6 mt-8">
            <nav class=" w-full flex flex-col sidebar-nav">
                <ul id="sidebarnav" class="text-gray-600 text-sm">
                    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">

                    <li class="text-xs font-bold pb-4">
                        <span>HOME</span>
                    </li>


                    <li class="sidebar-item">
                        <a class="sidebar-link gap-3 py-2 px-3  rounded-md  w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                            href="{{ route('dashboard') }}">
                            <i class="material-symbols-outlined mr-2 text-xl !font-light">dashboard</i> <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="text-xs font-bold mb-4 mt-8">
                        <span>HOSTING</span>
                    </li>

                    @can('view-any', App\Models\WebApp::class)
                        <li class="sidebar-item">
                            <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                                href="{{ route('web-apps.index') }}">
                                <i class="material-symbols-outlined mr-2 text-xl !font-light">globe</i> <span>Web Apps</span>
                            </a>
                        </li>
                    @endcan


                    @can('view-any', App\Models\Domain::class)
                        <li class="sidebar-item">
                            <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                                href="{{ route('domains.index') }}">
                                <i class="material-symbols-outlined mr-2 text-xl !font-light">travel_explore</i> <span>Domains</span>
                            </a>
                        </li>
                    @endcan


                    @can('view-any', App\Models\Database::class)
                        <li class="sidebar-item">
                            <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                                href="{{ route('databases.index') }}">
                                <i class="material-symbols-outlined mr-2 text-xl !font-light">database</i> <span>Databases</span>
                            </a>
                        </li>
                    @endcan



                    @can('view-any', App\Models\EmailAccount::class)
                        <li class="sidebar-item">
                            <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                                href="{{ route('email-accounts.index') }}">
                                <i class="material-symbols-outlined mr-2 text-xl !font-light">email</i> <span>Email Accounts</span>
                            </a>
                        </li>
                    @endcan


                    @can('view-any', App\Models\FtpAccount::class || App\Models\SshAccess::class)
                        <li class="text-xs font-bold mb-4 mt-8">
                            <span>REMOTE</span>
                        </li>
                    @endcan

                    {{-- @can('view-any', App\Models\FtpAccount::class)
                        <li class="sidebar-item">
                            <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                                href="{{ route('ftp-accounts.index') }}">
                                <i class="material-symbols-outlined mr-2 text-xl !font-light">smb_share</i> <span>FTP Accounts</span>
                            </a>
                        </li>
                    @endcan --}}


                    @can('view-any', App\Models\SshAccess::class)
                        <li class="sidebar-item">
                            <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                                href="{{ route('ssh-accesses.index') }}">
                                <i class="material-symbols-outlined mr-2 text-xl !font-light">key_vertical</i> <span>SSH Access</span>
                            </a>
                        </li>
                    @endcan
{{--

                    <li class="text-xs font-bold mb-4 mt-8">
                        <span>EXTRA</span>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                            href="/terminal">
                            <i class="material-symbols-outlined mr-2 text-xl !font-light">terminal</i> <span>Terminal</span>
                        </a>
                    </li>


                    <li class="sidebar-item">
                        <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                            href="/terminal">
                            <i class="material-symbols-outlined mr-2 text-xl !font-light">cloud</i> <span>Cloud Backup</span>
                        </a>
                    </li> --}}


                    <li class="text-xs font-bold mb-4 mt-8">
                        <span>ADMIN</span>
                    </li>



                    @can('view-any', App\Models\User::class)
                        <li class="sidebar-item">
                            <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                                href="{{ route('users.index') }}">
                                <i class="material-symbols-outlined mr-2 text-xl !font-light">group</i> <span>Users</span>
                            </a>
                        </li>
                    @endcan


                    @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) ||
                            Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))
                        @can('view-any', Spatie\Permission\Models\Role::class)
                            <li class="sidebar-item">
                                <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                                    href="{{ route('roles.index') }}">
                                    <i class="material-symbols-outlined mr-2 text-xl !font-light">supervisor_account</i> <span>Roles</span>
                                </a>
                            </li>
                        @endcan

                        @can('view-any', Spatie\Permission\Models\Permission::class)
                            <li class="sidebar-item">
                                <a class="sidebar-link gap-3 py-2 px-3  rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-500"
                                    href="{{ route('permissions.index') }}">
                                    <i class="material-symbols-outlined mr-2 text-xl !font-light">key</i> <span>Permissions</span>
                                </a>
                            </li>
                        @endcan
                    @endif

                </ul>
            </nav>
        </div>
    </div>


</aside>
