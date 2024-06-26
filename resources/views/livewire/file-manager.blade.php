<div class="file-manager-container">
    <div class="container full-container py-5 flex flex-col gap-6">
        <div class="flex-1 flex flex-col bg-custom-gray dark:bg-gray-900 overflow-hidden rounded-lg shadow relative">


            <div wire:loading>
                <!-- Loader -->
                <div
                    class="absolute inset-0 backdrop-blur-sm bg-white/30 flex items-center justify-center z-50 w-full h-full">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>


            <div class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 p-2 flex items-center space-x-2">
                <button wire:click="openDirectory('{{ dirname($currentPath) }}')"
                    class="p-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <i class="fas fa-arrow-up"></i>
                </button>
                <button wire:click="listDirectories"
                    class="p-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <div
                    class="flex-1 bg-gray-100 dark:bg-gray-700 rounded px-3 py-1 text-sm text-gray-600 dark:text-gray-300 flex items-center">
                    <i class="fas fa-folder-open mr-2"></i>
                    <span>{{ $currentPath }}</span>
                </div>
                <!-- ... (keep the search and view buttons as is) ... -->
            </div>

            <div class="flex h-[30rem]">
                <!-- Folder tree -->
                <div class="w-1/4 border-r bg-white p-4 overflow-y-auto">
                    <ul class="text-sm">
                        @include('livewire.partials._directory_tree', ['directories' => $directories])
                    </ul>
                </div>

                <!-- File list -->
                <div class="flex-1">
                    <div class="overflow-x-auto max-h-[30rem]">
                        <table class="w-full bg-white dark:bg-gray-800 shadow-md">
                            <!-- ... (keep the table header as is) ... -->
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($files as $file)
                                    <tr class="text-sm text-gray-900 dark:text-gray-100">
                                        <td class="px-6 py-4">
                                            @if ($file['isDirectory'])
                                                <i class="fas fa-folder text-yellow-500 mr-2"></i>
                                                <span
                                                    wire:click="openDirectory('{{ $currentPath . $file['name'] . '/' }}')"
                                                    class="cursor-pointer">{{ $file['name'] }}</span>
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
</div>






{{--



<div class="file-manager-container">
    <div class="container full-container py-5 flex flex-col gap-6">
        <div class="flex-1 flex flex-col bg-custom-gray dark:bg-gray-900 overflow-hidden rounded-lg shadow relative">


            <div class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 p-2 flex items-center space-x-1">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs mr-2">
                    <i class="fas fa-times" :class="sidebarOpen ? 'fa-times' : 'fa-bars'"></i>
                </button>
                <button class="px-2 py-1 bg-custom-blue text-white rounded hover:bg-blue-600 text-xs font-medium">
                    <i class="fas fa-plus mr-1"></i> Add file
                </button>
                <button class="px-2 py-1 bg-custom-blue text-white rounded hover:bg-blue-600 text-xs font-medium">
                    <i class="fas fa-folder-plus mr-1"></i> Add folder
                </button>
                <button
                    class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                    <i class="fas fa-upload mr-1"></i> Upload
                </button>
                <button
                    class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
                <button
                    class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                    <i class="fas fa-arrow-right mr-1"></i> Move
                </button>
                <button
                    class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                    <i class="fas fa-download mr-1"></i> Download
                </button>
                <button
                    class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                    <i class="fas fa-edit mr-1"></i> Rename
                </button>
                <button
                    class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                    <i class="fas fa-trash-alt mr-1"></i> Delete
                </button>
                <button
                    class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                    <i class="fas fa-archive mr-1"></i> Archive
                </button>
                <button
                    class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                    <i class="fas fa-key mr-1"></i> Permission
                </button>
                <button
                    class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                <div class="flex-grow"></div>
                <button @click="darkMode = !darkMode" class="text-gray-500 dark:text-gray-400 mr-2">
                    <i class="fas fa-moon" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                </button>
                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                    <i class="fas fa-user"></i>
                </div>
            </div>



            <div class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 p-2 flex items-center space-x-2">
                <button class="p-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="p-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <button class="p-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <i class="fas fa-arrow-up"></i>
                </button>
                <button class="p-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <div
                    class="flex-1 bg-gray-100 dark:bg-gray-700 rounded px-3 py-1 text-sm text-gray-600 dark:text-gray-300 flex items-center">
                    <i class="fas fa-folder-open mr-2"></i>
                    <span>Path:/public_html/files/Web assets/</span>
                </div>
                <div class="relative">
                    <input type="text" placeholder="Search"
                        class="bg-gray-100 dark:bg-gray-700 rounded px-3 py-1 text-sm text-gray-600 dark:text-gray-300 pr-8">
                    <i class="fas fa-search absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button class="p-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <i class="fas fa-th-large"></i>
                </button>
                <button class="p-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div class="flex h-[30rem]">
                <!-- Folder tree -->
                <div class="w-1/4 border-r bg-white p-4 overflow-y-auto">
                    <ul class="text-sm">
                        @include('livewire.partials._directory_tree', ['directories' => $directories])
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
                                @foreach ($files as $file)
                                    <tr class="text-sm text-gray-900 dark:text-gray-100">
                                        <td class="px-6 py-4">
                                            @if ($file['isDirectory'])
                                                <i class="fas fa-folder text-yellow-500 mr-2"></i>
                                                <span
                                                    wire:click="openDirectory('{{ $currentPath . $file['name'] . '/' }}')"
                                                    class="cursor-pointer">{{ $file['name'] }}</span>
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

</div> --}}
