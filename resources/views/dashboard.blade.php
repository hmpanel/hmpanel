<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 p-4 md:p-0">


                @can('view-any', App\Models\WebApp::class)
                    <!-- Card -->
                    <a class="group flex flex-col bg-white border border-gray-300 shadow-sm rounded-xl hover:shadow-md transition"
                        href="{{ route('web-apps.index') }}">
                        <div class="p-4 md:p-5">
                            <div class="flex items-center">

                                <i class="fad fa-browser fa-2x text-blue-600 flex-shrink-0"></i>

                                <div class="grow ms-5">
                                    <h3 class="group-hover:text-blue-700 font-semibold text-gray-900">
                                        Web Applications
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Add a new web application and manage it from here.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End Card -->
                @endcan
                @can('view-any', App\Models\Domain::class)
                    <!-- Card -->
                    <a class="group flex flex-col bg-white border border-gray-300 shadow-sm rounded-xl hover:shadow-md transition"
                        href="{{ route('domains.index') }}">
                        <div class="p-4 md:p-5">
                            <div class="flex items-center">

                                <i class="fad fa-earth-asia fa-2x text-blue-600 flex-shrink-0"></i>


                                <div class="grow ms-5">
                                    <h3 class="group-hover:text-blue-700 font-semibold text-gray-900">
                                        Domains
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Add a new domain and manage it from here.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End Card -->
                @endcan
                @can('view-any', App\Models\Database::class)
                    <!-- Card -->
                    <a class="group flex flex-col bg-white border border-gray-300 shadow-sm rounded-xl hover:shadow-md transition"
                        href="{{ route('databases.index') }}">
                        <div class="p-4 md:p-5">
                            <div class="flex items-center">

                                <i class="fad fa-database fa-2x text-blue-600 flex-shrink-0"></i>


                                <div class="grow ms-5">
                                    <h3 class="group-hover:text-blue-700 font-semibold text-gray-900">
                                        Databases
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Add a new database and manage it from here.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End Card -->
                @endcan



                <!-- Card -->
                <a class="group flex flex-col bg-white border border-gray-300 shadow-sm rounded-xl hover:shadow-md transition"
                    href="#">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center">

                            <i class="fad fa-terminal fa-2x text-blue-600 flex-shrink-0"></i>

                            <div class="grow ms-5">
                                <h3 class="group-hover:text-blue-700 font-semibold text-gray-900">
                                    Terminal
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Access the terminal to run commands.
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- End Card -->



                @can('view-any', App\Models\EmailAccount::class)
                    <!-- Card -->
                    <a class="group flex flex-col bg-white border border-gray-300 shadow-sm rounded-xl hover:shadow-md transition"
                        href="{{ route('email-accounts.index') }}">
                        <div class="p-4 md:p-5">
                            <div class="flex items-center">

                                <i class="fad fa-envelope fa-2x text-blue-600 flex-shrink-0"></i>

                                <div class="grow ms-5">
                                    <h3 class="group-hover:text-blue-700 font-semibold text-gray-900">
                                        Email Accounts
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Add a new email account and manage it from here.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End Card -->
                @endcan
                @can('view-any', App\Models\FtpAccount::class)
                    <!-- Card -->
                    <a class="group flex flex-col bg-white border border-gray-300 shadow-sm rounded-xl hover:shadow-md transition"
                        href="{{ route('ftp-accounts.index') }}">
                        <div class="p-4 md:p-5">
                            <div class="flex items-center">

                                <i class="fad fa-folders fa-2x text-blue-600 flex-shrink-0"></i>

                                <div class="grow ms-5">
                                    <h3 class="group-hover:text-blue-700 font-semibold text-gray-900">
                                        Ftp Accounts
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Add a new ftp account and manage it from here.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End Card -->
                @endcan
                @can('view-any', App\Models\SshAccess::class)
                    <!-- Card -->
                    <a class="group flex flex-col bg-white border border-gray-300 shadow-sm rounded-xl hover:shadow-md transition"
                        href="{{ route('ssh-accesses.index') }}">
                        <div class="p-4 md:p-5">
                            <div class="flex items-center">

                                <i class="fad fa-square-terminal fa-2x text-blue-600 flex-shrink-0"></i>


                                <div class="grow ms-5">
                                    <h3 class="group-hover:text-blue-700 font-semibold text-gray-900">
                                        SSH Access
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Add a new ssh access and manage it from here.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End Card -->
                @endcan
                @can('view-any', App\Models\User::class)
                    <!-- Card -->
                    <a class="group flex flex-col bg-white border border-gray-300 shadow-sm rounded-xl hover:shadow-md transition"
                        href="{{ route('users.index') }}">
                        <div class="p-4 md:p-5">
                            <div class="flex items-center">

                                <i class="fad fa-user fa-2x text-blue-600 flex-shrink-0"></i>

                                <div class="grow ms-5">
                                    <h3 class="group-hover:text-blue-700 font-semibold text-gray-900">
                                        Users
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Add a new user and manage it from here.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End Card -->
                @endcan


                @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) ||
                        Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))
                    @can('view-any', Spatie\Permission\Models\Role::class)
                        <!-- Card -->
                        <a class="group flex flex-col bg-white border border-gray-300 shadow-sm rounded-xl hover:shadow-md transition"
                            href="{{ route('roles.index') }}">
                            <div class="p-4 md:p-5">
                                <div class="flex items-center">

                                    <i class="fad fa-users fa-2x text-blue-600 flex-shrink-0"></i>

                                    <div class="grow ms-5">
                                        <h3 class="group-hover:text-blue-700 font-semibold text-gray-900">
                                            Roles
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            Add a new role and manage it from here.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!-- End Card -->
                    @endcan

                    @can('view-any', Spatie\Permission\Models\Permission::class)
                        <!-- Card -->
                        <a class="group flex flex-col bg-white border border-gray-300 shadow-sm rounded-xl hover:shadow-md transition"
                            href="{{ route('permissions.index') }}">
                            <div class="p-4 md:p-5">
                                <div class="flex items-center">

                                    <i class="fad fa-key fa-2x text-blue-600 flex-shrink-0"></i>

                                    <div class="grow ms-5">
                                        <h3 class="group-hover:text-blue-700 font-semibold text-gray-900">
                                            Permissions
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            Add a new permission and manage it from here.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!-- End Card -->
                    @endcan
                @endif






            </div>
            <!-- End Grid -->
        </div>
    </div>
</x-app-layout>
