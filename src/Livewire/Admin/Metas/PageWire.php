<?php

namespace GIS\Metable\Livewire\Admin\Metas;

use GIS\Metable\Models\Meta;
use GIS\Metable\Traits\MetaActionsTrait;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PageWire extends Component
{
    use MetaActionsTrait;

    public string $createPage = "";
    public string $createName = "";
    public string $createContent = "";
    public string $createProperty = "";
    public bool $createSeparated = false;

    public function render(): View
    {
        // TODO: check permission
        $metaModelClass = config("metable.customMetaModel") ?? Meta::class;
        $metas = $metaModelClass::query()
            ->whereNotNull("page")
            ->get()
            ->sortBy("page")
            ->groupBy("page");
        debugbar()->info($metas);
        return view('ma::livewire.admin.metas.page-wire', compact("metas"));
    }

    public function store(): void
    {
        // TODO: check permission
        $this->validate([
            "createPage" => ["required", "string", "max:250"],
            "createName" => ["required", "string", "max:250"],
            "createContent" => ["required", "string", "max:200"],
            "createProperty" => ["nullable", "string", "max:250"],
        ], [], [
            "createPage" => __("Page"),
            "createName" => "Name",
            "createContent" => "Content",
            "createProperty" => "Property",
        ]);

        $metaModelClass = config("metable.customMetaModel") ?? Meta::class;
        $metaModelClass::create([
            "page" => $this->createPage,
            "name" => $this->createName,
            "content" => $this->createContent,
            "property" => $this->createProperty,
            "separated" => $this->createSeparated ? now() : null,
        ]);

        session()->flash("metas-success", __("Meta tag successfully added"));
        $this->reset("createPage", "createName", "createContent", "createProperty", "createSeparated");
    }
}
