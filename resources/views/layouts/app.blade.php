<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="./assets/images/logos/favicon.png" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <!-- Core Css -->
    <title>hmPanel @if(!empty($header)) {{ ' | ' . $header }} @endif</title>


    <link href="./assets/css/theme.css" rel="stylesheet" />

    <script type="module">
        import hotwiredTurbo from 'https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/+esm';
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <link href="https://itsmashikur.github.io/assets/font-awesome-6-pro-main/css/all.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" />

    <style>
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loader {
            border-top-color: #3490dc;
            animation: spin 1.5s linear infinite;
        }

        /* scrollbar */

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
        }

    </style>


</head>

<body class="bg-blue-50">

    <div id="preloader" class="fixed inset-0 backdrop-blur-sm bg-white/70 flex items-center justify-center z-[2000]">
        <div class="loader ease-linear rounded-full border-2 border-t-2 border-gray-200 h-20 w-20"></div>
    </div>

    <main>
        <!--start the project-->
        <div id="main-wrapper" class=" flex">
            @include('layouts.sidebar')
            <div class="w-full page-wrapper overflow-hidden">

                @include('layouts.header')

                <!-- Page Heading -->

                <!-- Main Content -->
                <main class="h-full overflow-y-auto  max-w-full">

                    {{ $slot }}

                </main>
                <!-- Main Content End -->

            </div>
        </div>
        <!--end of project-->
    </main>

    @stack('modals')




    <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="./assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="./assets/libs/iconify-icon/dist/iconify-icon.min.js"></script>
    <script src="./assets/libs/@preline/dropdown/index.js"></script>
    <script src="./assets/libs/@preline/overlay/index.js"></script>
    <script src="./assets/js/sidebarmenu.js"></script>
    <script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>

    @livewireScripts



    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    @if (session()->has('success'))
        <script>
            var notyf = new Notyf({
                dismissible: true
            })
            notyf.success('{{ session('success') }}')
        </script>
    @endif

    <script>
        /* Simple Alpine Image Viewer */
        document.addEventListener('alpine:init', () => {
            Alpine.data('imageViewer', (src = '') => {
                return {
                    imageUrl: src,

                    refreshUrl() {
                        this.imageUrl = this.$el.getAttribute("image-url")
                    },

                    fileChosen(event) {
                        this.fileToDataUrl(event, src => this.imageUrl = src)
                    },

                    fileToDataUrl(event, callback) {
                        if (!event.target.files.length) return

                        let file = event.target.files[0],
                            reader = new FileReader()

                        reader.readAsDataURL(file)
                        reader.onload = e => callback(e.target.result)
                    },
                }
            })
        })
    </script>

    <script>
        document.addEventListener('turbo:load', () => {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.display = 'none';
            }
        });

        document.addEventListener('turbo:before-visit', () => {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.display = 'flex';
            }
        });
    </script>

</body>

</html>
