<div x-data="{
    initNotyf() {
        this.notyf = new Notyf({ dismissible: true });
    }
}" x-init="initNotyf()"
    @shownotification.window="notyf[$event.detail.type]($event.detail.message)"
    class="flex h-screen bg-white rounded-2xl shadow">

    <!-- Sidebar with Directory Tree -->
    <div class="w-1/4 bg-white rounded-2xl p-4 shadow-md overflow-y-auto">
        <h2 class="text-lg font-semibold mb-4">Directory Tree</h2>
        <ul>
            <li>
                <button wire:click="changeDirectory('/')"
                    class="flex items-center w-full text-left p-2 rounded {{ $activeDirectory === '/' ? 'bg-blue-100' : 'hover:bg-gray-100' }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Root
                </button>
            </li>
            @include('livewire.partials.directory-tree', ['directories' => $directories])
        </ul>

        <!-- Create New Folder -->
        <div class="mt-6">
            <h3 class="font-semibold mb-2">Create New Folder</h3>
            <div class="flex">
                <input wire:model.defer="newFolderName" type="text" class="flex-grow mr-2 p-2 border rounded"
                    placeholder="Folder name">
                <button wire:click="createFolder"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create</button>
            </div>
            @error('newFolderName')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6 overflow-y-auto">

        <div class="mb-6 flex justify-between">
            <h1 class="text-2xl font-bold mb-4">File Manager</h1>


            <div>
                <button>
                    <i class="fa-solid fa-plus"></i>
                </button>


                <button>
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
            </div>
        </div>


        <!-- Breadcrumbs -->
        <nav class="text-sm mb-4">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <button wire:click="changeDirectory('/')" class="text-gray-800 hover:underline">Root</button>
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
        </nav>

        <!-- File Upload -->
        <div class="mb-6">


            <input type="file" wire:model="uploadedFile" class="mb-2">
            <button wire:click="uploadFile"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Upload</button>
            @error('uploadedFile')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col h-[400px]">
            <div class="flex-grow overflow-auto">
                <table class="relative w-full border">
                    <thead>
                        <tr class="text-gray-700 uppercase text-sm leading-normal">
                            <th class="sticky top-0 py-3 px-6 text-left bg-gray-200">Name</th>
                            <th class="sticky top-0 py-3 px-6 text-left bg-gray-200">Type</th>
                            <th class="sticky top-0 py-3 px-6 text-left bg-gray-200">Size</th>
                            <th class="sticky top-0 py-3 px-6 text-left bg-gray-200">Last Modified</th>
                            <th class="sticky top-0 py-3 px-6 text-right bg-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y bg-white">
                        @foreach ($files as $file)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    @if ($renamingFile && $renamingFile['oldPath'] === $file['path'])
                                        <input wire:model.defer="renamingFile.newName" type="text"
                                            class="border rounded p-1">
                                        <button wire:click="renameFile"
                                            class="text-green-500 hover:underline ml-2">Save</button>
                                    @else
                                        @if ($file['type'] === 'directory')
                                            <button wire:click="changeDirectory('{{ $file['path'] }}')"
                                                class="text-gray-800 hover:underline">

                                                <i
                                                    class="material-symbols-outlined mr-2 !font-light text-yellow-500 !text-[18px]">folder</i>

                                                {{ $file['name'] }}
                                            </button>
                                        @else
                                            <i
                                                class="material-symbols-outlined mr-2 !font-light text-yellow-500 !text-[18px]">insert_drive_file</i>


                                            {{ $file['name'] }}
                                        @endif
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
                                        {{ date('Y-m-d H:i:s', $file['lastModified']) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-right">
                                    <button wire:click="startRenaming('{{ $file['path'] }}')"
                                        class="text-yellow-500 hover:underline mr-2">Rename</button>
                                    @if ($file['type'] === 'file')
                                        <button wire:click="editFile('{{ $file['path'] }}')"
                                            class="text-yellow-500 hover:underline mr-2">Edit</button>
                                        @if (pathinfo($file['name'], PATHINFO_EXTENSION) === 'zip')
                                            <button wire:click="initiateUnzip('{{ $file['path'] }}')"
                                                class="text-purple-500 hover:underline mr-2">
                                                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2">
                                                    </path>
                                                </svg>
                                                Unzip
                                            </button>
                                        @endif
                                    @endif
                                    <button
                                        wire:click="{{ $file['type'] === 'file' ? 'deleteFile' : 'deleteFolder' }}('{{ $file['path'] }}')"
                                        class="text-red-500 hover:underline">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>




        <div class="mt-6">
            <h3 class="font-semibold mb-2">Create New File</h3>
            <input wire:model.defer="newFileName" type="text" class="w-full mb-2 p-2 border rounded"
                placeholder="File name">
            @error('newFileName')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <textarea wire:model.defer="newFileContent" class="w-full h-32 mb-2 p-2 border rounded" placeholder="File content"></textarea>
            @error('newFileContent')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <button wire:click="createFile" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create
                File</button>
        </div>

        <!-- Edit File Modal -->
        @if ($isEditModalOpen)
            <div x-data="editFileModal()" x-init="init" @close-modal.window="closeModal">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[999]">

                    <div class="flex justify-end mt-4">
                        <button @click="saveChanges"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2">Save</button>
                        <button @click="closeModal"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                    </div>

                    <div class="relative top-20 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white">
                        <h3 class="text-lg font-semibold mb-4">Editing: {{ basename($editingFile['path']) }}</h3>

                        <div x-ref="editor" class="w-full vh-80 mb-4"></div>

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
