<x-app-layout>
    <x-slot name="header">
        @lang('crud.web_apps.show_title')    </x-slot>

    <div class="container full-container py-5 flex flex-col gap-6">
        <x-partials.card>
            <x-slot name="title">
                <a href="{{ route('web-apps.index') }}" class="mr-4"
                    ><i class="mr-1 fa-duotone fa-arrow-left"></i
                ></a>
            </x-slot>

            <div class="mt-4 px-4">
                <div class="mb-4">
                    <h5 class="font-medium text-gray-700">
                        @lang('crud.web_apps.inputs.name')
                    </h5>
                    <span>{{ $webApp->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5 class="font-medium text-gray-700">
                        @lang('crud.web_apps.inputs.path')
                    </h5>
                    <span>{{ $webApp->path ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5 class="font-medium text-gray-700">
                        @lang('crud.web_apps.inputs.domain_id')
                    </h5>
                    <span
                        >{{ optional($webApp->domain)->name ?? '-' }}</span
                    >
                </div>
            </div>

            <div class="mt-10">
                <a href="{{ route('web-apps.index') }}" class="button">
                    <i class="mr-1 icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\WebApp::class)
                <a href="{{ route('web-apps.create') }}" class="button">
                    <i class="mr-1 fa-duotone fa-circle-plus"></i>
                    @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </x-partials.card>
    </div>
</x-app-layout>
