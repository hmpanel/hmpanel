

@foreach ($directories as $directory)
    <li>
        <div class="flex items-center">
            <button wire:click="toggleDirectory('{{ $directory['path'] }}')" class="flex items-center hover:bg-gray-100 p-1 rounded-full h-6 w-6 justify-center">
                @if ($directory['isExpanded'] ?? false)
                    <i class="fa-light fa-chevron-down text-sm"></i>
                @else
                    <i class="fa-light fa-chevron-right text-sm"></i>
                @endif
            </button>
            <button wire:click="changeDirectory('{{ $directory['path'] }}')"
                    class="flex-grow text-left p-2 rounded {{ $activeDirectory === $directory['path'] ? 'text-blue-600' : 'hover:text-blue-600' }}">
                @if ($directory['isExpanded'] ?? false)
                    <i class="fa-solid fa-folder-open mr-2 text-yellow-500 text-lg"></i>
                @else
                    <i class="fa-solid fa-folder mr-2 text-yellow-500 text-lg"></i>
                @endif
                {{ $directory['name'] }}
            </button>
        </div>
        @if (($directory['isExpanded'] ?? false) && !empty($directory['children']))
            <ul class="ml-4">
                @include('livewire.partials.directory-tree', ['directories' => $directory['children']])
            </ul>
        @endif
    </li>
@endforeach
