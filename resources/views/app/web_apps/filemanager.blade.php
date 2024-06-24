<x-app-layout>
    <x-slot name="header"> File Manager </x-slot>


    <div class="container full-container py-5 flex flex-col gap-6">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Current Directory Navigation -->
            <div class="p-4 bg-gray-50 border-b">
                <div class="flex items-center space-x-2 text-gray-600 mb-4">
                    <span class="font-medium">Current Directory:</span>
                    <button class="hover:text-blue-500">/</button>
                    <button class="hover:text-blue-500">home</button>
                    <button class="hover:text-blue-500">user</button>
                    <button class="hover:text-blue-500">documents</button>
                </div>
            </div>

            <div class="p-4 bg-gray-50 border-b">
                <div class="flex justify-between items-center mb-4">
                    <div class="relative">
                        <input type="text" placeholder="Search files..."
                            class="border px-4 py-2 w-80 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <button
                        class="bg-blue-500 text-white px-4 py-2 hover:bg-blue-600 transition duration-300 flex items-center">
                        <i class="fas fa-upload mr-2"></i> Upload File
                    </button>
                </div>

                <div class="flex space-x-2">
                    <button
                        class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-copy mr-1"></i> Copy
                    </button>
                    <button
                        class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-cut mr-1"></i> Cut
                    </button>
                    <button
                        class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-trash-alt mr-1"></i> Delete
                    </button>
                    <button
                        class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-file-archive mr-1"></i> Extract
                    </button>
                    <button
                        class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-archive mr-1"></i> Archive
                    </button>
                    <button
                        class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-300 transition duration-300">
                        <i class="fas fa-check-square mr-1"></i> Select All
                    </button>
                </div>
            </div>

            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left p-3 text-gray-600 font-semibold">Name</th>
                        <th class="text-left p-3 text-gray-600 font-semibold">Size</th>
                        <th class="text-left p-3 text-gray-600 font-semibold">Permissions</th>
                        <th class="text-left p-3 text-gray-600 font-semibold">Modified</th>
                        <th class="text-left p-3 text-gray-600 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50 transition duration-150">
                        <td class="p-3 flex items-center">
                            <input type="checkbox" class="mr-2">
                            <i class="fas fa-folder text-yellow-400 mr-2"></i>
                            <button class="hover:text-blue-500">Projects</button>
                        </td>
                        <td class="p-3">--</td>
                        <td class="p-3">drwxr-xr-x</td>
                        <td class="p-3">2024-06-25 11:30</td>
                        <td class="p-3">
                            <button class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></button>
                            <button class="text-red-500 hover:text-red-700 ml-2"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50 transition duration-150">
                        <td class="p-3 flex items-center">
                            <input type="checkbox" class="mr-2">
                            <i class="fas fa-file-code text-blue-500 mr-2"></i>
                            index.html
                        </td>
                        <td class="p-3">10 KB</td>
                        <td class="p-3">-rw-r--r--</td>
                        <td class="p-3">2024-06-25 10:30</td>
                        <td class="p-3">
                            <button class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></button>
                            <button class="text-red-500 hover:text-red-700 ml-2"><i class="fas fa-trash"></i></button>
                            <button class="text-green-500 hover:text-green-700 ml-2"><i
                                    class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50 transition duration-150">
                        <td class="p-3 flex items-center">
                            <input type="checkbox" class="mr-2">
                            <i class="fas fa-file-alt text-yellow-500 mr-2"></i>
                            styles.css
                        </td>
                        <td class="p-3">5 KB</td>
                        <td class="p-3">-rw-r--r--</td>
                        <td class="p-3">2024-06-24 15:45</td>
                        <td class="p-3">
                            <button class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></button>
                            <button class="text-red-500 hover:text-red-700 ml-2"><i class="fas fa-trash"></i></button>
                            <button class="text-green-500 hover:text-green-700 ml-2"><i
                                    class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="p-3 flex items-center">
                            <input type="checkbox" class="mr-2">
                            <i class="fas fa-file-code text-green-500 mr-2"></i>
                            script.js
                        </td>
                        <td class="p-3">15 KB</td>
                        <td class="p-3">-rwxr-xr-x</td>
                        <td class="p-3">2024-06-23 09:15</td>
                        <td class="p-3">
                            <button class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></button>
                            <button class="text-red-500 hover:text-red-700 ml-2"><i class="fas fa-trash"></i></button>
                            <button class="text-green-500 hover:text-green-700 ml-2"><i
                                    class="fas fa-download"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>


</x-app-layout>
