@foreach($directories as $directory)
    <li class="mb-2">
        <div class="flex items-center">
            @if(!empty($directory['children']))
                <i class="fas fa-chevron-right mr-1 cursor-pointer transform transition-transform duration-200 ease-in-out"
                   wire:click="toggleDirectory('{{ $directory['path'] }}')"
                   @if(isset($expandedFolders[$directory['path']]))
                   style="transform: rotate(90deg);"
                   @endif
                ></i>
            @else
                <span class="w-4 mr-1"></span>
            @endif
            <i class="fas fa-folder text-yellow-500 mr-1"></i>
            <span wire:click="openDirectory('{{ $directory['path'] }}')" class="cursor-pointer">
                {{ $directory['name'] }}
            </span>
        </div>
        @if(!empty($directory['children']) && isset($expandedFolders[$directory['path']]))
            <ul class="ml-4 mt-1">
                @include('livewire.partials.directory-tree', ['directories' => $directory['children']])
            </ul>
        @endif
    </li>
@endforeach
