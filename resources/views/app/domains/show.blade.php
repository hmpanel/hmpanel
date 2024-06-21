<x-app-layout>
    <x-slot name="header">
        @lang('crud.domains.show_title')    </x-slot>


    <div class="container full-container py-5 flex flex-col gap-6">
        <x-partials.card>
            <x-slot name="title">
                <a href="{{ route('domains.index') }}" class="mr-4"><i class="mr-1 fa-duotone fa-arrow-left"></i></a>
            </x-slot>

            <div class="mt-4 px-4">
                <div class="mb-4">
                    <h5 class="font-medium text-gray-700">
                        @lang('crud.domains.inputs.name')
                    </h5>
                    <span>{{ $domain->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-10">
                <a href="{{ route('domains.index') }}" class="button">
                    <i class="mr-1 icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Domain::class)
                    <a href="{{ route('domains.create') }}" class="button">
                        <i class="mr-1 fa-duotone fa-circle-plus"></i>
                        @lang('crud.common.create')
                    </a>
                @endcan
            </div>
        </x-partials.card>
    </div>

</x-app-layout>
