<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left"><span class="text-nowrap">{{ __("Render tag") }}</span></x-tt::table.heading>
            <x-tt::table.heading class="text-left"><span class="text-nowrap">{{ __("Create og") }}</span></x-tt::table.heading>
            <x-tt::table.heading>{{ __("Actions") }}</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($metas as $item)
            <tr>
                <td>
                    <code class="text-[#d63384] text-sm text-nowrap">
                        {!! htmlspecialchars($item->clear_render) !!}
                    </code>
                </td>
                <td>{{ $item->separated ? __("No") : __("Yes") }}</td>
                <td>
                    <div class="flex justify-center">
                        <button type="button" class="btn btn-dark px-btn-x-ico rounded-e-none"
                                @can("update", $item) wire:loading.attr="disabled"
                                @else disabled
                                @endcan
                                wire:click="showEdit({{ $item->id }})">
                            <x-tt::ico.edit />
                        </button>
                        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                                @can("delete", $item) wire:loading.attr="disabled"
                                @else disabled
                                @endcan
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash />
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
