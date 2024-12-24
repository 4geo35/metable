<?php

use Illuminate\Support\Facades\Route;

Route::middleware(["web", "auth", "app-management"])
    ->prefix("admin")
    ->as("admin.")
    ->group(function () {
        Route::get("metas", function () {
            return view("ma::admin.metas.index");
        })->name("metas");
    });
