<?php

namespace App\Livewire;

use Livewire\Component;
use phpseclib3\Net\SSH2;

class FileManager extends Component
{
    public $directories = [];
    public $files = [];
    public $currentPath = '/var/www/html/';
    public $expandedFolders = [];
    public $isLoading = false;

    public function mount()
    {
        $this->listDirectories();
        $this->listFiles($this->currentPath);
    }

    public function listDirectories()
    {
        $this->isLoading = true;
        $ssh = $this->getSSHConnection();
        $result = $ssh->exec("find {$this->currentPath} -maxdepth 1 -type d");
        $dirs = explode("\n", trim($result));
        $this->directories = $this->buildDirectoryTree($dirs);
        $this->isLoading = false;
    }

    public function toggleDirectory($path)
    {
        $this->isLoading = true;
        if (isset($this->expandedFolders[$path])) {
            unset($this->expandedFolders[$path]);
        } else {
            $this->expandedFolders[$path] = true;
            $this->loadSubdirectories($path);
        }
        $this->isLoading = false;
    }

    public function loadSubdirectories($path)
    {
        $ssh = $this->getSSHConnection();
        $result = $ssh->exec("find {$path} -maxdepth 1 -type d");
        $dirs = explode("\n", trim($result));
        $subdirs = $this->buildDirectoryTree($dirs);

        $this->updateDirectoryStructure($path, $subdirs);
    }

    private function updateDirectoryStructure($path, $subdirs)
    {
        $parts = explode('/', trim(substr($path, strlen($this->currentPath)), '/'));
        $current = &$this->directories;
        foreach ($parts as $part) {
            if (!isset($current[$part])) {
                $current[$part] = ['name' => $part, 'path' => $path, 'children' => []];
            }
            $current = &$current[$part]['children'];
        }
        $current = $subdirs;
    }

    public function openDirectory($path)
    {
        $this->isLoading = true;
        $this->currentPath = $path;
        $this->listFiles($path);
        $this->isLoading = false;
    }

    public function listFiles($path)
    {
        $ssh = $this->getSSHConnection();
        $result = $ssh->exec("ls -la $path");
        $lines = explode("\n", trim($result));
        array_shift($lines); // Remove the total line

        $this->files = [];
        foreach ($lines as $line) {
            $parts = preg_split('/\s+/', $line, 9);
            if (count($parts) >= 9) {
                $this->files[] = [
                    'permissions' => $parts[0],
                    'name' => $parts[8],
                    'size' => $parts[4],
                    'modified' => $parts[5] . ' ' . $parts[6] . ' ' . $parts[7],
                    'isDirectory' => $parts[0][0] === 'd',
                ];
            }
        }
    }

    private function buildDirectoryTree($dirs)
    {
        $tree = [];
        foreach ($dirs as $dir) {
            if ($dir === $this->currentPath) continue; // Skip the root directory
            $path = substr($dir, strlen($this->currentPath));
            $parts = explode('/', trim($path, '/'));
            $name = end($parts);
            $fullPath = $dir . '/';
            $tree[$name] = [
                'name' => $name,
                'path' => $fullPath,
                'children' => [],
            ];
        }
        return $tree;
    }

    private function getSSHConnection()
    {
        $ssh = new SSH2('127.0.0.1', 22);
        if (!$ssh->login('hmpanel', 'password')) {
            throw new \Exception('Login failed');
        }
        return $ssh;
    }

    public function render()
    {
        return view('livewire.file-manager');
    }
}
