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
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . "/database/migrations");

        $this->mergeConfigFrom(__DIR__ . "/config/metable.php", "metable");

        $this->loadJsonTranslationsFrom(__DIR__ . "/lang");

        $this->initFacades();
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . "/resources/views", "ma");

        $this->loadRoutesFrom(__DIR__ . "/routes/admin.php");

        // Добавить политики в конфигурацию
        $this->expandConfiguration();
        $this->observeModels();
        $this->setPolicies();

        $this->addLivewireComponents();
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

    protected function initFacades(): void
    {
        $this->app->singleton("meta-actions", function () {
            return new MetaActionsManager;
        });
    }

    protected function addLivewireComponents(): void
    {
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
    }

    protected function observeModels(): void
    {
        $metaObserver = config("metable.customMetaObserver") ?? MetaObserver::class;
        $metaModel = config("metable.customMetaModel") ?? Meta::class;
        $metaModel::observe($metaObserver);
    }

    protected function setPolicies(): void
    {
        $metaModel = config("metable.customMetaModel") ?? Meta::class;
        Gate::policy($metaModel, config("metable.metaPolicy"));
    }
}
