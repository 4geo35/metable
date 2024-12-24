
<div class="row">
    <div class="col w-full">
        @can('viewAny', config("metable.customMetaModel") ?? \GIS\Metable\Models\Meta::class)
            <div class="card">
                <div class="card-header border-b-0">
                    <div class="space-y-indent-half">
                        <div class="flex justify-between items-center">
                            <h2 class="font-medium text-2xl">{{ __("Meta tags") }}</h2>
                            @can('create', config("metable.customMetaModel") ?? \GIS\Metable\Models\Meta::class)
                                @include("ma::admin.metas.includes.meta-search")
                            @endcan
                        </div>
                        <x-tt::notifications.error prefix="metas-" />
                        <x-tt::notifications.success prefix="metas-" />
                    </div>
                </div>

                @include("ma::admin.metas.includes.meta-table")
                @include("ma::admin.metas.includes.meta-table-modals")
            </div>
        @endcan
    </div>
</div>
