<div x-data="{
    initNotyf() {
        this.notyf = new Notyf({ dismissible: true });
    }
}" x-init="initNotyf()"
    @shownotification.window="notyf[$event.detail.type]($event.detail.message)"
    class="flex bg-white rounded-2xl overflow-hidden shadow">

    <!-- Sidebar with Directory Tree -->
    <div class="w-1/4 p-4 lg:block hidden bg-gray-50">
        <h2 class="text-lg font-semibold mb-4">File Manager</h2>
        <ul class="text-[13px]">
            <li>
                <button wire:click="changeDirectory('/')"
                    class="flex items-center w-full text-left p-2 rounded-md {{ $activeDirectory === '/' ? 'bg-gray-100' : 'hover:bg-gray-100' }}">
                    <i class="fa-light fa-folder-open mr-2 text-yellow-500 text-lg"></i>
                    public_html
                </button>
            </li>
        </ul>

        <ul class="h-[600px] overflow-auto text-[13px]">
            @include('livewire.partials.directory-tree', ['directories' => $directories])
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6 overflow-y-auto">


        <div class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 p-2 px-0  flex items-center space-x-1">
            <button wire:click="initiateOperation('move')"
                class="flex items-center space-x-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                <i class="fas fa-arrow-right fa-thin"></i>
                <span>Move</span>
            </button>
            <button wire:click="initiateOperation('copy')"
                class="flex items-center space-x-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                <i class="fas fa-copy fa-thin"></i>
                <span>Copy</span>
            </button>
            <button wire:click="openCreateFolderModal"
                class="flex items-center space-x-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                <i class="fas fa-folder-plus fa-thin"></i>
                <span>Create Folder</span>
            </button>
            <button wire:click="openCreateFileModal"
                class="flex items-center space-x-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                <i class="fas fa-file-plus fa-thin"></i>
                <span>Create File</span>
            </button>
            <button wire:click="openUploadModal"
                class="flex items-center space-x-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                <i class="fas fa-upload fa-thin"></i>
                <span>Upload</span>
            </button>
            <button wire:click="initiateZip"
                class="flex items-center space-x-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                <i class="fas fa-file-archive fa-thin"></i>
                <span>Zip</span>
            </button>
            <button wire:click="confirmDelete"
                class="flex items-center space-x-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-xs">
                <i class="fas fa-trash fa-thin"></i>
                <span>Delete</span>
            </button>
        </div>

        <div class="bg-white border-b p-2 px-0 flex items-center space-x-2">


            <button wire:click="goToPreviousDirectory"
                class="p-1 text-gray-600 hover:bg-gray-100 rounded {{ $currentHistoryIndex > 0 ? '' : 'opacity-50 cursor-not-allowed' }}"
                {{ $currentHistoryIndex > 0 ? '' : 'disabled' }}>
                <i class="fas fa-chevron-left"></i>
            </button>
            <button wire:click="goToNextDirectory"
                class="p-1 text-gray-600 hover:bg-gray-100 rounded {{ $currentHistoryIndex < count($directoryHistory) - 1 ? '' : 'opacity-50 cursor-not-allowed' }}"
                {{ $currentHistoryIndex < count($directoryHistory) - 1 ? '' : 'disabled' }}>
                <i class="fas fa-chevron-right"></i>
            </button>
            <button wire:click="goToParentDirectory"
                class="p-1 text-gray-600 hover:bg-gray-100 rounded {{ $currentPath !== '/' ? '' : 'opacity-50 cursor-not-allowed' }}"
                {{ $currentPath !== '/' ? '' : 'disabled' }}>
                <i class="fas fa-arrow-up"></i>
            </button>
            <button wire:click="reloadDirectory" class="p-1 text-gray-600 hover:bg-gray-100 rounded">
                <i class="fas fa-sync-alt"></i>
            </button>


            <div class="flex-1 bg-gray-100 rounded px-3 py-1 text-sm text-gray-600 flex items-center">
                <i class="fas fa-folder-open mr-2"></i>
                <span>
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center">
                            <button wire:click="changeDirectory('/')"
                                class="text-gray-800 hover:underline">public_html</button>
                        </li>

                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="flex items-center">
                                <svg class="w-3 h-3 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <button wire:click="changeDirectory('{{ $breadcrumb['path'] }}')"
                                    class="text-gray-800 hover:underline">
                                    {{ $breadcrumb['name'] }}
                                </button>
                            </li>
                        @endforeach

                    </ol>
                </span>
            </div>
            <div class="relative">
                <input type="text"
       wire:model.live="searchQuery"
       placeholder="Search"
       class="border-gray-200 rounded px-3 py-1 text-sm text-gray-600 pr-8">
                <i class="fas fa-search absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <div class="flex flex-col h-[570px]">
            <div class="flex-grow overflow-auto">
                <table class="relative w-full border text-[13px]">
                    <thead>
                        <tr class="text-gray-700 leading-normal">

                            <th class="sticky top-0 py-3 px-6 text-left bg-gray-200 max-w-[250px]">
                                <input type="checkbox" wire:click="toggleSelectAll" {{ $selectAll ? 'checked' : '' }}
                                    class="h-4 w-4 border border-gray-300 rounded text-blue-600 mr-2">

                                Name
                            </th>
                            <th class="sticky top-0 py-3 px-6 text-left bg-gray-200">Type</th>
                            <th class="sticky top-0 py-3 px-6 text-left bg-gray-200">Size</th>
                            <th class="sticky top-0 py-3 px-6 text-left bg-gray-200">Last Modified</th>
                            <th class="sticky top-0 py-3 px-6 text-right bg-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y bg-white">
                        @foreach ($files as $file)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">

                                <td class="py-3 px-6 text-left whitespace-nowrap max-w-[250px]">

                                    <input type="checkbox" wire:model="selectedItems" value="{{ $file['path'] }}"
                                        class="h-4 w-4 mb-1 border border-gray-300 rounded text-blue-600 mr-3" />

                                    @if ($file['type'] === 'directory')
                                        <button wire:click="changeDirectory('{{ $file['path'] }}')"
                                            class="text-gray-800 hover:underline">

                                            <i class="fa-light fa-folder mr-2 text-yellow-500 text-lg"></i>

                                            <span class="truncate max-w-[100px]">{{ $file['name'] }}</span>

                                        </button>
                                    @else
                                        <i class="fa-light fa-file mr-2 text-yellow-500 text-lg"></i>

                                        <span class="text-ellipsis  max-w-[100px]">{{ $file['name'] }}</span>
                                    @endif
                                </td>

                                <td class="py-3 px-6 text-left">{{ ucfirst($file['type']) }}</td>

                                <td class="py-3 px-6 text-left">
                                    @if ($file['type'] === 'file')
                                        {{ number_format($file['size'] / 1024, 2) }} KB
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-left">
                                    @if ($file['type'] === 'file')
                                        {{ date('F j, Y, g:i a', $file['lastModified']) }}
                                    @else
                                        -
                                    @endif
                                </td>


                                <td class="py-3 px-6 justify-end flex">

                                    <!-- Existing buttons -->
                                    @if ($file['type'] === 'file')
                                        <button wire:click="downloadFile('{{ $file['path'] }}')"
                                            class="flex items-center space-x-1 px-2 py-1 w-5 h-5 justify-center bg-green-500 hover:bg-green-700 text-white font-semibold  rounded transition-colors duration-300 mr-2">
                                            <i class="fas fa-arrow-down fa-thin"></i>
                                        </button>
                                    @endif


                                    <button wire:click="startRenaming('{{ $file['path'] }}')"
                                        class="flex items-center space-x-1 px-2 py-1 w-5 h-5 justify-center bg-green-500 hover:bg-green-700 text-white font-semibold rounded transition-colors duration-300 mr-2">
                                        <i class="fa-thin fa-i-cursor"></i>
                                    </button>


                                    @if ($file['type'] === 'file')
                                        <button wire:click="editFile('{{ $file['path'] }}')"
                                            class="flex items-center space-x-1 px-2 py-1 w-5 h-5 justify-center bg-green-500 hover:bg-green-700 text-white font-semibold  rounded transition-colors duration-300 mr-2">
                                            <i class="fas fa-edit fa-thin"></i>

                                        </button>
                                        @if (pathinfo($file['name'], PATHINFO_EXTENSION) === 'zip')
                                            <button wire:click="initiateUnzip('{{ $file['path'] }}')"
                                                class="flex items-center space-x-1 px-2 py-1 w-5 h-5 justify-center bg-green-500 hover:bg-green-700 text-white font-semibold  rounded transition-colors duration-300 mr-2">
                                                <i class="fas fa-folder-open fa-thin"></i>

                                            </button>
                                        @endif
                                    @endif
                                    <button wire:click="confirmDelete('{{ $file['path'] }}')"
                                        class="flex items-center space-x-1 px-2 py-1 w-5 h-5 justify-center bg-red-500 hover:bg-red-700 text-white font-semibold rounded transition-colors duration-300 mr-2">
                                        <i class="fas fa-trash fa-thin"></i>
                                    </button>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>





        <!-- Edit File Modal -->
        @if ($isEditModalOpen)
            <div x-data="editFileModal()" x-init="init" @close-modal.window="closeModal">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[999]">

                    <div class="relative top-20 mx-auto p-5 py-1 w-3/4 shadow-lg rounded-md bg-gray-800">

                       <div class="flex justify-between items-center mb-4">

                        <h3 class="text-lg text-white font-semibold">Editing: {{ basename($editingFile['path']) }}</h3>

                        <div class="flex justify-end mt-4">


                            <button @click="saveChanges"
                                class="bg-blue-700 text-white w-5 h-5 rounded-full hover:bg-blue-600 mr-2 text-[10px] flex items-center justify-center">
                                <i class="fa-light fa-save"></i>
                            </button>


                            <button @click="closeModal"
                                class="bg-red-600 text-white  w-5 h-5 rounded-full hover:bg-red-500 text-[10px] flex items-center justify-center">
                                <i class="fa-light fa-xmark"></i>
                            </button>


                        </div>

                       </div>

                        <div x-ref="editor" class="w-full h-[600px] mb-4 rounded-md overflow-hidden">

                        </div>

                    </div>
                </div>
            </div>
        @endif


        <!-- Unzip Modal -->
        @if ($showUnzipModal)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[999]">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <h3 class="text-lg font-semibold mb-4">Unzip File</h3>
                    <p class="mb-4">Unzipping: {{ basename($unzippingFile) }}</p>
                    <div class="mb-4">
                        <label for="unzipPath" class="block text-sm font-medium text-gray-700">Unzip to:</label>
                        <input wire:model.defer="unzipPath" type="text" id="unzipPath"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="flex justify-end">
                        <button wire:click="unzipFile"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2">Unzip</button>
                        <button wire:click="closeUnzipModal"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Move/Copy Modal -->
        @if ($showOperationModal)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[999]">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <h3 class="text-lg font-semibold mb-4">{{ ucfirst($operationType) }} Items</h3>
                    <div class="mb-4">
                        <label for="destinationPath"
                            class="block text-sm font-medium text-gray-700">Destination:</label>
                        <input wire:model.defer="destinationPath" type="text" id="destinationPath"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="flex justify-end">
                        <button wire:click="performOperation"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2">Confirm</button>
                        <button wire:click="closeOperationModal"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Create Folder Modal -->
        @if ($showCreateFolderModal)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[999]">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <h3 class="text-lg font-semibold mb-4">Create New Folder</h3>
                    <div class="mb-4">
                        <label for="newFolderName" class="block text-sm font-medium text-gray-700">Folder
                            Name:</label>
                        <input wire:model.defer="newFolderName" type="text" id="newFolderName"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('newFolderName')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end">

                        <button wire:click="createFolder"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2">Create</button>
                        <button wire:click="closeCreateFolderModal"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>


                    </div>
                </div>
            </div>
        @endif

        <!-- Create File Modal -->
        @if ($showCreateFileModal)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[999]">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <h3 class="text-lg font-semibold mb-4">Create New File</h3>
                    <div class="mb-4">
                        <label for="newFileName" class="block text-sm font-medium text-gray-700">File Name:</label>
                        <input wire:model.defer="newFileName" type="text" id="newFileName"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('newFileName')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="newFileContent" class="block text-sm font-medium text-gray-700">File
                            Content:</label>
                        <textarea wire:model.defer="newFileContent" id="newFileContent"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="5"></textarea>
                        @error('newFileContent')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button wire:click="createFile"
                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mr-2">Create</button>
                        <button wire:click="closeCreateFileModal"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                    </div>
                </div>
            </div>
        @endif

        @if ($showZipModal)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[999]">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <h3 class="text-lg font-semibold mb-4">Create Zip Archive</h3>
                    <div class="mb-4">
                        <label for="zipName" class="block text-sm font-medium text-gray-700">Zip Name:</label>
                        <input wire:model.defer="zipName" type="text" id="zipName"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('zipName')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button wire:click="createZip" wire:loading.attr="disabled" wire:target="createZip"
                            class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 mr-2 flex items-center">
                            <span wire:loading.remove wire:target="createZip">
                                Create Zip
                            </span>
                            <span wire:loading wire:target="createZip" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Creating...
                            </span>
                        </button>
                        <button wire:click="$set('showZipModal', false)" wire:loading.attr="disabled"
                            wire:target="createZip"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                    </div>
                </div>
            </div>
        @endif

        <!-- File Upload Modal -->
        @if ($showUploadModal)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[999]">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <h3 class="text-lg font-semibold mb-4">Upload File</h3>
                    <div class="mb-4">
                        <label for="uploadedFile" class="block text-sm font-medium text-gray-700">Choose file:</label>
                        <input type="file" wire:model="uploadedFile" id="uploadedFile" class="mt-1 block w-full">
                        @error('uploadedFile')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end">


                        <button wire:click="uploadFile" wire:loading.attr="disabled"
                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mr-2">
                            <span wire:loading wire:target="uploadFile" class="mr-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                            Upload
                        </button>


                        <button wire:click="closeUploadModal"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Rename Modal -->
        @if ($showRenameModal)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[999]">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <h3 class="text-lg font-semibold mb-4">Rename Item</h3>
                    <div class="mb-4">
                        <label for="newItemName" class="block text-sm font-medium text-gray-700">New Name:</label>
                        <input wire:model.defer="renamingItem.newName" type="text" id="newItemName"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('renamingItem.newName')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button wire:click="renameFile"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2">Rename</button>
                        <button wire:click="closeRenameModal"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                    </div>
                </div>
            </div>
        @endif


        @if ($showDeleteModal)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[999]">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <h3 class="text-lg font-semibold mb-4">Confirm Deletion</h3>
                    <p class="mb-4">
                        Are you sure you want to delete {{ count($itemsToDelete) }} item(s)?
                    </p>
                    <div class="flex justify-end">
                        <button wire:click="deleteItems"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mr-2">Delete</button>
                        <button wire:click="cancelDelete"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.3/theme/monokai.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/clike/clike.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/mode/multiplex.min.js"></script>


    <script>
        function editFileModal() {
            return {
                editor: null,
                init() {
                    this.$nextTick(() => {
                        if (!this.editor) {
                            this.editor = CodeMirror(this.$refs.editor, {
                                lineNumbers: true,
                                mode: "php",
                                htmlMode: true,
                                theme: 'monokai',
                                lineWrapping: true,
                                value: @this.editingFile.content
                            });
                            this.editor.on('change', () => {
                                @this.editingFile.content = this.editor.getValue();
                            });
                        }
                    });
                },
                saveChanges() {
                    if (this.editor) {
                        @this.editingFile.content = this.editor.getValue();
                        @this.call('updateFile');
                    }
                },
                closeModal() {
                    @this.call('closeEditModal');
                }
            }
        }
    </script>
@endpush
