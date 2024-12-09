<?php

namespace GIS\Metable;

use GIS\Metable\Helpers\MetaActionsManager;
use GIS\Metable\Livewire\MetaIndexWire;
use GIS\Metable\Models\Meta;
use GIS\Metable\Observers\MetaObserver;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class MetableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Подключение views.
        $this->loadViewsFrom(__DIR__ . "/resources/views", "ma");

        // Livewire
        $component = config("metable.customMetaIndexComponent");
        Livewire::component(
            "ma-metas",
            $component ?? MetaIndexWire::class
        );

        // Наблюдатели
        $metaObserver = config("metable.customMetaObserver") ?? MetaObserver::class;
        $metaModel = config("metable.customMetaModel") ?? Meta::class;
        $metaModel::observe($metaObserver);
    }

    public function register(): void
    {
        // Миграции
        $this->loadMigrationsFrom(__DIR__ . "/database/migrations");

        // Подключение конфигурации
        $this->mergeConfigFrom(
            __DIR__ . "/config/metable.php", "metable"
        );

        // Подключение переводов
        $this->loadJsonTranslationsFrom(__DIR__ . "/lang");

        // Facades
        $this->app->singleton("meta-actions", function () {
            return new MetaActionsManager;
        });
    }
}
