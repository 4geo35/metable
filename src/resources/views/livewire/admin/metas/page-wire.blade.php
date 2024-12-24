<div class="row">
    <div class="col w-full">
        <div class="card">
            <div class="card-body">
                <div class="space-y-indent-half">
                    @can("create", config("metable.customMetaModel") ?? \GIS\Metable\Models\Meta::class)
                        @include("ma::admin.metas.includes.page-create")
                    @endcan
                    <x-tt::notifications.error prefix="metas-" />
                    <x-tt::notifications.success prefix="metas-" />
                </div>
            </div>

            @include("ma::admin.metas.includes.page-table")
            @include("ma::admin.metas.includes.meta-table-modals")
        </div>
    </div>
</div>
