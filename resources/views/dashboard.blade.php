<x-app-layout>
    <div class="container full-container py-5 flex flex-col gap-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
            <div class="flex flex-col gap-6">

                <div class="card">
                    <div class="card-body">

                        <div class="flex items-center mb-5">

                            <i class="material-symbols-outlined !font-light text-blue-600 text-3xl me-2">
                                dns
                            </i>

                            <h4 class="text-gray-600 text-lg font-semibold">
                                Server Information
                            </h4>

                        </div>


                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-6">

                            <div class="flex flex-col bg-slate-100 p-3 rounded-lg p-5">
                                <label class="text-sm font-bold text-gray-900">
                                    <span class="flex items-center gap-x-2"><i
                                            class="material-symbols-outlined !font-light text-gray-700"> whatshot </i>
                                        Operating System
                                    </span>
                                </label>
                                <div class="mt-1 flex flex-col">Ubuntu 24.04</div>
                            </div>

                            <div class="flex flex-col bg-slate-100 p-3 rounded-lg p-5">
                                <label class="text-sm font-bold text-gray-900">
                                    <span class="flex items-center gap-x-2"><i
                                            class="material-symbols-outlined !font-light text-gray-700"> query_builder
                                        </i>
                                        Uptime
                                    </span>
                                </label>
                                <div class="mt-1 flex flex-col">312 Days, 17 Hours, 19 Minutes</div>
                            </div>

                            <div class="flex flex-col bg-slate-100 p-3 rounded-lg p-5">
                                <label class="text-sm font-bold text-gray-900">
                                    <span class="flex items-center gap-x-2"><i
                                            class="material-symbols-outlined !font-light text-gray-700"> public </i>
                                        IP Address
                                    </span>
                                </label>
                                <div class="mt-1 flex flex-col">89.0.142.86</div>
                            </div>

                            <div class="flex flex-col bg-slate-100 p-3 rounded-lg p-5">
                                <label class="text-sm font-bold text-gray-900">
                                    <span class="flex items-center gap-x-2"><i
                                            class="material-symbols-outlined !font-light text-gray-700"> public </i>
                                        Name Servers
                                    </span>
                                </label>
                                <div class="mt-1 flex flex-col">ns1.google.com</div>
                            </div>





                        </div>
                    </div>
                </div>



                <div class="card">
                    <div class="card-body">

                        <div class="flex items-center mb-5">

                            <i class="material-symbols-outlined !font-light text-blue-600 text-3xl me-2">
                                memory
                            </i>

                            <h4 class="text-gray-600 text-lg font-semibold">
                                CPU Load
                            </h4>

                        </div>

                        <div id="chart"></div>
                    </div>
                </div>


            </div>

            <div class="flex flex-col gap-6">

                <div class="card">
                    <div class="card-body">
                        <div class="flex justify-between align-middle">




                            <div class="flex items-center">

                                <i class="material-symbols-outlined !font-light text-blue-600 text-3xl me-2">
                                    memory_alt
                                </i>

                                <h4 class="text-gray-600 text-lg font-semibold">
                                    RAM Usage
                                </h4>

                            </div>

                            <p class="text-sm font-medium text-gray-600">50 GB / 25.6 GB</p>

                        </div>



                        <div id="ram-usage-chart"></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex justify-between">

                            <div class="flex items-center">

                                <i class="material-symbols-outlined !font-light text-blue-600 text-3xl me-2">
                                    hard_drive_2
                                </i>

                                <h4 class="text-gray-600 text-lg font-semibold">
                                    Disk Usage
                                </h4>

                            </div>

                            <p class="text-sm font-medium text-gray-600">50 GB / 25.6 GB</p>

                        </div>

                        <div class="bg-gray-200 mt-2 flex h-1 w-full items-center rounded">
                            <span class="bg-blue-600 h-full w-1/2 rounded"></span>
                        </div>
                    </div>
                    <div id="diskchart"></div>




                </div>

            </div>


        </div>







        <!-- Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 p-4 md:p-0 mt-3">

            @can('view-any', App\Models\WebApp::class)
                <!-- Card -->
                <a class="bg-white flex flex-col group hover:shadow-md rounded-xl shadow-sm transition"
                    href="{{ route('web-apps.index') }}">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center">

                            <i class="fal fa-browser fa-2x text-blue-600 flex-shrink-0"></i>

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
                <a class="bg-white flex flex-col group hover:shadow-md rounded-xl shadow-sm transition"
                    href="{{ route('domains.index') }}">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center">

                            <i class="fal fa-earth-asia fa-2x text-blue-600 flex-shrink-0"></i>


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
                <a class="bg-white flex flex-col group hover:shadow-md rounded-xl shadow-sm transition"
                    href="{{ route('databases.index') }}">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center">

                            <i class="fal fa-database fa-2x text-blue-600 flex-shrink-0"></i>


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
            <a class="bg-white flex flex-col group hover:shadow-md rounded-xl shadow-sm transition" href="#">
                <div class="p-4 md:p-5">
                    <div class="flex items-center">

                        <i class="fal fa-terminal fa-2x text-blue-600 flex-shrink-0"></i>

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
                <a class="bg-white flex flex-col group hover:shadow-md rounded-xl shadow-sm transition"
                    href="{{ route('email-accounts.index') }}">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center">

                            <i class="fal fa-envelope fa-2x text-blue-600 flex-shrink-0"></i>

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
                <a class="bg-white flex flex-col group hover:shadow-md rounded-xl shadow-sm transition"
                    href="{{ route('ftp-accounts.index') }}">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center">

                            <i class="fal fa-folders fa-2x text-blue-600 flex-shrink-0"></i>

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
                <a class="bg-white flex flex-col group hover:shadow-md rounded-xl shadow-sm transition"
                    href="{{ route('ssh-accesses.index') }}">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center">

                            <i class="fal fa-square-terminal fa-2x text-blue-600 flex-shrink-0"></i>


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
                <a class="bg-white flex flex-col group hover:shadow-md rounded-xl shadow-sm transition"
                    href="{{ route('users.index') }}">
                    <div class="p-4 md:p-5">
                        <div class="flex items-center">

                            <i class="fal fa-user fa-2x text-blue-600 flex-shrink-0"></i>

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
                    <a class="bg-white flex flex-col group hover:shadow-md rounded-xl shadow-sm transition"
                        href="{{ route('roles.index') }}">
                        <div class="p-4 md:p-5">
                            <div class="flex items-center">

                                <i class="fal fa-users fa-2x text-blue-600 flex-shrink-0"></i>

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
                    <a class="bg-white flex flex-col group hover:shadow-md rounded-xl shadow-sm transition"
                        href="{{ route('permissions.index') }}">
                        <div class="p-4 md:p-5">
                            <div class="flex items-center">

                                <i class="fal fa-key fa-2x text-blue-600 flex-shrink-0"></i>

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



        <footer>
            <p class="text-base text-gray-500 font-normal p-3 text-center">
                Hosting Management Panel - <a href="#" target="_blank"
                    class="text-blue-600 underline hover:text-blue-700">hmPanel</a>
            </p>
        </footer>
    </div>

    @push('scripts')
        <script>




                // Helper function to destroy existing chart

                var cpuLoadOptions = {
                    series: [{
                        name: "CPU Load",
                        data: generateRandomData(20) // Initial random data
                    }],
                    chart: {
                        type: "area",
                        height: 193,
                        foreColor: "#adb0bb",
                        fontFamily: 'inherit',
                        animations: {
                            enabled: true,
                            easing: 'linear',
                            dynamicAnimation: {
                                speed: 1000
                            }
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    xaxis: {
                        type: "datetime",
                        labels: {
                            style: {
                                cssClass: "grey--text lighten-2--text fill-color"
                            },
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 100,
                        tickAmount: 4,
                        labels: {
                            style: {
                                cssClass: "grey--text lighten-2--text fill-color"
                            }
                        }
                    },
                    tooltip: {
                        theme: "light"
                    }
                };

                var cpuLoadChart = new ApexCharts(document.querySelector("#chart"), cpuLoadOptions);
                cpuLoadChart.render();
                document.querySelector("#chart")._chartInstance = cpuLoadChart;

                // Function to generate random CPU load data
                function generateRandomData(count) {
                    var data = [];
                    var now = Date.now();
                    for (var i = 0; i < count; i++) {
                        data.push({
                            x: new Date(now - (count - i) * 1000),
                            y: Math.floor(Math.random() * 100)
                        });
                    }
                    return data;
                }

                // Function to update the chart with new data


                var diskSpeedOptions = {
                    series: [{
                        name: "Read Speed",
                        data: generateRandomDiskData(20) // Initial random data
                    }, {
                        name: "Write Speed",
                        data: generateRandomDiskData(20) // Initial random data
                    }],
                    chart: {
                        type: "line",
                        height: 201,
                        foreColor: "#adb0bb",
                        fontFamily: 'inherit',
                        animations: {
                            enabled: true,
                            easing: 'linear',
                            dynamicAnimation: {
                                speed: 1000
                            }
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    xaxis: {
                        type: "datetime",
                        labels: {
                            style: {
                                cssClass: "grey--text lighten-2--text fill-color"
                            },
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 200,
                        tickAmount: 2,
                        labels: {
                            style: {
                                cssClass: "grey--text lighten-2--text fill-color"
                            }
                        }
                    },
                    tooltip: {
                        theme: "light"
                    }
                };

                var diskSpeedChart = new ApexCharts(document.querySelector("#diskchart"), diskSpeedOptions);
                diskSpeedChart.render();
                document.querySelector("#diskchart")._chartInstance = diskSpeedChart;

                // Function to generate random disk speed data
                function generateRandomDiskData(count) {
                    var data = [];
                    var now = Date.now();
                    for (var i = 0; i < count; i++) {
                        data.push({
                            x: new Date(now - (count - i) * 1000),
                            y: Math.floor(Math.random() * 200)
                        });
                    }
                    return data;
                }


                // =====================================
                // RAM Usage Donut Chart
                // =====================================
                var ramUsageOptions = {
                    series: [45, 55], // Initial random data
                    labels: ["Used RAM", "Free RAM"],
                    chart: {
                        type: "donut",
                        height: 260,
                        foreColor: "#adb0bb",
                        fontFamily: 'inherit',
                        animations: {
                            enabled: true,
                            easing: 'linear',
                            dynamicAnimation: {
                                speed: 1000
                            }
                        },
                        toolbar: {
                            show: true
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '75%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '22px',
                                        color: '#adb0bb',
                                        offsetY: -5
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '16px',
                                        color: '#adb0bb',
                                        offsetY: 5,
                                        formatter: function(val) {
                                            return val + "%";
                                        }
                                    },
                                    total: {
                                        show: true,
                                        showAlways: true,
                                        label: 'Used',
                                        formatter: function(w) {
                                            return w.globals.series[0] + "%";
                                        }
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        show: true,
                        position: 'bottom'
                    },
                    tooltip: {
                        theme: "light"
                    },
                    colors: ["#FF4560", "#00E396"]
                };

                var ramUsageChart = new ApexCharts(document.querySelector("#ram-usage-chart"), ramUsageOptions);
                ramUsageChart.render();
                document.querySelector("#ram-usage-chart")._chartInstance = ramUsageChart;

                // Function to generate random RAM usage data
                function generateRandomRAMData() {
                    var usedRAM = Math.floor(Math.random() * 100);
                    var freeRAM = 100 - usedRAM;
                    return [usedRAM, freeRAM];
                }


                function updateChart() {

                    var newData = {
                        x: new Date(),
                        y: Math.floor(Math.random() * 100)
                    };

                    cpuLoadChart.updateSeries([{
                        data: [...cpuLoadChart.w.config.series[0].data.slice(1), newData]
                    }]);


                    var newReadData = {
                        x: new Date(),
                        y: Math.floor(Math.random() * 200)
                    };
                    var newWriteData = {
                        x: new Date(),
                        y: Math.floor(Math.random() * 200)
                    };
                    diskSpeedChart.updateSeries([{
                        data: [...diskSpeedChart.w.config.series[0].data.slice(1), newReadData]
                    }, {
                        data: [...diskSpeedChart.w.config.series[1].data.slice(1), newWriteData]
                    }]);

                    var newRAMData = generateRandomRAMData();
                    ramUsageChart.updateSeries(newRAMData);
                }

                // Update the chart every second
                setInterval(updateChart, 5000);


        </script>
    @endpush



</x-app-layout>
