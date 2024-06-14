<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.ftp_accounts.show_title')
        </h2>
    </x-slot>


    <div class="container full-container py-5 flex flex-col gap-6">
        <x-partials.card>
            <x-slot name="title">
                <a href="{{ route('ftp-accounts.index') }}" class="mr-4"><i
                        class="mr-1 fa-duotone fa-arrow-left"></i></a>
            </x-slot>

            <div class="mt-4 px-4">
                <div class="mb-4">
                    <h5 class="font-medium text-gray-700">
                        @lang('crud.ftp_accounts.inputs.username')
                    </h5>
                    <span>{{ $ftpAccount->username ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5 class="font-medium text-gray-700">
                        @lang('crud.ftp_accounts.inputs.web_app_id')
                    </h5>
                    <span>{{ optional($ftpAccount->webApp)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-10">
                <a href="{{ route('ftp-accounts.index') }}" class="button">
                    <i class="mr-1 icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\FtpAccount::class)
                    <a href="{{ route('ftp-accounts.create') }}" class="button">
                        <i class="mr-1 fa-duotone fa-circle-plus"></i>
                        @lang('crud.common.create')
                    </a>
                @endcan
            </div>
        </x-partials.card>
    </div>

</x-app-layout>
