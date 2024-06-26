<ul class="text-sm">
    @foreach($directories as $directory)
        <li class="mb-2" x-data="{ expanded: false }">
            <div class="flex items-center cursor-pointer">

                <i class="fas fa-chevron-right mr-2 text-gray-500" wire:click="toggleDirectory('{{ $directory['path'] }}')" x-show="!expanded" @click="expanded = !expanded"></i>
                <i class="fas fa-chevron-down mr-2 text-custom-blue" x-show="expanded" @click="expanded = !expanded"></i>

                <span wire:click.stop="openDirectory('{{ $directory['path'] }}')">
                    <i class="fas" :class="{
                        'fa-folder-open text-custom-blue': expanded,
                        'fa-folder text-yellow-500': !expanded
                    }"></i>
                    <span class="ml-1">{{ $directory['name'] }}</span>
                </span>

            </div>
            @if(!empty($directory['children']))
                <div x-show="expanded" class="ml-4 mt-1">
                    @include('livewire.partials._directory_tree', ['directories' => $directory['children']])
                </div>
            @endif
        </li>
    @endforeach
</ul>

