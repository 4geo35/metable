@can('viewAny', config("metable.customMetaModel") ?? \GIS\Metable\Models\Meta::class)
    <x-tt::admin-menu.item href="{{ route('admin.metas') }}"
                           :active="\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.metas'">
        <x-slot name="ico"><x-ma::ico.tag /></x-slot>
        Metas
    </x-tt::admin-menu.item>
@endcan
