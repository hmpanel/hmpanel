<div class="file-manager-container">
    <div class="container full-container py-5 flex flex-col gap-6">
        <div class="flex-1 flex flex-col bg-custom-gray dark:bg-gray-900 overflow-hidden rounded-lg shadow relative">
            <!-- Loader -->
            <div wire:loading class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-50">
                <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
            </div>

            <!-- Top bar -->
            <div class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 p-2 flex space-x-1">
                <!-- Add your top bar buttons here -->
            </div>

            <!-- Sub toolbar -->
            <div class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 p-2 flex items-center space-x-2">
                <!-- Add your sub toolbar items here -->
            </div>

            <div class="flex h-[30rem]">
                <!-- Folder tree -->
                <div class="w-1/4 border-r bg-white p-4 overflow-y-auto">
                    <ul class="text-sm">
                        @include('livewire.partials.directory-tree', ['directories' => $directories])
                    </ul>
                </div>

                <!-- File list -->
                <div class="flex-1">
                    <div class="overflow-x-auto max-h-[30rem]">
                        <table class="w-full bg-white dark:bg-gray-800 shadow-md">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">Last modified</th>
                                    <th class="px-6 py-3">Permission</th>
                                    <th class="px-6 py-3">Size</th>
                                    <th class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($files as $file)
                                    <tr class="text-sm text-gray-900 dark:text-gray-100">
                                        <td class="px-6 py-4">
                                            @if($file['isDirectory'])
                                                <i class="fas fa-folder text-yellow-500 mr-2"></i>
                                                <span wire:click="openDirectory('{{ $currentPath . $file['name'] . '/' }}')" class="cursor-pointer">{{ $file['name'] }}</span>
                                            @else
                                                <i class="fas fa-file text-blue-500 mr-2"></i>
                                                {{ $file['name'] }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $file['modified'] }}</td>
                                        <td class="px-6 py-4">{{ $file['permissions'] }}</td>
                                        <td class="px-6 py-4">{{ $file['size'] }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Add your action buttons here -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .loader {
        border-top-color: #3498db;
        -webkit-animation: spinner 1.5s linear infinite;
        animation: spinner 1.5s linear infinite;
    }

    @-webkit-keyframes spinner {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spinner {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
</div>
