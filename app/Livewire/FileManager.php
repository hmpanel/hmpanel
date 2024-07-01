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

    public $newFolderName = '';
    public $newFileName = '';
    public $newFileContent = '';
    public $editingFile = [
        'path' => null,
        'content' => null
    ];
    public $renamingFile = null;
    public $uploadedFile;
    public $uploadProgress = 0;

    public $isEditModalOpen = false;

    public $activeDirectory = '/';


    public $showUnzipModal = false;
    public $unzippingFile = null;
    public $unzipPath = '';

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
    }

    public function loadContents()
    {
        $this->files = collect(Storage::files($this->currentPath))
            ->map(function ($file) {
                return [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => Storage::size($file),
                    'lastModified' => Storage::lastModified($file),
                    'type' => 'file'
                ];
            });

        $directories = collect(Storage::directories($this->currentPath))
            ->map(function ($directory) {
                return [
                    'name' => basename($directory),
                    'path' => $directory,
                    'type' => 'directory'
                ];
            });

        $this->files = $directories->concat($this->files);

        $this->directories = $this->buildDirectoryTree('/');
    }

    private function buildDirectoryTree($path)
    {
        $directories = collect(Storage::directories($path))
            ->map(function ($directory) {
                $relativePath = str_replace(Storage::path(''), '', $directory);
                return [
                    'name' => basename($directory),
                    'path' => $relativePath,
                    'isExpanded' => str_starts_with($this->currentPath, $relativePath),
                    'children' => $this->buildDirectoryTree($directory)
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
                    'path' => $path
                ];
            });
    }

    public function changeDirectory($path)
    {
        $this->currentPath = $path;
        $this->activeDirectory = $path;
        $this->loadContents();
        $this->updateBreadcrumbs();
    }

    public function goBack()
    {
        $parentDir = dirname($this->currentPath);
        $this->changeDirectory($parentDir === '\\' ? '/' : $parentDir);
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

    public function startRenaming($path)
    {
        $this->renamingFile = [
            'oldPath' => $path,
            'newName' => basename($path),
        ];
    }

    public function renameFile()
    {
        try {
            if ($this->renamingFile) {
                $newPath = dirname($this->renamingFile['oldPath']) . '/' . $this->renamingFile['newName'];
                if (Storage::move($this->renamingFile['oldPath'], $newPath)) {
                    $this->dispatch('showNotification', ['message' => 'File renamed successfully', 'type' => 'success']);
                    $this->renamingFile = null;
                    $this->loadContents();
                } else {
                    throw new \Exception('Failed to rename file');
                }
            }
        } catch (\Exception $e) {
            $this->handleError('Error renaming file: ' . $e->getMessage());
        }
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

    public function uploadFile()
    {
        try {
            $this->validate([
                'uploadedFile' => 'required|file|max:10240', // 10MB max
            ]);

            $fileName = $this->uploadedFile->getClientOriginalName();
            if ($this->uploadedFile->storeAs($this->currentPath, $fileName)) {
                $this->dispatch('showNotification', ['message' => 'File uploaded successfully', 'type' => 'success']);
            } else {
                throw new \Exception('Failed to upload file');
            }
            $this->uploadedFile = null;
            $this->loadContents();
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

        $zip = new ZipArchive;
        $res = $zip->open(Storage::path($this->unzippingFile));

        if ($res === TRUE) {
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
