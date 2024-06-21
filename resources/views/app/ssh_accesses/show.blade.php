<x-app-layout>
    <x-slot name="header">
        @lang('crud.ssh_accesses.show_title')    </x-slot>
    <div class="container full-container py-5 flex flex-col gap-6">
        <x-partials.card>
            <x-slot name="title">
                <a href="{{ route('ssh-accesses.index') }}" class="mr-4"
                    ><i class="mr-1 fa-duotone fa-arrow-left"></i
                ></a>
            </x-slot>

            <div class="mt-4 px-4">
                <div class="mb-4">
                    <h5 class="font-medium text-gray-700">
                        @lang('crud.ssh_accesses.inputs.username')
                    </h5>
                    <span>{{ $sshAccess->username ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5 class="font-medium text-gray-700">
                        @lang('crud.ssh_accesses.inputs.web_app_id')
                    </h5>
                    <span
                        >{{ optional($sshAccess->webApp)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-10">
                <a href="{{ route('ssh-accesses.index') }}" class="button">
                    <i class="mr-1 icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\SshAccess::class)
                <a href="{{ route('ssh-accesses.create') }}" class="button">
                    <i class="mr-1 fa-duotone fa-circle-plus"></i>
                    @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </x-partials.card>
    </div>
</x-app-layout>
