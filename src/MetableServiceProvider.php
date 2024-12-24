<?php

namespace GIS\Metable;

use GIS\Metable\Helpers\MetaActionsManager;
use GIS\Metable\Livewire\Admin\Metas\IndexWire as MetaIndexWire;
use GIS\Metable\Livewire\Admin\Metas\PageWire as MetaPageWire;
use GIS\Metable\Models\Meta;
use GIS\Metable\Observers\MetaObserver;
use Illuminate\Support\Facades\Gate;
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

        $component = config("metable.customMetaPageComponent");
        Livewire::component(
            "ma-meta-pages",
            $component ?? MetaPageWire::class
        );

        // Наблюдатели
        $metaObserver = config("metable.customMetaObserver") ?? MetaObserver::class;
        $metaModel = config("metable.customMetaModel") ?? Meta::class;
        $metaModel::observe($metaObserver);

        // Policy
        $metaModel = config("metable.customMetaModel") ?? Meta::class;
        Gate::policy($metaModel, config("metable.metaPolicy"));

        // Добавить политики в конфигурацию
        $this->expandConfiguration();
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

        // Routes
        $this->loadRoutesFrom(__DIR__ . "/routes/admin.php");

        // Facades
        $this->app->singleton("meta-actions", function () {
            return new MetaActionsManager;
        });
    }

    private function expandConfiguration(): void
    {
        $um = app()->config["user-management"];
        $permissions = $um["permissions"];
        $ma = app()->config["metable"];
        $permissions[] = [
            "title" => $ma["metaPolicyTitle"],
            "policy" => $ma["metaPolicy"],
            "key" => $ma["metaPolicyKey"]
        ];
        app()->config["user-management.permissions"] = $permissions;
    }
}
