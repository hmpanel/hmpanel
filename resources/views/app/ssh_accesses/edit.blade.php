<x-app-layout>
    <x-slot name="header">
        @lang('crud.ssh_accesses.edit_title')    </x-slot>
    <div class="container full-container py-5 flex flex-col gap-6">
        <x-partials.card>
            <x-slot name="title">
                <a href="{{ route('ssh-accesses.index') }}" class="mr-4"
                    ><i class="mr-1 fa-duotone fa-arrow-left"></i
                ></a>
            </x-slot>

            <x-form
                method="PUT"
                action="{{ route('ssh-accesses.update', $sshAccess) }}"
                class="mt-4"
            >
                @include('app.ssh_accesses.form-inputs')

                <div class="mt-10">
                    <a
                        href="{{ route('ssh-accesses.index') }}"
                        class="button"
                    >
                        <i
                            class="fa-duotone fa-arrow-turn-down-left mr-1"
                        ></i>
                        @lang('crud.common.back')
                    </a>

                    <a
                        href="{{ route('ssh-accesses.create') }}"
                        class="button"
                    >
                        <i class="mr-1 fa-duotone fa-circle-plus text-primary"></i>
                        @lang('crud.common.create')
                    </a>

                    <button
                        type="submit"
                        class="button button-primary float-right"
                    >
                        <i class="fa-duotone fa-floppy-disks mr-1"></i>
                        @lang('crud.common.update')
                    </button>
                </div>
            </x-form>
        </x-partials.card>
    </div>
</x-app-layout>
