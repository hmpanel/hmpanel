<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.web_apps.index_title')
        </h2>
    </x-slot>


    <div class="container full-container py-5 flex flex-col gap-6">
        <x-partials.card>
            <div class="mb-5 mt-4">
                <div class="flex flex-wrap justify-between">
                    <div class="md:w-1/2">
                        <form>
                            <div class="flex items-center w-full">
                                <x-inputs.text name="search" value="{{ $search ?? '' }}"
                                    placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>

                                <div class="ml-1">
                                    <button type="submit" class="button button-primary">
                                        <i class="fa-duotone fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="md:w-1/2 text-right">
                        @can('create', App\Models\WebApp::class)
                            <a href="{{ route('web-apps.create') }}" class="button button-primary">
                                <i class="mr-1 fa-duotone fa-circle-plus"></i>
                                @lang('crud.common.create')
                            </a>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="block w-full overflow-auto scrolling-touch">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.web_apps.inputs.name')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.web_apps.inputs.path')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.web_apps.inputs.domain_id')
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @forelse($webApps as $webApp)
                            <tr class="hover:bg-gray-50 {{ $loop->last ? '' : 'border-b' }} {{ $loop->index % 2 !== 0 ? 'bg-gray-50' : '' }}">
                                <td class="px-4 py-3 text-left">
                                    {{ $webApp->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $webApp->path ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($webApp->domain)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center" style="width: 134px;">
                                    <div role="group" aria-label="Row Actions"
                                        class="
                                        relative
                                        inline-flex
                                        align-middle
                                    ">
                                        @can('update', $webApp)
                                            <a href="{{ route('web-apps.edit', $webApp) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="fa-duotone fa-pen-to-square"></i>
                                                </button>
                                            </a>
                                            @endcan @can('view', $webApp)
                                            <a href="{{ route('web-apps.show', $webApp) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="fa-duotone fa-eye"></i>
                                                </button>
                                            </a>
                                            @endcan @can('delete', $webApp)
                                            <form action="{{ route('web-apps.destroy', $webApp) }}" method="POST"
                                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="button">
                                                    <i
                                                        class="fa-duotone fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-2 text-center">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="p-2 text-center">
                                <div class="mt-10 px-4">
                                    {!! $webApps->render() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </x-partials.card>
    </div>
</x-app-layout>



