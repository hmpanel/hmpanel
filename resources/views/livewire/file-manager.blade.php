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
                                            @if (!$file['isDirectory'])
                                                <button
                                                    wire:click="openFileEditor('{{ $currentPath . $file['name'] }}')"
                                                    class="text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            @endif
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

    <!-- Ace Editor Modal -->
    @if ($showEditorModal)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Editing: {{ basename($editingFilePath) }}
                        </h3>
                        <div class="mt-2">
                            <div id="editor" style="height: 300px;"></div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="saveFile" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                        </button>
                        <button wire:click="$set('showEditorModal', false)" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Toast Notification -->
    <div x-data="{ show: false, message: '', type: 'success' }"
        x-on:show-toast.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => { show = false }, 3000)"
        x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="fixed bottom-5 right-5 bg-white border-t-4 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert"
        :class="{ 'border-green-500': type === 'success', 'border-red-500': type === 'error' }">
        <div class="flex">
            <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <path
                        d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                </svg></div>
            <div>
                <p class="font-bold" x-text="message"></p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            let editor;

            Livewire.on('initializeAceEditor', function(content) {
                if (!editor) {
                    editor = ace.edit("editor");
                    editor.setTheme("ace/theme/monokai");
                    editor.session.setMode("ace/mode/php");
                }
                editor.setValue(content, -1);
            });

            Livewire.on('showEditorModal', function() {
                if (editor) {
                    editor.resize();
                }
            });

            Livewire.on('getEditorContent', function() {
                if (editor) {
                    @this.set('editableFileContent', editor.getValue());
                }
            });
        });
    </script>
@endpush
