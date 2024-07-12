<x-app-layout>
    <x-slot name="header">
        @lang('crud.web_apps.index_title')
    </x-slot>


    <div class="container full-container py-5 flex flex-col gap-6">
        <x-partials.card>
            <div class="mb-4 mt-4">
                <div class="flex flex-wrap justify-between px-4">

                    <div>

                        <form
                            class="-right-[6px] bg-gray-50 border flex focus-within:border-gray-300 p-1 pl-2 py-1 rounded-md">

                            <input
                                class="bg-transparent border-0 focus:outline-none focus:ring-0 font-semibold pr-4 px-0 py-0 text-[13px] w-full"
                                name="search" value="" placeholder="Search..." autocomplete="off">

                            <button
                                class="bg-blue-600 active:bg-blue-800 border border-transparent disabled:cursor-not-allowed disabled:opacity-50 duration-150 ease-in-out flex flex-row font-medium items-center justify-center px-2 py-1.5 rounded-md text-base text-white tracking-wide transition">

                                <i class="fa-light fa-magnifying-glass text-[13px]"></i>
                            </button>

                        </form>

                    </div>

                    <div class="md:w-1/2 text-right">
                        @can('create', App\Models\WebApp::class)
                            <a href="{{ route('web-apps.create') }}"
                                class=" text-white bg-blue-600 active:bg-blue-800 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                <i class="fa-light fa-plus mr-2"></i> @lang('crud.common.create')
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
                            <tr
                                class="hover:bg-gray-50 {{ $loop->last ? '' : 'border-b' }} {{ $loop->index % 2 !== 0 ? 'bg-gray-50' : '' }}">
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
                                                <button type="button" class="w-[25px] h-[25px] text-[12px] bg-gray-200 text-gray-500 hover:bg-blue-600 hover:text-white rounded-md">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            </a>

                                            {{-- file manager --}}
                                            <a href="{{ route('filemanager', $webApp) }}" class="mr-1">
                                                <button type="button" class="w-[25px] h-[25px] text-[12px] bg-gray-200 text-gray-500 hover:bg-blue-600 hover:text-white rounded-md">
                                                    <i class="fa-regular fa-folder-open"></i>
                                                </button>
                                            </a>
                                            @endcan @can('view', $webApp)
                                            <a href="{{ route('web-apps.show', $webApp) }}" class="mr-1">
                                                <button type="button" class="w-[25px] h-[25px] text-[12px] bg-gray-200 text-gray-500 hover:bg-blue-600 hover:text-white rounded-md">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </a>
                                            @endcan @can('delete', $webApp)
                                            <form action="{{ route('web-apps.destroy', $webApp) }}" method="POST"
                                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-[25px] h-[25px] text-[12px] bg-gray-200 text-gray-500 hover:bg-blue-600 hover:text-white rounded-md">
                                                    <i class="fa-regular fa-trash-can"></i>
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

                </table>




            </div>




        </x-partials.card>


        <div class=px-4">
            {!! $webApps->render() !!}
        </div>

    </div>
</x-app-layout>
