<?php

namespace GIS\Metable\Livewire\Admin\Metas;

use GIS\Metable\Models\Meta;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PageWire extends Component
{
    public string $createPage = "";
    public string $createName = "";
    public string $createContent = "";
    public string $createProperty = "";
    public bool $createSeparated = false;

    public function render(): View
    {
        return view('ma::livewire.admin.metas.page-wire');
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

        session()->flash("success", __("Meta tag successfully added"));
        $this->reset("createPage", "createName", "createContent", "createProperty", "createSeparated");
    }
}
