<?php

use Illuminate\Support\Facades\Route;

Route::middleware(["web", "auth", "app-management"])
    ->prefix("admin")
    ->as("admin.")
    ->group(function () {
        $metaModelClass = config("metable.customMetaModel") ?? \GIS\Metable\Models\Meta::class;
        Route::get("metas", function () {
            return view("ma::admin.metas.index");
        })->name("metas")->middleware("can:viewAny,{$metaModelClass}");
    });
