<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FileManager extends Component
{
    use WithFileUploads;

    public $currentPath = '/';
    public $files = [];
    public $directories = [];
    public $breadcrumbs = [];

    public $showCreateFolderModal = false;
    public $showCreateFileModal = false;
    public $newFolderName = '';
    public $newFileName = '';
    public $newFileContent = '';

    public $editingFile = [
        'path' => null,
        'content' => null,
    ];

    public $isEditModalOpen = false;

    public $activeDirectory = '/';

    public $showUnzipModal = false;
    public $unzippingFile = null;
    public $unzipPath = '';

    public $selectedItems = [];
    public $showOperationModal = false;
    public $operationType = '';
    public $destinationPath = '';

    public $showUploadModal = false;
    public $uploadedFile;

    public $showZipModal = false;
    public $zipName = '';

    public $selectAll = false;

    public $showRenameModal = false;
    public $renamingItem = null;

    public $showDeleteModal = false;

    public $itemsToDelete = [];

    public $directoryHistory = [];
    public $currentHistoryIndex = -1;

    public $searchQuery = '';

    public function confirmDelete($paths = null)
    {
        if ($paths) {
            $this->itemsToDelete = is_array($paths) ? $paths : [$paths];
        } else {
            $this->itemsToDelete = $this->selectedItems;
        }

        if (empty($this->itemsToDelete)) {
            $this->dispatch('showNotification', ['message' => 'No items selected for deletion', 'type' => 'error']);
            return;
        }

        $this->showDeleteModal = true;
    }

    public function deleteItems()
    {
        if (empty($this->itemsToDelete)) {
            return;
        }

        $successCount = 0;
        $failCount = 0;

        foreach ($this->itemsToDelete as $path) {
            try {
                if (is_dir(Storage::path($path))) {
                    if (Storage::deleteDirectory($path)) {
                        $successCount++;
                    } else {
                        $failCount++;
                    }
                } else {
                    if (Storage::delete($path)) {
                        $successCount++;
                    } else {
                        $failCount++;
                    }
                }
            } catch (\Exception $e) {
                $failCount++;
                $this->handleError('Error deleting item: ' . $e->getMessage());
            }
        }

        if ($successCount > 0) {
            $this->dispatch('showNotification', [
                'message' => "$successCount item(s) deleted successfully" . ($failCount > 0 ? ", $failCount failed" : ''),
                'type' => 'success',
            ]);
        } else {
            $this->dispatch('showNotification', ['message' => 'Failed to delete items', 'type' => 'error']);
        }

        $this->showDeleteModal = false;
        $this->itemsToDelete = [];
        $this->selectedItems = [];
        $this->loadContents();
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->itemsToDelete = [];
    }

    public function startRenaming($path)
    {
        $this->renamingItem = [
            'oldPath' => $path,
            'newName' => basename($path),
        ];
        $this->showRenameModal = true;
    }

    public function toggleSelectAll()
    {
        $this->selectAll = !$this->selectAll;
        if ($this->selectAll) {
            $this->selectedItems = collect($this->files)
                ->pluck('path')
                ->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function updatedSelectedItems()
    {
        $this->selectAll = count($this->selectedItems) === count($this->files);
    }

    public function downloadFile($path)
    {
        if (Storage::exists($path)) {
            return response()->download(Storage::path($path));
        } else {
            $this->handleError('File not found');
        }
    }

    public function createZip()
    {
        $this->validate([
            'zipName' => 'required|string|min:1',
        ]);

        $zipPath = $this->currentPath . '/' . $this->zipName . '.zip';
        $zip = new ZipArchive();

        if ($zip->open(Storage::path($zipPath), ZipArchive::CREATE) === true) {
            foreach ($this->selectedItems as $item) {
                $this->addToZip($zip, $item, basename($item));
            }

            $zip->close();
            $this->dispatch('showNotification', ['message' => 'Zip file created successfully', 'type' => 'success']);
        } else {
            $this->handleError('Failed to create zip file');
        }

        $this->showZipModal = false;
        $this->zipName = '';
        $this->selectedItems = [];
        $this->loadContents();
    }
    public function initiateZip()
    {
        if (empty($this->selectedItems)) {
            $this->handleError('No items selected for zipping');
            return;
        }
        $this->showZipModal = true;
    }

    private function addToZip($zip, $path, $zipPath)
    {
        if (is_file(Storage::path($path))) {
            $zip->addFile(Storage::path($path), $zipPath);
        } elseif (is_dir(Storage::path($path))) {
            $zip->addEmptyDir($zipPath);
            $files = Storage::files($path);
            $directories = Storage::directories($path);

            foreach ($files as $file) {
                $this->addToZip($zip, $file, $zipPath . '/' . basename($file));
            }

            foreach ($directories as $directory) {
                $this->addToZip($zip, $directory, $zipPath . '/' . basename($directory));
            }
        }
    }

    public function initiateOperation($type)
    {
        $this->operationType = $type;
        $this->destinationPath = $this->currentPath;
        $this->showOperationModal = true;
    }

    public function closeOperationModal()
    {
        $this->showOperationModal = false;
    }

    public function performOperation()
    {
        $this->validate([
            'destinationPath' => 'required|string',
        ]);

        if (count($this->selectedItems) === 0) {
            $this->handleError('No items selected');
            return;
        }

        if (in_array($this->destinationPath, $this->selectedItems)) {
            $this->handleError('Cannot ' . $this->operationType . ' into a selected folder');
            return;
        }

        foreach ($this->selectedItems as $path) {
            $newPath = $this->destinationPath . '/' . basename($path);

            if ($this->operationType === 'move') {
                if (!Storage::move($path, $newPath)) {
                    $this->handleError('Failed to move ' . basename($path));
                    continue;
                }
            } elseif ($this->operationType === 'copy') {
                if (is_dir(Storage::path($path))) {
                    if (!$this->copyDirectory($path, $newPath)) {
                        $this->handleError('Failed to copy ' . basename($path));
                        continue;
                    }
                } else {
                    if (!Storage::copy($path, $newPath)) {
                        $this->handleError('Failed to copy ' . basename($path));
                        continue;
                    }
                }
            }
        }

        $this->dispatch('showNotification', ['message' => 'Operation completed successfully', 'type' => 'success']);
        $this->selectedItems = [];
        $this->destinationPath = '';
        $this->operationType = '';
        $this->showOperationModal = false; // Close the modal
        $this->loadContents();
    }

    private function copyDirectory($from, $to)
    {
        $directoryContents = Storage::allFiles($from);

        foreach ($directoryContents as $item) {
            $newPath = $to . '/' . substr($item, strlen($from) + 1);
            if (!Storage::copy($item, $newPath)) {
                return false;
            }
        }

        return true;
    }

    public function initiateUnzip($filePath)
    {
        $this->unzippingFile = $filePath;
        $this->unzipPath = $this->currentPath;
        $this->showUnzipModal = true;
    }

    public function closeUnzipModal()
    {
        $this->showUnzipModal = false;
        $this->unzippingFile = null;
        $this->unzipPath = '';
    }

    public function mount()
    {
        $this->loadContents();
        $this->updateBreadcrumbs();
        $this->directoryHistory = [$this->currentPath];
        $this->currentHistoryIndex = 0;
        $this->directories = $this->buildDirectoryTree('/');
    }

    public function updatedSearchQuery()
    {
        $this->loadContents();
    }

    public function loadContents()
    {
        $allFiles = collect(Storage::files($this->currentPath));
        $allDirectories = collect(Storage::directories($this->currentPath));

        if (!empty($this->searchQuery)) {
            $searchLower = strtolower($this->searchQuery);
            $allFiles = $allFiles->filter(function ($file) use ($searchLower) {
                return str_contains(strtolower(basename($file)), $searchLower);
            });
            $allDirectories = $allDirectories->filter(function ($directory) use ($searchLower) {
                return str_contains(strtolower(basename($directory)), $searchLower);
            });
        }

        $this->files = $allFiles->map(function ($file) {
            return [
                'name' => basename($file),
                'path' => $file,
                'size' => Storage::size($file),
                'lastModified' => Storage::lastModified($file),
                'type' => 'file',
            ];
        });

        $directories = $allDirectories->map(function ($directory) {
            return [
                'name' => basename($directory),
                'path' => $directory,
                'type' => 'directory',
            ];
        });

        $this->files = $directories
            ->concat($this->files)
            ->values()
            ->all();
    }

    private function buildDirectoryTree($path)
    {
        $directories = collect(Storage::directories($path))->map(function ($directory) {
            $relativePath = str_replace(Storage::path(''), '', $directory);
            return [
                'name' => basename($directory),
                'path' => $relativePath,
                'isExpanded' => str_starts_with($this->currentPath, $relativePath),
                'children' => $this->buildDirectoryTree($directory),
            ];
        });

        return $directories->toArray();
    }

    public function updateBreadcrumbs()
    {
        $path = '';
        $this->breadcrumbs = collect(explode('/', $this->currentPath))
            ->filter()
            ->map(function ($segment) use (&$path) {
                $path .= '/' . $segment;
                return [
                    'name' => $segment,
                    'path' => $path,
                ];
            });
    }

    public function changeDirectory($path)
    {
        // Remove any forward history when changing to a new directory
        if ($this->currentHistoryIndex < count($this->directoryHistory) - 1) {
            $this->directoryHistory = array_slice($this->directoryHistory, 0, $this->currentHistoryIndex + 1);
        }

        $this->currentPath = $path;
        $this->activeDirectory = $path;
        $this->directoryHistory[] = $path;
        $this->currentHistoryIndex = count($this->directoryHistory) - 1;

        $this->loadContents();
        $this->updateBreadcrumbs();
    }

    public function goToPreviousDirectory()
    {
        if ($this->currentHistoryIndex > 0) {
            $this->currentHistoryIndex--;
            $this->currentPath = $this->directoryHistory[$this->currentHistoryIndex];
            $this->activeDirectory = $this->currentPath;
            $this->loadContents();
            $this->updateBreadcrumbs();
        }
    }

    public function goToNextDirectory()
    {
        if ($this->currentHistoryIndex < count($this->directoryHistory) - 1) {
            $this->currentHistoryIndex++;
            $this->currentPath = $this->directoryHistory[$this->currentHistoryIndex];
            $this->activeDirectory = $this->currentPath;
            $this->loadContents();
            $this->updateBreadcrumbs();
        }
    }

    public function goToParentDirectory()
    {
        $parentDir = dirname($this->currentPath);
        if ($parentDir !== '/' || $this->currentPath !== '/') {
            $this->changeDirectory($parentDir === '\\' ? '/' : $parentDir);
        }
    }

    public function reloadDirectory()
    {
        $this->loadContents();
    }

    public function toggleDirectory($path)
    {
        $this->directories = $this->updateDirectoryExpansion($this->directories, $path);
    }

    private function updateDirectoryExpansion($directories, $targetPath)
    {
        return array_map(function ($dir) use ($targetPath) {
            if ($dir['path'] === $targetPath) {
                $dir['isExpanded'] = !($dir['isExpanded'] ?? false);
            }
            if (!empty($dir['children'])) {
                $dir['children'] = $this->updateDirectoryExpansion($dir['children'], $targetPath);
            }
            return $dir;
        }, $directories);
    }

    public function openCreateFolderModal()
    {
        $this->showCreateFolderModal = true;
    }

    public function closeCreateFolderModal()
    {
        $this->showCreateFolderModal = false;
        $this->newFolderName = '';
    }

    public function openCreateFileModal()
    {
        $this->showCreateFileModal = true;
    }

    public function closeCreateFileModal()
    {
        $this->showCreateFileModal = false;
        $this->newFileName = '';
        $this->newFileContent = '';
    }

    public function createFolder()
    {
        $this->validate([
            'newFolderName' => 'required|min:1|max:255',
        ]);

        $newPath = $this->currentPath . '/' . $this->newFolderName;
        if (Storage::makeDirectory($newPath)) {
            $this->dispatch('showNotification', ['message' => 'Folder created successfully', 'type' => 'success']);
            $this->newFolderName = '';
            $this->loadContents();
            $this->closeCreateFolderModal();
        } else {
            $this->handleError('Failed to create folder');
        }
    }

    public function createFile()
    {
        $this->validate([
            'newFileName' => 'required|min:1|max:255',
            'newFileContent' => 'required',
        ]);

        $newPath = $this->currentPath . '/' . $this->newFileName;
        if (Storage::put($newPath, $this->newFileContent)) {
            $this->dispatch('showNotification', ['message' => 'File created successfully', 'type' => 'success']);
            $this->newFileName = '';
            $this->newFileContent = '';
            $this->loadContents();
            $this->closeCreateFileModal();
        } else {
            $this->handleError('Failed to create file');
        }
    }

    public function editFile($path)
    {
        $this->editingFile = [
            'path' => $path,
            'content' => Storage::get($path) ?? '',
        ];
        $this->isEditModalOpen = true;
    }

    public function updateFile()
    {
        try {
            if ($this->editingFile && isset($this->editingFile['path']) && isset($this->editingFile['content'])) {
                Storage::put($this->editingFile['path'], $this->editingFile['content']);
                $this->closeEditModal();
                $this->dispatch('showNotification', ['message' => 'File updated successfully', 'type' => 'success']);
            } else {
                throw new \Exception('Invalid file data');
            }
        } catch (\Exception $e) {
            $this->handleError('Error updating file: ' . $e->getMessage());
        }
    }

    public function closeEditModal()
    {
        $this->isEditModalOpen = false;
        $this->editingFile = null;
        $this->loadContents();
        $this->dispatch('close-modal');
    }

    public function renameFile()
    {
        $this->validate([
            'renamingItem.newName' => 'required|string|min:1',
        ]);

        try {
            $newPath = dirname($this->renamingItem['oldPath']) . '/' . $this->renamingItem['newName'];
            if (Storage::move($this->renamingItem['oldPath'], $newPath)) {
                $this->dispatch('showNotification', ['message' => 'Item renamed successfully', 'type' => 'success']);
                $this->closeRenameModal();
                $this->loadContents();
            } else {
                throw new \Exception('Failed to rename item');
            }
        } catch (\Exception $e) {
            $this->handleError('Error renaming item: ' . $e->getMessage());
        }
    }

    public function closeRenameModal()
    {
        $this->showRenameModal = false;
        $this->renamingItem = null;
    }
    public function deleteFile($path)
    {
        try {
            if (Storage::delete($path)) {
                $this->dispatch('showNotification', ['message' => 'File deleted successfully', 'type' => 'success']);
            } else {
                throw new \Exception('Failed to delete file');
            }
            $this->loadContents();
        } catch (\Exception $e) {
            $this->handleError('Error deleting file: ' . $e->getMessage());
        }
    }

    public function deleteFolder($path)
    {
        try {
            if (Storage::deleteDirectory($path)) {
                $this->dispatch('showNotification', ['message' => 'Folder deleted successfully', 'type' => 'success']);
            } else {
                throw new \Exception('Failed to delete folder');
            }
            $this->loadContents();
        } catch (\Exception $e) {
            $this->handleError('Error deleting folder: ' . $e->getMessage());
        }
    }

    public function openUploadModal()
    {
        $this->showUploadModal = true;
    }

    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->uploadedFile = null;
    }

    public function uploadFile()
    {
        $this->validate([
            'uploadedFile' => 'required|file|max:10240', // 10MB max
        ]);

        try {
            $fileName = $this->uploadedFile->getClientOriginalName();
            if ($this->uploadedFile->storeAs($this->currentPath, $fileName)) {
                $this->dispatch('showNotification', ['message' => 'File uploaded successfully', 'type' => 'success']);
                $this->loadContents();
                $this->closeUploadModal();
            } else {
                throw new \Exception('Failed to upload file');
            }
        } catch (\Exception $e) {
            $this->handleError('Error uploading file: ' . $e->getMessage());
        }
    }

    public function showUnzipModal($filePath)
    {
        $this->unzippingFile = $filePath;
        $this->unzipPath = $this->currentPath;
        $this->showUnzipModal = true;
    }

    public function unzipFile()
    {
        $this->validate([
            'unzipPath' => 'required|string',
        ]);

        $zip = new ZipArchive();
        $res = $zip->open(Storage::path($this->unzippingFile));

        if ($res === true) {
            $extractPath = Storage::path($this->unzipPath);
            $zip->extractTo($extractPath);
            $zip->close();
            $this->dispatch('showNotification', ['message' => 'File unzipped successfully', 'type' => 'success']);
        } else {
            $this->dispatch('showNotification', ['message' => 'Failed to unzip file', 'type' => 'error']);
        }

        $this->showUnzipModal = false;
        $this->unzippingFile = null;
        $this->unzipPath = '';
        $this->loadContents();
    }

    public function handleError($message)
    {
        $this->dispatch('showNotification', ['message' => $message, 'type' => 'error']);
        \Log::error($message);
    }

    public function render()
    {
        return view('livewire.file-manager');
    }
}
